@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/products-detail.css') }}">
@endsection

@section('content')
<div class="product-detail-container editing">
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
        <span class="current">{{ old('name', $product->name) }}</span>
    </div>

    {{-- 編集可能フォーム（常時） --}}
    <form id="productForm" action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        {{-- メインコンテンツ --}}
        <div class="product-main">
            {{-- 画像エリア（修正済み） --}}
            <div class="product-image">
                {{-- プレビュー画像 --}}
                @if($product->image_url)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-image__img">
                @else
                    <div class="no-image">プレビュー画像なし</div>
                @endif
                {{-- ファイル選択（1つだけ） --}}
                <div class="file-field">
                    <input type="file" name="image" id="imageInput" accept="image/png,image/jpeg">
                    <span class="file-name">{{ basename($product->image ?? '')}}</span>
                </div>
            </div>

            <div class="product-info">
                {{-- 商品名 --}}
                <div class="form-group">
                    <label>商品名 <span style="color:red;">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" class="form-display" required>
                </div>

                {{-- 価格 --}}
                <div class="form-group">
                    <label>値段 <span style="color:red;">*</span></label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" class="form-display" min="0" max="10000" required>
                </div>

                {{-- 季節（チェックボックス常時表示） --}}
                <div class="form-group season">
                    <label>季節 <span style="color:red;">*</span></label>
                    <div class="season-options">
                        @foreach($seasons as $season)
                            <label style="cursor:pointer;">
                                <input type="checkbox" name="seasons[]" value="{{ $season->id }}"
                                    {{ $product->seasons->contains($season->id) || in_array($season->id, old('seasons', [])) ? 'checked' : '' }}>
                                {{ $season->name }}
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="product-extra">
            {{-- 商品説明 --}}
            <div class="form-group description">
                <label>商品説明 <span style="color:red;">*</span></label>
                <textarea name="description" class="form-display" rows="5" required>{{ old('description', $product->description) }}</textarea>
            </div>
        </div>
    </form>
</div>

{{-- ボタンエリア（常時表示） --}}
<div class="action-buttons">
    <div class="btn-group">
        <a href="{{ route('products.index') }}" class="btn btn-back">一覧に戻る</a>
            <button type="submit" form="productForm" class="btn btn-save primary">変更を保存</button>
    </div>
        <form action="{{ route('products.delete', $product->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('本当に{{ $product->name }}を削除しますか？')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-delete delete">🗑 削除</button>
        </form>
</div>
@endsection
