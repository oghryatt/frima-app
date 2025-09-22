<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECH</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('css')
</head>
<body>
    <header class="header">
        <div class="header-left">
            <div class="logo"><img src="{{ asset('images/logo.svg') }}" alt="COACHTECH"></div>
        </div>
        <div class="header-center">
            <form method="GET" action="#">
                <input type="text" name="search" placeholder="なにをお探しですか？">
            </form>
        </div>
        <div class="header-right">
            <nav>
                <a href="#">ログアウト</a>
                <a href="#">マイページ</a>
                <a href="#" class="button-primary">出品</a>
            </nav>
        </div>
    </header>

    @yield('content')
</body>
</html>