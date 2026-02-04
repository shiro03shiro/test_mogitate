@extends('layouts.app')

@section('content')
<h1>商品登録</h1>
<form method="POST" action="{{ route('products.store') }}">
    @csrf
    <div>
        <label>商品名</label>
        <input type="text" name="name" required>
    </div>
    <div>
        <label>価格</label>
        <input type="number" name="price" required>
    </div>
    <button type="submit">登録</button>
</form>
<a href="{{ route('products.index') }}">一覧に戻る</a>
@endsection
