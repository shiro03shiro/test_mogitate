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
            <label class="form-label">商品名</label>
            <input type="text" name="name" value="{{ old('name') }}">
            @error('name')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">値段</label>
            <input type="text" name="price" value="{{ old('price') }}" min="0">
            @error('price')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">商品画像</label>
            <input type="file" name="image" accept="image/*">
            @error('image')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">季節</label>
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
            <label class="form-label">商品説明</label>
            <textarea name="description" rows="4">{{ old('description') }}</textarea>
            @error('description')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-register">登録</button>
            <a href="{{ route('products.index') }}" class="btn-back">一覧に戻る</a>
        </div>
    </form>
</div>
@endsection
