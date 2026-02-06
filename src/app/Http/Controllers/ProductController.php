<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function detail($productId)
    {
        $product = Product::findOrFail($productId);
        return view('products.detail', compact('product'));
    }

    public function register()
    {
        return view('products.register');
    }

    public function store(Request $request)
    {
        // 仮実装（後でDB化）
        $name = $request->input('name');
        $price = $request->input('price');

        // ダンプして確認
        dd('登録成功！', ['name' => $name, 'price' => $price]);

        return redirect()->route('products.index');
    }

}
