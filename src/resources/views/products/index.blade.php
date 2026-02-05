@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="body">
    <div class="main-container">
        {{-- 1. タイトル行 --}}
        <div class="header-row">
            <div class="section__title">
                <h2>商品一覧</h2>
            </div>
            <div class="add-button-container">
                <a href="{{ route('products.register') }}" class="add-product-btn">＋商品を追加</a>
            </div>
        </div>

        {{-- 2. 検索セクション --}}
        <div class="search-section">
            <form class="search-form" method="GET" action="{{ route('products.index') }}">
                @csrf
                <div class="search-form__item">
                    <input class="search-form__item-input"
                        type="text"
                        name="search"
                        placeholder="商品名で検索"
                        value="{{ request('search') }}">
                </div>
                <div class="search-form__button">
                    <button class="search-form__button-submit" type="submit">検索</button>
                </div>
                <div class="search-form__item">
                    <h3>価格順で表示</h3>
                    <select class="search-form__item-select" name="sort">
                        <option value="">価格で並べ替え</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>価格が安い順</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>価格が高い順</option>
                    </select>
                </div>
            </form>
            <hr class="divider">
        </div>

        {{-- 3. 商品グリッド＋ページネーション --}}
        <div class="content-section">
            <div class="product-grid">
                @forelse($products as $product)
                    <div class="product-card">
                        <a href="{{ route('products.detail', $product['id']) }}" class="product-card__link">
                            @if(isset($product['image_path']) && $product['image_path'])
                                <img src="{{ asset('storage/' . $product['image_path']) }}" 
                                    alt="{{ $product['name'] }}" 
                                    class="product-card__image">
                            @else
                                <div class="product-card__no-image">画像なし</div>
                            @endif
                            <div class="product-card__content">
                                <h3 class="product-card__name">{{ $product['name'] }}</h3>
                                <p class="product-card__price">¥{{ number_format($product['price']) }}</p>
                            </div>
                        </a>
                    </div>
                @empty
                    <p class="no-products">商品がありません</p>
                @endforelse
            </div>
            <div class="pagination">
                @if(isset($currentPage) && isset($lastPage))
                    @if($currentPage > 1)
                        <a href="?page={{ $currentPage - 1 }}" class="pagination-link">＜</a>
                    @endif

                    @for($i = 1; $i <= $lastPage; $i++)
                        <a href="?page={{ $i }}"
                        class="pagination-link {{ $currentPage == $i ? 'active' : '' }}">
                            {{ $i }}
                        </a>
                    @endfor

                    @if($currentPage < $lastPage)
                        <a href="?page={{ $currentPage + 1 }}" class="pagination-link">＞</a>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
