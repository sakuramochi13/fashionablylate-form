@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
@endsection

@section('content')

<h1 class="confirm-title">Confirm</h1>

<div class="confirm-container">
    <dl class="confirm-table">
        <div class="confirm-table__section">
            <dt>お名前</dt><dd>{{ $contact['last_name'] ?? '' }} {{ $contact['first_name'] ?? '' }}</dd>
        </div>
        <div class="confirm-table__section">
            <dt>性別</dt><dd>{{ $genderLabel }}</dd>
        </div>
        <div class="confirm-table__section">
            <dt>メールアドレス</dt><dd>{{ $contact['email'] ?? '' }}</dd>
        </div>
        <div class="confirm-table__section">
            <dt>電話番号</dt><dd>{{ $telDisplay ?? ($contact['tel'] ?? '') }}</dd>
        </div>
        <div class="confirm-table__section">
            <dt>住所</dt><dd>{{ $contact['address'] ?? '' }}</dd>
        </div>
        <div class="confirm-table__section">
            <dt>建物名</dt><dd>{{ $contact['building'] ?? '' }}</dd>
        </div>
        <div class="confirm-table__section">
            <dt>お問い合わせの種類</dt><dd>{{ $categoryName }}</dd>
        </div>
        <div class="confirm-table__section">
            <dt>お問い合わせの内容</dt><dd class="confirm-table__section--textarea">{!! nl2br(e($contact['detail'] ?? '')) !!}</dd>
        </div>
    </dl>
    <form method="post" action="{{ route('contacts.store') }}" class="confirm-button">
    @csrf
    @foreach (['category_id','first_name','last_name','gender','email','tel','address','building','detail'] as $key)
        <input type="hidden" name="{{ $key }}" value="{{ $contact[$key] ?? '' }}">
    @endforeach
        <button class="confirm-button__submit" type="submit">送信</button>
        <button type="submit"
        formaction="{{ route('contacts.back') }}"
        formmethod="post"
        class="confirm-button__edit"
        formnovalidate>修正</button>
    </form>
</div>

@endsection