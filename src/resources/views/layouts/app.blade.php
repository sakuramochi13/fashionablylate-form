<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FashionablyLate</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200..900&family=Sorts+Mill+Goudy:ital@0;1&display=swap" rel="stylesheet">
    @yield('css')
</head>
<body>

<header class="header">
    <div class="header__inner">
        <div aria-hidden="true"></div>
        <a class="header__logo" href="/">FashionablyLate</a>
        <nav class="header-nav__actions">
            @auth
            @unless (request()->routeIs('admin.index'))
                <a href="{{ route('admin.index') }}" class="header-nav__actions-link">Admin</a>
            @endunless
            <form method="POST" action="{{ route('logout') }}" class="header-nav__actions-form">
                @csrf
                <button type="submit" class="header-nav__actions-btn">logout</button>
                </form>
                @endauth
                @guest
                @if (request()->routeIs('login') && Route::has('register'))
                <a href="{{ route('register') }}" class="header-nav__actions-btn">register</a>
                @elseif (request()->routeIs('register'))
                <a href="{{ route('login') }}" class="header-nav__actions-btn">login</a>
                @endif
            @endguest
        </nav>
    </div>
</header>

<main>
    @yield('content')
</main>
