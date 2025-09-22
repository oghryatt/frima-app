@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection
@section('content')
    <main class="main-container">
         <h1 class="page-title">会員登録</h1>
         <form class="register-form" action="{{ route('register') }}" method="POST">
            @csrf
         <div class="form-group">
            <label for="name">名前</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
                <p class="error">{{ $message }}</p>
            @enderror
            </div>
            <div class="form-group">
            <label for="email">メールアドレス</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <p class="error">{{ $message }}</p>
            @enderror
            </div>
            <div class="form-group">
            <label for="password">パスワード</label>
            <input type="password" id="password" name="password" required>
            @error('password')
                <p class="error">{{ $message }}</p>
            @enderror
            </div>
            <div class="form-group">
            <label for="password_confirmation">確認用パスワード</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
            @error('password_confirmation')
                <p class="error">{{ $message }}</p>
            @enderror
             </div>
            <button type="submit">登録する</button>
        <p><a href="{{ route('login.show') }}">ログインはこちら</a></p>
        </form>
    </main>
@endsection
