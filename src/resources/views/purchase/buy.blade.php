@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase/buy.css') }}">
@endsection
@section('content')
<body>
    <header>
        <div class="logo">COACHTECH</div>
        <form method="GET" action="{{ route('items.index') }}">
            <input type="text" name="search" placeholder="なにをお探しですか？">
        </form>
        <nav>
            <a href="{{ route('mypage.index') }}">マイページ</a>
            <a href="{{ route('sell.create') }}">出品</a>
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">ログアウト</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </nav>
    </header>

    <main>
        @if ($item->status === 'sold')
            <div class="error-message">
                <p>この商品はすでに購入されています。</p>
                <a href="{{ route('item.show', $item->id) }}">商品詳細に戻る</a>
            </div>
        @else
            <form action="{{ route('purchase.store', $item->id) }}" method="POST">
                @csrf

                <section class="product-details">
                    <div class="product-image">
                        <img src="{{ asset('storage/' . optional($item->images->first())->path ?? 'noimage.jpg') }}" alt="{{ $item->title }}">
                    </div>
                    <div class="product-info">
                        <h1>{{ $item->title }}</h1>
                        <p>¥ {{ number_format($item->price) }}</p>
                        <p>出品者：{{ $item->user->username ?? '匿名出品者' }}</p>
                    </div>
                </section>

                <section class="payment-delivery">
                    <div class="payment-method">
                        <h2>支払い方法</h2>
                        <label>
                            <input type="radio" name="payment_method" value="コンビニ支払い"
                                {{ old('payment_method', $selectedMethod) == 'コンビニ支払い' ? 'checked' : '' }}>
                            コンビニ支払い
                        </label>
                        <label>
                            <input type="radio" name="payment_method" value="カード支払い"
                                {{ old('payment_method', $selectedMethod) == 'カード支払い' ? 'checked' : '' }}>
                            カード支払い
                        </label>
                        @error('payment_method')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="delivery-address">
                        <h2>配送先</h2>
                        <p>{{ $user->postal_code ?? '未設定' }}</p>
                        <p>{{ $shippingAddress }}</p>
                        <a href="{{ route('purchase.address.edit', $item->id) }}">変更する</a>
                    </div>
                </section>

                <section class="purchase-summary">
                    <div class="summary">
                        <p>商品代金：¥ {{ number_format($item->price) }}</p>
                        <p>支払い方法：{{ old('payment_method', $selectedMethod) }}</p>
                    </div>
                    <button type="submit">購入する</button>
                </section>

                @if (session('error'))
                    <div class="error">{{ session('error') }}</div>
                @endif
            </form>
        @endif
    </main>
@endsection
