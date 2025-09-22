@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase/address.css') }}">
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
        <h1 class="page-title">住所の変更</h1>
        <form class="address-form" method="POST" action="{{ route('purchase.address.update', $item->id) }}">
            @csrf

            @if(session('message'))
                <p class="success">{{ session('message') }}</p>
            @endif
            
            <div class="form-group">
                <label for="postal_code">郵便番号</label>
                <input type="text" id="postal_code" name="postal_code"
                       value="{{ old('postal_code', $postal_code) }}">
                @error('postal_code')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="address">住所</label>
                <input type="text" id="address" name="address"
                       value="{{ old('address', $address) }}">
                @error('address')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="building_name">建物名</label>
                <input type="text" id="building_name" name="building_name"
                       value="{{ old('building_name') }}">
            </div>
            
            <button type="submit" class="submit-button">更新する</button>
        </form>
    </main>
@endsection