@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="body">
    <div class="main-container">
        <div class="main-left">
            <div class="section__title">
                @if(!empty($search))
                    <h2>「{{ $search }}」の商品一覧</h2>
                @else
                    <h2>商品一覧</h2>
                @endif
            </div>
            <form class="search-form" method="GET" action="{{ route('products.search') }}">
                <div class="search-form__item">
                    <input class="search-form__item-input"
                        type="text" name="q"
                        placeholder="商品名で検索"
                        value="{{ $search ?? request('q') }}">
                </div>
                <div class="search-form__button">
                    <button class="search-form__button-submit" type="submit">検索</button>
                </div>
                <div class="search-form__item">
                    <h3>価格順で表示</h3>
                    <select class="search-form__item-select" name="sort" onchange="this.form.submit()">
                        <option value="">価格で並べ替え</option>
                        <option value="price_asc" {{ ($sort ?? request('sort')) == 'price_asc' ? 'selected' : '' }}>安い順に表示</option>
                        <option value="price_desc" {{ ($sort ?? request('sort')) == 'price_desc' ? 'selected' : '' }}>高い順に表示</option>
                    </select>
                </div>
            </form>
            @if(!empty($sort))
                @php
                    $sortText = $sort === 'price_asc' ? '安い順に表示' : '高い順に表示';
                @endphp
                <div class="sort-reset-container">
                    <a href="{{ route('products.index') }}" class="sort-reset-btn">
                        <span class="sort-reset-text">{{ $sortText }}</span>
                        <span class="sort-reset-icon">✕</span>
                    </a>
                </div>
            @endif
            <hr class="divider">
        </div>
        <div class="main-right">
            <div class="add-product">
                <a href="{{ route('products.register') }}" class="add-product__btn">＋商品を追加</a>
            </div>
            <div class="product-grid">
                @forelse($products as $product)
                    <div class="product-card">
                        <a href="{{ route('products.detail', $product->id) }}" class="product-card__link">
                            <div class="product-card__image-container">
                                @if($product->image_url)
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-card__image">
                                @else
                                    <div class="no-image-placeholder">
                                        <span>画像なし</span>
                                    </div>
                                @endif
                            </div>
                            <div class="product-card__content">
                                <h3 class="product-card__name">{{ $product->name }}</h3>
                                <p class="product-card__price">¥{{ number_format($product->price) }}</p>
                            </div>
                        </a>
                    </div>
                @empty
                    <p class="no-products">商品がありません</p>
                @endforelse
            </div>
            <div class="pagination">
                @if($products->hasPages())
                    @if($products->onFirstPage())
                        <span class="pagination-link disabled">＜</span>
                    @else
                        <a href="{{ $products->previousPageUrl() }}" class="pagination-link">＜</a>
                    @endif
                    @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                        @if($page == $products->currentPage())
                            <span class="pagination-link active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="pagination-link">{{ $page }}</a>
                        @endif
                    @endforeach
                    @if($products->hasMorePages())
                        <a href="{{ $products->nextPageUrl() }}" class="pagination-link">＞</a>
                    @else
                        <span class="pagination-link disabled">＞</span>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
