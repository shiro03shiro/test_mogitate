@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/products-register.css') }}">
@endsection

@section('content')
<div class="register-container">
    <h1 class="register-title">商品登録</h1>

    @if ($errors->any())
        <div class="error-messages">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="register-form">
        @csrf

        <div class="form-group">
            <label class="form-label">商品名</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label class="form-label">価格（円）</label>
            <input type="number" name="price" value="{{ old('price') }}" min="0" required>
        </div>

        <div class="form-group">
            <label class="form-label">商品画像</label>
            <input type="file" name="image" accept="image/*">
        </div>

        <div class="form-group">
            <label class="form-label">季節（複数選択可）</label>
            <div class="season-grid">
                @foreach($seasons as $season)
                    <label class="season-checkbox">
                        <input type="checkbox" name="seasons[]" value="{{ $season->id }}"
                            {{ in_array($season->id, old('seasons', [])) ? 'checked' : '' }}>
                        {{ $season->name }}
                    </label>
                @endforeach
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">商品説明</label>
            <textarea name="description" rows="4">{{ old('description') }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-register">登録</button>
            <a href="{{ route('products.index') }}" class="btn-back">一覧に戻る</a>
        </div>
    </form>
</div>
@endsection
