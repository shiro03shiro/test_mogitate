@extends('layouts.app')

@section('content')
<div class="register-container">
    <div class="register-form">
        <h1>商品登録</h1>

        @if($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>商品名</label>
                <input type="text" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label>価格（円）</label>
                <input type="number" name="price" value="{{ old('price') }}" min="0" required>
            </div>

            <div class="form-group">
                <label>商品説明</label>
                <textarea name="description" rows="5" required>{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label>商品画像（オプション）</label>
                <input type="file" name="image" accept="image/*">
                <small>画像なしの場合は public/image/ にフルーツ名.jpg で自動表示されます</small>
            </div>

            <div class="form-buttons">
                <button type="submit" class="btn-primary">登録する</button>
                <a href="{{ route('products.index') }}" class="btn-secondary">一覧に戻る</a>
            </div>
        </form>
    </div>
</div>
@endsection
