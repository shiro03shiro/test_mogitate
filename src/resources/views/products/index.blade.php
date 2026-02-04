<!DOCTYPE html>
<html>
<head>
    <title>果実フリマもぎたて - 商品一覧</title>
    <meta charset="UTF-8">
</head>
<body>
    <h1>🍎 果実フリマもぎたて</h1>
    <h2>商品一覧</h2>
    <div>
        @foreach($products as $product)
        <div style="border: 1px solid #ccc; margin: 10px; padding: 10px;">
            <h3>{{ $product['name'] }}</h3>
            <p>¥{{ number_format($product['price']) }}</p>
            <a href="{{ route('products.detail', $product['id']) }}">詳細</a>
        </div>
        @endforeach
    </div>
    <p><a href="{{ route('products.register') }}">+ 新規商品登録</a></p>
</body>
</html>