@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/items/index.css') }}">
@endsection
@section('content')
</head>
<body>
    <header>
        <form method="GET" action="{{ route('items.index') }}">
            <input type="text" name="search" placeholder="なにをお探しですか？" value="{{ $search ?? '' }}">
            <button type="submit">検索</button>
        </form>
        <nav>
            <a href="{{ route('login.show') }}">ログイン</a>
            <a href="{{ route('mypage.index') }}">マイページ</a>
            <a href="{{ route('sell.create') }}">出品</a>
        </nav>
    </header>

    <main>
        <div class="tabs">
            <a href="{{ route('items.index') }}" class="{{ Route::currentRouteName() === 'items.index' ? 'active' : '' }}">
                <button>おすすめ</button>
            </a>
            <a href="{{ route('items.mylist') }}" class="{{ Route::currentRouteName() === 'items.mylist' ? 'active' : '' }}">
                <button>マイリスト</button>
            </a>
        </div>

        <div class="product-grid">
            @forelse ($items as $item)
                <div class="product">
                    <div class="product-image">
                        @if($item->images && count($item->images))
                            <img src="{{ Storage::url($item->images[0]->path) }}" alt="{{ $item->title }}">
                        @else
                            <img src="{{ asset('images/no-image.png') }}" alt="画像なし">
                        @endif
                    </div>
                    <div class="product-name">{{ $item->title }}</div>
                    @if($item->status === 'sold')
                        <div class="sold-label">Sold</div>
                    @endif
                </div>
            @empty
                <p>商品が見つかりませんでした。</p>
            @endforelse
        </div>
    </main>
@endsection
