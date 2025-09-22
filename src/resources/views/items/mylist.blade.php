@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/items/mylist.css') }}">
@endsection
@section('content')
<body>
    <header class="header"> <div class="header-left"> <div class="logo">COACHTECH</div>
        </div>
        <div class="header-center"> <form method="GET" action="{{ route('items.mylist') }}">
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

    <main class="main-container"> <div class="tabs">
            <a href="{{ route('items.index') }}" class="tab-item">おすすめ</a> <a href="{{ route('items.mylist') }}" class="tab-item active">マイリスト</a> </div>

        <div class="item-list"> @forelse ($items as $item)
                <div class="item-card"> <a href="#"> <div class="item-image-placeholder"> <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
                        </div>
                        <p class="item-name">{{ $item->name }}</p> </a>
                    @if ($item->is_sold)
                        <div class="sold-label">Sold</div>
                    @endif
                </div>
            @empty
                <p>マイリストに商品が登録されていません。</p>
            @endforelse
        </div>
    </main>
</body>
@endsection