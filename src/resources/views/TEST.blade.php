<!-- index.blade.php -->

@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="body">
    <div class="section__title">
    <h2>商品一覧</h2>
</div>
<form class="search-form">
    @csrf
    <div class="search-form__item">
        <input class="search-form__item-input" type="text" placeholder="商品名で検索"/>
    </div>
    <div class="search-form__button">
        <button class="search-form__button-submit" type="submit">検索</button>
    </div>
        <div class="search-form__item">
            <h3>価格順で表示</h3>
        <select class="search-form__item-select">
            <option value="">価格で並べ替え</option>
        </select>
    </div>

</form>





    <div class="product-list">
        @foreach($products as $product)
        <div class="product-item">
            <p>{{ $product['name'] }}</p>
            <p>¥{{ number_format($product['price']) }}</p>
            <a href="{{ route('products.detail', $product['id']) }}">詳細</a>
        </div>
        @endforeach
    </div>
    <a href="{{ route('products.register') }}">＋商品を追加</a>
</div>
@endsection













<!-- ProductsController_index() -->

    public function index()
    {
        $products = [
            ['id' => 1, 'name' => 'りんご', 'price' => 150, 'description' => '新鮮なりんご'],
            ['id' => 2, 'name' => 'みかん', 'price' => 100, 'description' => '甘いみかん'],
        ];
        return view('products.index', compact('products'));
    }

