@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')

<h1 class="admin-title">Admin</h1>

<div class="search-container">
    <div class="search-section">
        <form action="{{ route('admin.index') }}" class="search-form" method="GET">
            <div>
                <input class="search-form__word text-effect" type="text" name="word" placeholder="名前やメールアドレスを入力してください" value="{{ request('word') }}">
            </div>
            <div class="select-effect">
                <select class="search-form__gender text-effect" name="gender">
                    <option value="">性別</option>
                    <option value="1" @selected(request('gender')==='1')>男性</option>
                    <option value="2" @selected(request('gender')==='2')>女性</option>
                    <option value="3" @selected(request('gender')==='3')>その他</option>
                </select>
            </div>
            <div class="select-effect">
                <select class="search-form__category text-effect" name="category">
                    <option value="" >お問い合わせの種類</option>
                    @foreach(\App\Models\Contact::CATEGORY_MAP as $id => $label)
                    <option value="{{ $id }}" @selected((string)request('category') === (string)$id)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="date-effect">
                    <input class="search-form__date text-effect" type="date" name="date" value="{{ request('date') }}">
            </div>
            <div>
                <button class="btn search-form__execution" type="submit">検索</button>
            </div>
            <div>
                <a class="btn search-form__reset" href="{{ route('admin.index') }}">リセット</a>
            </div>
        </form>
    </div>
    <div class="holder-section">
        <div>
            <a class="btn holder-section__export" href="{{ route('admin.export', request()->except('page')) }}">エクスポート</a>
        </div>
        <div class="holder-section__pagination">
            @if ($contacts->hasPages())
            {{ $contacts->onEachSide(1)->links() }}
            @endif
        </div>
    </div>
    <div class="list-section">
        <table class="list-table">
            <colgroup>
                <col style="width:20%">
                <col style="width:10%">
                <col style="width:30%">
                <col style="width:25%">
                <col style="width:15%">
            </colgroup>
            <tr class="list-table__caption">
                <th class="list-table__caption-name"><span>お名前</span></th>
                <th class="list-table__caption-gender"><span>性別</span></th>
                <th class="list-table__caption-email"><span>メールアドレス</span></th>
                <th class="list-table__caption-category"><span>お問い合わせの種類</span></th>
                <th class="list-table__caption-detail"><span>   </span></th>
            </tr>
            @forelse($contacts as $contact)
            <tr>
                <td class="list-table__left">
                    <input type="text" value="{{ $contact->full_name }}" readonly>
                </td>
                <td class="list-table__center">
                    @php
                    $genderLabel = ['1'=>'男性','2'=>'女性','3'=>'その他'][$contact->gender] ?? '未設定';
                    @endphp
                    <input type="text" value="{{ $genderLabel }}" readonly>
                </td>
                <td class="list-table__center">
                    <input type="text" value="{{ $contact->email }}" readonly>
                </td>
                <td class="list-table__center">
                    <input type="text" value="{{ $contact->category_name }}" readonly>
                </td>
                <td class="list-table__right">
                    <div class="detail-trigger">
                        <button type="button"
                        class="detail-button"
                        popovertarget="po-{{ $contact->id }}"
                        popovertargetaction="show">詳細</button>
                        <div id="po-{{ $contact->id }}" popover class="detail-popover" role="dialog" aria-modal="true" aria-label="お問い合わせ詳細">
                            <div class="detail-container">
                            <div class="detail-position">
                                <button type="button" class="detail-close"
                                popovertarget="po-{{ $contact->id }}"
                                popovertargetaction="hide">×</button>
                            </div>
                                <form class="detail-form" method="POST" action="{{ route('contacts.destroy', $contact) }}">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="back" value="{{ url()->full() }}">
                                    <dl>
                                        <dt><span>お名前</span></dt>
                                        <dd><input type="text" name="" value="{{ $contact->full_name }}" readonly /></dd>
                                        <dt><span>性別</span></dt>
                                        <dd><input type="text" name="" value="{{ $contact->gender_label }}"  readonly /></dd>
                                        <dt><span>メールアドレス</span></dt>
                                        <dd><input type="text" name="" value="{{ $contact->email }}"  readonly /></dd>
                                        <dt><span>電話番号</span></dt>
                                        <dd><input type="text" name="" value="{{ $contact->tel }}"  readonly /></dd>
                                        <dt><span>住所</span></dt>
                                        <dd><input type="text" name="" value="{{ $contact->address }}"  readonly /></dd>
                                        <dt><span>建物名</span></dt>
                                        <dd><input type="text" name="" value="{{ $contact->building }}"  readonly /></dd>
                                        <dt><span>お問い合わせの種類</span></dt>
                                        <dd><input type="text" name="" value="{{ $contact->category_name }}"  readonly /></dd>
                                        <dt class="detail-form__textarea"><span>お問い合わせ内容</span></dt>
                                        <dd class="detail-form__textarea"><textarea class="detail-form__textarea-item" readonly>{{ $contact->detail }}</textarea></dd>
                                    </dl>
                                        <button type="submit" class="modal__delete-button" onclick="return confirm('本当に削除しますか？');">削除</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5">データがありません</td></tr>
            @endforelse
        </table>
    </div>
</div>

@endsection