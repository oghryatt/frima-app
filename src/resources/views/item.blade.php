@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/item.css') }}">
@endsection
@section('content')
    <header class="header"> <div class="header-left"> <div class="logo">COACHTECH</div>
        </div>
        <div class="header-center"> <form method="GET" action="{{ route('items.index') }}">
                <input type="text" name="search" placeholder="なにをお探しですか？" value="{{ request('search') }}">
            </form>
        </div>
        <div class="header-right"> <nav>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    ログアウト
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

                <a href="{{ route('mypage.index') }}">マイページ</a>
                <a href="{{ route('sell.create') }}" class="button-primary">出品</a> </nav>
        </div>
    </header>

    <main class="main-container"> <div class="item-detail-container"> <div class="item-image-wrapper"> <div class="item-image-placeholder"> <img src="{{ asset('storage/' . optional($item->images->first())->path ?? 'noimage.jpg') }}" alt="商品画像">
                </div>
            </div>

            <div class="item-details"> <h1 class="item-name">{{ $item->title }}</h1> <p class="item-brand">ブランド名</p> <p class="item-price">¥{{ number_format($item->price) }}<span> (税込)</span></p> <div class="item-actions"> <a href="{{ route('purchase.confirm', $item->id) }}">
                        <button class="buy-button">購入手続きへ</button> </a>
                    @auth
                        <form action="{{ route('item.like', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit">
                                <span style="color:{{ $isLiked ? 'red' : 'gray' }}">♥</span> {{ $likeCount }}
                            </button>
                        </form>
                    @endauth
                </div>

                <div class="section"> <h2 class="section-title">商品説明</h2> <p class="description-text">{{ $item->description }}</p> </div>

                <div class="section">
                    <h2 class="section-title">商品の情報</h2>
                    <div class="info-row"> <p class="info-label">カテゴリー</p>
                        <div class="info-tags">
                            @foreach($item->categories as $category)
                                <span class="tag">{{ $category->name }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="info-row">
                        <p class="info-label">商品の状態</p>
                        <span class="info-value">{{ $item->status }}</span>
                    </div>
                </div>

                <div class="section">
                    <h2 class="section-title">コメント ({{ $commentCount }})</h2>
                    @foreach ($item->comments as $comment)
                        <div class="comment-box">
                            <div class="comment-user">{{ $comment->user->username ?? '匿名ユーザー' }}</div>
                            <div class="comment-text">{{ $comment->content }}</div>
                        </div>
                    @endforeach
                </div>
                
                <div class="section">
                    <h2 class="section-title">商品へのコメント</h2>
                    @auth
                        <div class="add-comment">
                            <form action="{{ route('item.comment', $item->id) }}" method="POST">
                                @csrf
                                <textarea name="comment" class="comment-input" placeholder="" required maxlength="255">{{ old('comment') }}</textarea>
                                @error('comment')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                                <button type="submit" class="comment-button">コメントを送信する</button>
                            </form>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </main>
@endsection