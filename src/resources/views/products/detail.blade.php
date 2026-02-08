@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/products-detail.css') }}">
@endsection

@section('content')
<div class="product-detail-container">
    {{-- 成功・エラーメッセージ --}}
    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- パンくず --}}
    <div class="breadcrumb">
        <a href="{{ route('products.index') }}" class="link">商品一覧</a> ＞
        <span class="current">{{ $product->name }}</span>
    </div>

    {{-- 編集権限チェック & フォーム開始 --}}
    @can('update', $product)
        @if(request()->routeIs('products.update.edit'))
            {{-- 編集モード：フォーム開始 --}}
            <form id="productForm" action="{{ route('products.update', $product) }}"
                method="
