<?php

namespace App\Http\Requests;

use Laravel\Fortify\Http\Requests\LoginRequest as BaseLoginRequest;
use Laravel\Fortify\Fortify;

class FortifyLoginRequest extends BaseLoginRequest
{
    protected $errorBag = 'login';

    public function username(): string
    {
        return Fortify::username();
    }

    public function rules(): array
    {
        $u = $this->username();
        return [
            $u         => ['bail','required','email','max:255'],
            'password' => ['required','string'],
        ];
    }

    public function messages(): array
    {
        $u = $this->username();
        return [
            "{$u}.required" => 'メールアドレスを入力してください',
            "{$u}.email"    => 'メールアドレスはメール形式で入力してください',
            'password.required' => 'パスワードを入力してください',
        ];
    }
}
