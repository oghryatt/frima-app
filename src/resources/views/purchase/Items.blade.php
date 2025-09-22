@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase/items.css') }}">
@endsection

@section('content')
    <header class="header">
        <div class="header-left">
            <div class="logo">COACHTECH</div>
        </div>
        <div class="header-center">
            <form method="GET" action="{{ route('items.index') }}">
                <input type="text" name="search" placeholder="なにをお探しですか？" value="{{ request('search') }}">
            </form>
        </div>
        <div class="header-right">
            <nav>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    ログアウト
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <a href="{{ route('mypage.index') }}">マイページ</a>
                <a href="{{ route('sell.create') }}" class="button-primary">出品</a>
            </nav>
        </div>
    </header>

    <main class="main-container">
        <h1 class="page-title">商品購入</h1>
        <div class="purchase-container">
            <div class="purchase-details">
                <div class="item-summary">
                    <div class="item-image-placeholder">
                        <img src="{{ asset('storage/' . optional($item->images->first())->path) }}" alt="{{ $item->name }}">
                    </div>
                    <div class="item-info">
                        <p class="item-name">{{ $item->name }}</p>
                        <p class="item-price">¥{{ number_format($item->price) }}</p>
                    </div>
                </div>
                <div class="divider"></div>
                
                <form id="purchase-form" action="{{ route('purchase.store', $item->id) }}" method="POST">
                    @csrf
                    <div class="payment-method">
                        <p class="method-label">支払い方法</p>
                        <a href="#" class="change-link">変更する</a>
                    </div>
                    <select class="payment-select" name="payment_method">
                        <option value="">選択してください</option>
                    </select>
                    <div class="divider"></div>

                    <div class="shipping-address">
                        <p class="address-label">配送先</p>
                        <a href="#" class="change-link">変更する</a>
                        <p class="address-text">
                            〒 {{ $user->postal_code ?? '未設定' }}<br>
                            {{ $user->address ?? '未設定' }}
                        </p>
                    </div>
                    <div class="divider"></div>
                </form>
            </div>

            <div class="purchase-summary">
                <div class="summary-row">
                    <span>商品代金</span>
                    <span>¥{{ number_format($item->price) }}</span>
                </div>
                <div class="summary-row">
                    <span>支払い方法</span>
                    <span>{{ optional($item->paymentMethod)->name ?? '未選択' }}</span>
                </div>
                <button type="submit" form="purchase-form" class="purchase-button">購入する</button>
            </div>
        </div>
    </main>
@endsection