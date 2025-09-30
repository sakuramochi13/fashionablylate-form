@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

<h1 class="contact-title">Contact</h1>

<div class="contact-container">
    <form class="contact-form" action="{{ route('contacts.confirm') }}" method="post" novalidate>

    @csrf
        <div class="contact-form__section">
            <div class="contact-form__section-label">
                <span class="contact-form__section-label--symbol">お名前</span>
            </div>
            <div class="contact-form__section-item">
                <input class="contact-form__section-item--name"  placeholder="例: 山田" type="text" name="last_name" value="{{ old('last_name') }}" required>
                <input class="contact-form__section-item--name"  placeholder="例: 太郎" type="text" name="first_name" value="{{ old('first_name') }}" required>
            </div>
        </div>
        <div class="contact-form__section-item">
            @error('last_name')
            <div class="contact-form__error-last">{{ $message }}</div>
            @enderror
            @error('first_name')
            <div class="contact-form__error-first">{{ $message }}</div>
            @enderror
        </div>
        <div class="contact-form__section">
            <div class="contact-form__section-label">
                <span class="contact-form__section-label--symbol">性別</span>
            </div>
            <div class="contact-form__section-item">
                @php
                $oldGender = (string) old('gender', data_get(session('contact'), 'gender', ''));
                @endphp
                <label class="contact-form__section-item-gender"><input type="radio" name="gender" value="1" @checked($oldGender === '1')> 男性</label>
                <label class="contact-form__section-item-gender"><input type="radio" name="gender" value="2" @checked($oldGender === '2')> 女性</label>
                <label class="contact-form__section-item-gender"><input type="radio" name="gender" value="3" @checked($oldGender === '3')> その他</label>
            </div>
        </div>
        @error('gender')
        <div class="contact-form__error">{{ $message }}</div>
        @enderror
        <div class="contact-form__section">
            <div class="contact-form__section-label">
                <span class="contact-form__section-label--symbol">メールアドレス</span>
            </div>
            <div class="contact-form__section-item">
                <input class="contact-form__section-item--email"  placeholder="例: test@example.com" type="email" name="email" value="{{ old('email') }}" required>
            </div>
        </div>
        @error('email')
        <div class="contact-form__error">{{ $message }}</div>
        @enderror
        <div class="contact-form__section">
            <div class="contact-form__section-label">
                <span class="contact-form__section-label--symbol">電話番号</span>
            </div>
            <div class="contact-form__section-item">
                <input class="contact-form__section-item--tel" placeholder="080" type="text" name="tel[]" value="{{ old('tel.0') }}" required>
                <span class="contact-form__section-item--tel-hyphen">-</span>
                <input class="contact-form__section-item--tel" placeholder="1234" type="text" name="tel[]" value="{{ old('tel.1') }}" required>
                <span class="contact-form__section-item--tel-hyphen">-</span>
                <input class="contact-form__section-item--tel" placeholder="5678" type="text" name="tel[]" value="{{ old('tel.2') }}" required>
            </div>
        </div>
        @error('tel')
        <div class="contact-form__error">{{ $message }}</div>
        @enderror
        <div class="contact-form__section">
            <div class="contact-form__section-label">
                <span class="contact-form__section-label--symbol">住所</span>
            </div>
            <div class="contact-form__section-item">
                <input class="contact-form__section-item-text"  placeholder="例: 東京都渋谷区千駄ヶ谷1-2-3" type="text" name="address" value="{{ old('address') }}" required>
            </div>
        </div>
        @error('address')
        <div class="contact-form__error">{{ $message }}</div>
        @enderror
        <div class="contact-form__section">
            <div class="contact-form__section-label">
                <span class="contact-form__section-label--none">建物名</span>
            </div>
            <div class="contact-form__section-item">
                <input class="contact-form__section-item--building"  placeholder="例: 千駄ヶ谷マンション101" type="text" name="building" value="{{ old('building') }}">
            </div>
        </div>
        <div class="contact-form__section">
            <div class="contact-form__section-label">
                <span class="contact-form__section-label--symbol">お問い合わせの種類</span>
            </div>
            <div class="contact-form__section-item">
                <select class="contact-form__section-item--select" name="category_id" required>
                    <option value="" selected disabled>選択してください</option>
                    @foreach($categories as $c)
                    <option class="contact-form__section-item--select-option"
                    value="{{ $c->id }}"
                    {{ (int) old('category_id') === (int) $c->id ? 'selected' : '' }}>
                    {{ $c->content }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        @error('category_id')
        <div class="contact-form__error">{{ $message }}</div>
        @enderror
        <div class="contact-form__section">
            <div class="contact-form__section-label">
                <span class="contact-form__section-label--symbol">お問い合わせ内容</span>
            </div>
            <div class="contact-form__section-item">
                <textarea class="contact-form__section-item--textarea" placeholder="お問い合わせ内容をご記載ください" name="detail" rows="6" required>{{ old('detail') }}</textarea>
            </div>
        </div>
        @error('detail')
        <div class="contact-form__error">{{ $message }}</div>
        @enderror
        <div class="contact-form__section">
            <button class="contact-form__section-button" type="submit">確認画面</button>
        </div>
    </form>
</div>

@endsection