@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/products-detail.css') }}">
@endsection

@section('content')
<div class="product-detail-container editing">
    <div class="breadcrumb">
        <a href="{{ route('products.index') }}" class="link">商品一覧</a> ＞
        <span class="current">{{ old('name', $product->name) }}</span>
    </div>

    <form id="productForm" action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="product-main">
            <div class="product-image">
                @if($product->image_url)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-image__img">
                @else
                    <div class="no-image">プレビュー画像なし</div>
                @endif
                <div class="file-field">
                    <input type="file" name="image" id="imageInput" accept="image/png,image/jpeg">
                    <span class="file-name">{{ basename($product->image ?? '')}}</span>
                </div>
            </div>

            <div class="product-info">
                <div class="form-group">
                    <label>商品名</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" class="form-display">
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>値段</label>
                    <input type="text" name="price" value="{{ old('price', $product->price) }}" class="form-display">
                    @error('price')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group season">
                    <label>季節</label>
                    <div class="season-options">
                        @foreach($seasons as $season)
                            <label style="cursor:pointer;">
                                <input type="checkbox" name="seasons[]" value="{{ $season->id }}"
                                    {{ $product->seasons->contains($season->id) || in_array($season->id, old('seasons', [])) ? 'checked' : '' }}>
                                {{ $season->name }}
                            </label>
                        @endforeach
                    </div>
                    @error('seasons')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="product-extra">
            {{-- 商品説明 --}}
            <div class="form-group description">
                <label>商品説明</label>
                <textarea name="description" class="form-display" rows="4">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </form>
</div>

<div class="action-buttons">
    <div class="btn-group">
        <a href="{{ route('products.index') }}" class="btn btn-back">戻る</a>
            <button type="submit" form="productForm" class="btn btn-save primary">変更を保存</button>
    </div>
        <form action="{{ route('products.delete', $product->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('本当に{{ $product->name }}を削除しますか？')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-delete delete">🗑</button>
        </form>
</div>
@endsection
