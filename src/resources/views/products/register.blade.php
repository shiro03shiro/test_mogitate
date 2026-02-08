@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/products-register.css') }}">
@endsection

@section('content')
<div class="register-container">
    <h1 class="register-title">商品登録</h1>

    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="register-form">
        @csrf

        <div class="form-group">
            <label class="form-label">
                商品名 <span class="required">必須</span>
            </label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="商品名を入力">
            @error('name')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">
                値段 <span class="required">必須</span>
            </label>
            <input type="text" name="price" value="{{ old('price') }}" placeholder="値段を入力">
            @error('price')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">
                商品画像 <span class="required">必須</span>
            </label>
            <input type="file" name="image" accept="image/*">
            @error('image')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">
                季節 <span class="required">必須</span> <span class="season-multiple">複数選択可</span>
            </label>
            <div class="season-grid">
                @foreach($seasons as $season)
                    <label class="season-checkbox">
                        <input type="checkbox" name="seasons[]" value="{{ $season->id }}"
                            {{ in_array($season->id, old('seasons', [])) ? 'checked' : '' }}>
                        {{ $season->name }}
                    </label>
                @endforeach
            </div>
            @error('seasons')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">
                商品説明 <span class="required">必須</span>
            </label>
            <textarea name="description" rows="4" placeholder="商品の説明を入力">{{ old('description') }}</textarea>
            @error('description')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('products.index') }}" class="btn-back">戻る</a>
            <button type="submit" class="btn-register">登録</button>
        </div>
    </form>
</div>
@endsection
