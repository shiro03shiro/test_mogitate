<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();
        $search = $request->get('search');
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }
        $sort = $request->get('sort');
        if ($sort === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($sort === 'price_desc') {
            $query->orderBy('price', 'desc');
        }
        $products = $query->paginate(6)->withQueryString();
        return view('products.index', compact('products', 'search', 'sort'));
    }

    public function detail(Product $product)
    {
        $seasons = Season::all();
        return view('products.detail', compact('product', 'seasons'));
    }

    public function register()
    {
        $seasons = Season::all();
        return view('products.register', compact('seasons'));
    }

    public function create()
    {
        return view('products.register', ['seasons' => Season::all()]);
    }

    public function store(ProductRequest $request)
    {
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data = $request->validated();
            $data['image'] = $path;
            $product = Product::create($data);
            if ($request->has('seasons')) {
                $product->seasons()->attach($request->seasons);
            }
        }
        return redirect()->route('products.index');
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }
        $product->update($data);
        $product->seasons()->detach();
        if ($request->has('seasons')) {
            $product->seasons()->attach($request->seasons);
        }
        return redirect()->route('products.detail', $product->id)
            ->with('success', '商品情報を更新しました');
    }

    public function delete($productId)
    {
        $product = Product::findOrFail($productId);
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        $product->seasons()->detach();
        $product->delete();
        return redirect()->route('products.index')->with('success', '商品を削除しました');
    }

    public function deleteForm($productId)
    {
        $product = Product::findOrFail($productId);
        return view('products.delete', compact('product'));
}
}
