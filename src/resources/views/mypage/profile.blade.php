@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage/profile.css') }}">
@endsection
@section('content')
<body>
    <header class="header"> <div class="header-left"> <div class="logo">COACHTECH</div>
        </div>
        <div class="header-center"> <div class="search-bar">
                <input type="text" placeholder="なにをお探しですか？">
            </div>
        </div>
        <div class="header-right"> <nav>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">ログアウト</a>
                <a href="{{ route('mypage') }}">マイページ</a>
                <a href="{{ route('sell.create') }}" class="button-primary">出品</a> <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none;">
                    @csrf
                </form>
            </nav>
        </div>
    </header>

    <main class="main-container"> <h1 class="page-title">プロフィール設定</h1> @if(session('success'))
            <p class="alert alert-success">{{ session('success') }}</p>
        @endif

        <form method="POST" action="{{ route('mypage.profile.update') }}" enctype="multipart/form-data" class="profile-form"> @csrf

            <div class="profile-image-container"> <div class="profile-image-wrapper"> <img src="{{ $user->profile_image ? Storage::url($user->profile_image) : asset('images/default-profile.png') }}" alt="プロフィール画像">
                </div>
                <label for="profile_image" class="image-select-button">画像を**選択**する</label> <input type="file" name="profile_image" id="profile_image" class="visually-hidden"> </div>

            <div class="form-group"> <label for="name">ユーザー名</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}">
            </div>

            <div class="form-group">
                <label for="postcode">郵便番号</label>
                <input type="text" id="postcode" name="postcode" value="{{ old('postcode', $user->postcode) }}">
            </div>

            <div class="form-group">
                <label for="address">住所</label>
                <input type="text" id="address" name="address" value="{{ old('address', $user->address) }}">
            </div>

            <div class="form-group">
                <label for="building">建物名</label>
                <input type="text" id="building" name="building" value="{{ old('building', $user->building) }}">
            </div>

            <button type="submit" class="update-button">更新する</button> </form>
    </main>
</body>
@endsection