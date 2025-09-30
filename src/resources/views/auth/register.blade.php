@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')

<h1 class="register-title">Register</h1>

<div class="register-container">

        <form class="register-form" action="/register" method="post" novalidate>
        @csrf
            <dl>
                <dt>
                    <label class="register-form__label" for="" >お名前</label>
                </dt>
                <dd>
                    <input class="register-form__item" type="text" name="name" value="{{ old('name') }}">
                </dd>
                <dd class="register-form__message">
                    @error('name')
                    <span>{{ $message }}</span>
                    @enderror
                </dd>
                <dt>
                    <label class="register-form__label"  for="" >メールアドレス</label>
                </dt>
                <dd>
                    <input class="register-form__item" type="email" name="email" value="{{ old('email') }}">
                </dd>
                <dd class="register-form__message">
                    @error('email')
                    <span>{{ $message }}</span>
                    @enderror
                </dd>
                <dt>
                    <label class="register-form__label" for="" >パスワード</label>
                </dt>
                <dd>
                    <input class="register-form__item" type="password" name="password" autocomplete="new-password">
                </dd>
                <dd class="register-form__message">
                    @error('password')
                    <span>{{ $message }}</span>
                    @enderror
                </dd>
            </dl>
            <button class="register-form__button">登録</button>
        </form>
</div>

@endsection