<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();
        
        // 検索
        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%");
        }
        
        // ソート
        if ($sort = $request->get('sort')) {
            if ($sort === 'price_asc') {
                $query->orderBy('price', 'asc');
            } elseif ($sort === 'price_desc') {
                $query->orderBy('price', 'desc');
            }
        }
        
        $products = $query->paginate(6);
        return view('products.index', compact('products'));
    }

    public function detail($productId)
    {
        $product = Product::findOrFail($productId);
        return view('products.detail', compact('product'));
    }

    public function register()
    {
        $seasons = Season::all();
        return view('products.register', compact('seasons'));
    }

    public function store(ProductRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($data);
        $product->seasons()->sync($request->input('seasons'));

        return redirect()->route('products.index')
            ->with('success', '商品を登録しました！');
    }
}
