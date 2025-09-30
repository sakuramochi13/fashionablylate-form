<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
    $tel = $this->input('tel');

        if (is_array($tel)) {
        $tel = implode('', $tel);
        }

        $tel = mb_convert_kana((string) $tel, 'n');
        $tel = preg_replace('/\D+/', '', $tel);

        $this->merge(['tel' => $tel]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'integer', 'in:1,2,3'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'tel' => ['bail', 'required', 'string', 'regex:/^[0-9]+$/', 'min:10', 'max:11'],
            'address' => ['required', 'string', 'max:255'],
            'building' => ['nullable', 'string', 'max:255'],
            'detail' => ['required', 'string', 'max:120'],
        ];
    }

        public function messages()
    {
        return [
            'category_id.required' => 'お問い合わせの種類を選択してください',
            'last_name.required' => '姓を入力して下さい',
            'first_name.required' => '名を入力して下さい',
            'gender.required' => '性別を選択してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスはメール形式で入力してください',
            'tel.required' => '電話番号を入力してください',
            'tel.regex' => '電話番号を数値で入力してください',
            'tel.min'  => '電話番号は10桁以上で入力してください',
            'tel.max' => '電話番号は11桁以内で入力してください',
            'address.required' => '住所を入力してください',
            'detail.required' => 'お問い合わせの内容を入力してください',
            'detail.max' => 'お問合せ内容は120文字以内で入力してください',
        ];
    }

}
