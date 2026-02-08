@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/products-detail.css') }}">
<style>
.editing input, .editing textarea, .editing .season-options input {
    border: 2px solid #f5c800 !important;
    background: white;
}
.error { color: red; margin-bottom: 20px; }
.success { color: green; margin-bottom: 20px; }
.file-input { display: none; }
</style>
@endsection

@section('content')
<div class="product-detail-container">
    {{-- 成功メッセージ --}}
    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif
    {{-- バリデーションエラー --}}
    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 更新フォーム（常に編集可能） --}}
    <form id="productForm" action="{{ route('products.update', $product) }}"
        method="POST" enctype="multipart/form-data" class="editing">
        @csrf
        @method('PUT')
        {{-- パンくず --}}
        <div class="breadcrumb">
            <a href="{{ route('products.index') }}" class="link">商品一覧</a> ＞
            <span class="current">{{ old('name', $product->name) }}</span>
        </div>

        {{-- メインコンテンツ --}}
        <div class="product-main">
            {{-- 商品画像 --}}
            <div class="product-image">
                <img src="{{ $product->image_url }}" alt="{{ old('name', $product->name) }}"
                    class="product-image__img">
            </div>

            <div class="product-info">
                {{-- 商品名 --}}
                <div class="form-group">
                    <label>商品名 <span style="color:red;">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}"
                        class="form-display" required>
                </div>

                {{-- 値段 --}}
                <div class="form-group">
                    <label>値段 <span style="color:red;">*</span></label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}"
                        class="form-display" min="0" max="10000" required>
                </div>

                {{-- 季節 --}}
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
            {{-- 画像選択 --}}
            <div class="file-field">
                <input type="file" name="image" id="imageInput" accept="image/png,image/jpeg">
                <label for="imageInput" class="btn">画像を変更</label>
                <span class="file-name">{{ basename($product->image ?? '') ?: '画像未設定' }}</span>
            </div>

            {{-- 商品説明 --}}
            <div class="form-group description">
                <label>商品説明 <span style="color:red;">*</span></label>
                <textarea name="description" class="form-display" rows="5" required>{{ old('description', $product->description) }}</textarea>
            </div>
        </div>
    </form>

    {{-- アクションボタン --}}
    <div class="action-buttons">
        <div class="btn-group">
            <a href="{{ route('products.index') }}" class="btn btn-back">一覧に戻る</a>
            <button type="submit" form="productForm" class="btn btn-save primary">変更を保存</button>
        </div>
        {{-- 削除フォーム --}}
        <form action="{{ route('products.delete', $product) }}" method="POST"
            onsubmit="return confirm('本当に{{ $product->name }}を削除しますか？')"
            style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-delete delete">🗑 削除</button>
        </form>
    </div>
</div>
@endsection
