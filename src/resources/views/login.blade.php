@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection
@section('content')
    <div class="main-container"> <h1 class="page-title">ログイン</h1> <form action="{{ route('login') }}" method="post">
            @csrf

            <div class="form-group"> <label for="email">メールアドレス</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="error" aria-live="polite">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group"> <label for="password">パスワード</label>
                <input type="password" id="password" name="password" required>
                @error('password')
                    <div class="error" aria-live="polite">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="login-button">ログインする</button> </form>

        <a href="{{ route('register.show') }}" class="register-link">会員登録はこちら</a> </div>
@endsection