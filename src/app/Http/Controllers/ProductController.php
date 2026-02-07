<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; 
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

    public function create()
    {
        return view('products.register', ['seasons' => Season::all()]);
    }

    public function store(Request $request) // FormRequest外す
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0|max:10000',
            'image' => 'required|image|mimes:png,jpeg',
            'seasons' => 'required|array|min:1',
            'seasons.*' => 'exists:seasons,id',
            'description' => 'required|string|max:120',
        ], [
            'name.required' => '商品名を入力してください',
            'price.required' => '値段を入力してください',
            'image.required' => '画像を登録してください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
        ]);

        if ($validator->fails()) {
            // 画像を一時保存
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('temp/products', 'public');
                $request->session()->flash('temp_image', $imagePath);
            }
            
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // 正常保存
        $data = $request->validated();
        $data['image_path'] = $request->session()->get('temp_image');
        Product::create($data);
        
        return redirect()->route('products.index');
    }
}
