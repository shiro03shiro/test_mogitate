@extends('layouts.app')

@section('content')
<div class="body">
    <h1>商品一覧</h1>
    <div class="product-list">
        @foreach($products as $product)
        <div class="product-item">
            <h3>{{ $product['name'] }}</h3>
            <p>¥{{ number_format($product['price']) }}</p>
            <a href="{{ route('products.detail', $product['id']) }}">詳細</a>
        </div>
        @endforeach
    </div>
    <a href="{{ route('products.register') }}">商品登録</a>
</div>
@endsection


