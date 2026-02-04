<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '果実フリマもぎたて')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
        <h1>🍎 果実フリマもぎたて</h1>
        <p>新鮮な果実を今すぐチェック！</p>
    </header>

    <nav>
        <a href="{{ route('products.index') }}">商品一覧</a>
        <a href="{{ route('products.register') }}">商品登録</a>
    </nav>

    <main>
        @yield('content')
    </main>
</body>
</html>
