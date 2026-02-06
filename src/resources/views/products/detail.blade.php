@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/products-detail.css') }}">
@endsection

@section('content')
{{-- 🚫 .body 削除でヘッダー正常化 --}}
<div class="product-detail-container">
  {{-- パンくずリスト --}}
  <div class="breadcrumb">
    <a href="{{ route('products.index') }}" class="link">商品一覧</a> ＞
    <span class="current">{{ $product->name }}</span>
  </div>

  <div class="product-main">
    {{-- 左側：商品画像 --}}
    <div class="product-image">
      <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-image__img">
    </div>

    {{-- 右側：商品情報 --}}
    <div class="product-info">
      <div class="form-group">
        <label>商品名</label>
        <div class="form-display">{{ $product->name }}</div>
      </div>

      <div class="form-group">
        <label>値段</label>
        <div class="form-display">¥{{ number_format($product->price) }}</div>
      </div>

      <div class="form-group season">
        <label>季節</label>
        <div class="season-options">
          <label><input type="checkbox" disabled {{ $product->seasons->contains('name', '春') ? 'checked' : '' }}> 春</label>
          <label><input type="checkbox" disabled {{ $product->seasons->contains('name', '夏') ? 'checked' : '' }}> 夏</label>
          <label><input type="checkbox" disabled {{ $product->seasons->contains('name', '秋') ? 'checked' : '' }}> 秋</label>
          <label><input type="checkbox" disabled {{ $product->seasons->contains('name', '冬') ? 'checked' : '' }}> 冬</label>
        </div>
      </div>
    </div>
  </div>

  <div class="product-extra">
    <div class="file-field">
      <button class="btn">ファイルを選択</button>
      <span class="file-name">{{ basename($product->image ?? '') ?: pathinfo(parse_url($product->image_url, PHP_URL_PATH)['path'], PATHINFO_BASENAME) }}</span>
    </div>

    <div class="form-group description">
      <label>商品説明</label>
      <div class="form-display main-width">{{ $product->description }}</div>
    </div>

    <div class="action-buttons">
        <div class="btn-group">
            <a href="{{ route('products.index') }}" class="btn btn-back">戻る</a>
            <button class="btn btn-save primary">変更を保存</button>
        </div>
        <button class="btn btn-delete delete">🗑</button>
    </div>
  </div>
</div>
@endsection
