@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')

<h1 class="login-title">Login</h1>

<div class="login-container">
    <form class="login-form" action="/login" method="post" novalidate>
    @csrf
        <dl>
            <dt>
            <label class="login-form__label"  for="email" >メールアドレス</label>
            </dt>
            <dd>
                <input class="login-form__item" type="email" name="email" value="{{ old('email') }}" autocomplete="username">
            </dd>
            <dd class="login-form__message">
                @error('email', 'login')
                <span>{{ $message }}</span>
                @enderror
            </dd>
            <dt>
                <label class="login-form__label" for="password" >パスワード</label>
            </dt>
            <dd>
                <input class="login-form__item" type="password" name="password" autocomplete="current-password">
            </dd>
            <dd class="login-form__message">
                @error('password', 'login')
                <span>{{ $message }}</span>
                @enderror
            </dd>
        </dl>
        <button class="login-form__button">ログイン</button>
    </form>
</div>

@endsection