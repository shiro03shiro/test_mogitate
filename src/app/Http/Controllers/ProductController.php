<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = [
            ['id' => 1, 'name' => 'りんご', 'price' => 150, 'description' => '新鮮なりんご'],
            ['id' => 2, 'name' => 'みかん', 'price' => 100, 'description' => '甘いみかん'],
        ];
        return view('products.index', compact('products'));
    }

    public function detail($productId)
    {
        $product = ['id' => $productId, 'name' => 'りんご', 'price' => 150, 'description' => '詳細：新鮮なりんごです。'];
        return view('products.detail', compact('product'));
    }

    public function register()
    {
        return view('products.register');
    }
}
