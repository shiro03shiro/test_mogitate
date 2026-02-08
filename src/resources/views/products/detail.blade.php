@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/products-detail.css') }}">
@endsection

@section('content')
<div class="product-detail-container">
    {{-- メッセージ --}}
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
        <span class="current">{{ $product->name ?? '商品詳細' }}</span>
    </div>

    {{-- 編集モード判定（修正） --}}
    @php 
        $isEditing = auth()->user()?->can('update', $product ?? null) && request()->routeIs('products.update.edit');
        // 安全にシーズンIDを取得
        $productSeasons = $product && isset($product->seasons) ? $product->seasons->pluck('id')->toArray() : [];
    @endphp
    
    @if($isEditing)
        <form id="productForm" action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" class="editing">
            @csrf @method('PUT')
    @endif

    {{-- メインコンテンツ --}}
    <div class="product-main">
        {{-- 画像（より安全） --}}
        <div class="product-image">
            @if($product->image_url)
                <img src="{{ $product->image_url }}" alt="{{ $product->name ?? '' }}" class="product-image__img" 
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="no-image" style="display:none;">画像読み込みエラー</div>
            @else
                <div class="no-image">画像なし</div>
            @endif
        </div>

        <div class="product-info">
            {{-- 商品名 --}}
            <div class="form-group">
                <label>商品名 <span style="color:red;">*</span></label>
                @if($isEditing)
                    <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" class="form-display" required>
                @else
                    <div class="form-display readonly">{{ $product->name ?? '未設定' }}</div>
                @endif
            </div>

            {{-- 価格 --}}
            <div class="form-group">
                <label>値段 <span style="color:red;">*</span></label>
                @if($isEditing)
                    <input type="number" name="price" value="{{ old('price', $product->price ?? 0) }}" class="form-display" min="0" max="10000" required>
                @else
                    <div class="form-display readonly">{{ isset($product->price) && $product->price ? number_format($product->price) . '円' : '未設定' }}</div>
                @endif
            </div>

            {{-- 季節（さらに安全化） --}}
            <div class="form-group season">
                <label>季節 <span style="color:red;">*</span></label>
                <div class="season-options">
                    @forelse($seasons ?? [] as $season)
                        @if(isset($season->id) && isset($season->name))
                            @if($isEditing)
                                <label style="cursor:pointer;">
                                    <input type="checkbox" name="seasons[]" value="{{ $season->id }}"
                                        {{ in_array($season->id, $productSeasons) || in_array($season->id, old('seasons', [])) ? 'checked' : '' }}>
                                    {{ $season->name }}
                                </label>
                            @else
                                <span>
                                    {{ $season->name }} 
                                    {{ in_array($season->id, $productSeasons) ? '●' : '' }}
                                </span>
                            @endif
                        @endif
                    @empty
                        <span>季節情報なし</span>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="product-extra">
        {{-- 説明 --}}
        <div class="form-group description">
            <label>商品説明 <span style="color:red;">*</span></label>
            @if($isEditing)
                <textarea name="description" class="form-display" rows="5" required>{{ old('description', $product->description ?? '') }}</textarea>
            @else
                <div class="form-display readonly">{{ $product->description ?? '未設定' }}</div>
            @endif
        </div>
    </div>

    @if($isEditing)
        </form>
    @endif
</div>

{{-- アクションボタン --}}
<div class="action-buttons">
    <div class="btn-group">
        <a href="{{ route('products.index') }}" class="btn btn-back">一覧に戻る</a>
        @if(auth()->user()?->can('update', $product ?? null))
            @if($isEditing)
                <button type="submit" form="productForm" class="btn btn-save primary">変更を保存</button>
                <a href="{{ route('products.detail', $product->id) }}" class="btn btn-secondary">キャンセル</a>
            @else
                <a href="{{ route('products.update.edit', $product->id) }}" class="btn btn-warning">編集</a>
            @endif
        @endif
    </div>
    
    @if(auth()->user()?->can('delete', $product ?? null))
        <form action="{{ route('products.delete', $product) }}" method="POST"
            onsubmit="return confirm('本当に{{ $product->name ?? '' }}を削除しますか？')" style="display: inline;">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-delete delete">🗑 削除</button>
        </form>
    @endif
</div>
@endsection
