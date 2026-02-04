@extends('layouts.app')

@section('content')
<h1>{{ $product['name'] }}</h1>
<p>価格：¥{{ number_format($product['price']) }}</p>
<p>{{ $product['description'] }}</p>
<a href="{{ route('products.index') }}">一覧に戻る</a>
@endsection
