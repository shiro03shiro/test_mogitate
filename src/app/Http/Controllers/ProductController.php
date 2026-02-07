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
            Product::create($data);
        }
        return redirect()->route('products.index');
    }
}
