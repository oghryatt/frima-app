@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage/index.css') }}">
@endsection
@section('content')
    <header>
        <input type="text" placeholder="なにをお探しですか？">
        <nav>
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">ログアウト</a>
            <a href="{{ route('mypage') }}">マイページ</a>
            <a href="{{ route('sell.create') }}">出品</a>
            <a href="{{ route('mypage.show', ['id' => $user->id]) }}">マイページ詳細</a>


        </nav>
        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none;">
            @csrf
        </form>
    </header>

    <main>
        <section class="profile">
            <div class="profile-picture">
                <img src="{{ $user->profile_image ? Storage::url($user->profile_image) : asset('images/default-profile.png') }}" alt="プロフィール画像">
            </div>
            <div class="username">ユーザー名：{{ $user->name }}</div>
            <a href="{{ route('mypage.profile.edit') }}">
                <button class="edit-profile">プロフィールを編集</button>
            </a>
            <a href="{{ route('mypage.show', $user->id) }}">
            <button class="view-profile">マイページ詳細を見る</button>
             </a>

        </section>

        <section class="products">
            <div class="listed-products">
                <h2>出品した商品</h2>
                @forelse ($itemsSold as $item)
                    <div class="product">
                        <div class="product-image">
                            @if($item->images && count($item->images))
                                <img src="{{ Storage::url($item->images[0]->path) }}" alt="商品画像">
                            @else
                                <div>画像なし</div>
                            @endif
                        </div>
                        <div class="product-name">{{ $item->title }}</div>
                    </div>
                @empty
                    <p>出品された商品はありません。</p>
                @endforelse
            </div>

            <div class="purchased-products">
                <h2>購入した商品</h2>
                @forelse ($itemsBought as $order)
                    <div class="product">
                        <div class="product-image">
                            @if($order->item && $order->item->images && count($order->item->images))
                                <img src="{{ Storage::url($order->item->images[0]->path) }}" alt="商品画像">
                            @else
                                <div>画像なし</div>
                            @endif
                        </div>
                        <div class="product-name">{{ $order->item->title ?? '不明な商品' }}</div>
                    </div>
                @empty
                    <p>購入履歴はありません。</p>
                @endforelse
            </div>
        </section>
    </main>
@endsection
