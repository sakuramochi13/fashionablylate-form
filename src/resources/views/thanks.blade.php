@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')

<div class="thanks-container">
    <p class="thanks-watermark">Thank you</p>
    <div class="thanks-group">
    <h1 class="thanks-group__message">お問い合わせありがとうございました</h1>
    <a class="thanks-group__button" href="{{ route('contact.create') }}">HOME</a>
    </div>
</div>

@endsection