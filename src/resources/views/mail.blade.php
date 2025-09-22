
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mail.css') }}">
@endsection

@section('content')
    <header class="header">
        <div class="header-left">
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

    <main class="main-container">
        <h1 class="page-title">メール認証</h1>
        <div class="verification-box">
            <p>登録していただいたメールアドレスに認証メールを送付しました。<br>メール認証を完了してください。</p>
            <button class="verify-button">認証はこちらから</button>
            <a href="#" class="resend-link">認証メールを再送する</a>
        </div>
    </main>
@endsection