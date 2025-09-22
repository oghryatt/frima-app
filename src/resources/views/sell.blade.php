@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection
@section('content')
    <header class="header"> <div class="header-left">
            <div class="logo">COACHTECH</div>
        </div>
        <div class="header-center">
            <input type="text" placeholder="なにをお探しですか？">
        </div>
        <div class="header-right">
            <a href="#">ログアウト</a>
            <a href="#">マイページ</a>
            <a href="#" class="button-primary">出品</a>
        </div>
    </header>

    <main class="main-container"> <h1 class="page-title">商品の出品</h1> @if(session('status'))
            <p class="success">{{ session('status') }}</p>
        @endif

        <form method="POST" action="{{ route('sell.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="form-section"> <h2 class="section-title">商品画像</h2> <div class="image-upload-area"> <label for="item-image" class="image-select-button">画像を選択する</label>
                    <input type="file" id="item-image" name="images[]" multiple class="visually-hidden">
                </div>
                @error('images.*')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-section">
                <h2 class="section-title">商品の詳細</h2>
                <div class="form-group">
                    <label for="category">カテゴリー（複数選択可）</label>
                    <div class="category-tags"> @foreach($categories as $category)
                            <label class="tag-label"> <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="visually-hidden">
                                <span class="tag">{{ $category->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('categories')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="condition">商品の状態</label>
                    <select id="condition" name="condition" required>
                        <option value="">選択してください</option>
                        <option value="新品" {{ old('condition') == '新品' ? 'selected' : '' }}>新品</option>
                        <option value="未使用" {{ old('condition') == '未使用' ? 'selected' : '' }}>未使用</option>
                        <option value="目立った傷なし" {{ old('condition') == '目立った傷なし' ? 'selected' : '' }}>目立った傷なし</option>
                        <option value="やや傷あり" {{ old('condition') == 'やや傷あり' ? 'selected' : '' }}>やや傷あり</option>
                        <option value="状態悪い" {{ old('condition') == '状態悪い' ? 'selected' : '' }}>状態悪い</option>
                    </select>
                    @error('condition')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="form-section">
                <h2 class="section-title">商品名と説明</h2>
                <div class="form-group">
                    <label for="title">商品名</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required>
                    @error('title')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">商品の説明</label>
                    <textarea id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                    @error('description')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="form-section">
                <h2 class="section-title">販売価格</h2>
                <div class="price-input"> <span>¥</span>
                    <input type="number" name="price" min="1" value="{{ old('price') }}" required>
                </div>
                @error('price')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="submit-button">出品する</button> </form>
    </main>
@endsection