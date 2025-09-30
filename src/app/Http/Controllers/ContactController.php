<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Contact;
use App\Http\Requests\ContactRequest;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return $this->create();
    }

    public function create()
    {
        $categories = Category::orderBy('content')->get();
        return view('index', compact('categories'));
    }

    public function confirm(ContactRequest $request)
    {
        $contact = $request->validated();

        $request->session()->put('contact', $contact);

        return redirect()->route('contacts.confirm.show');

    }

    public function showConfirm(Request $request)
    {
        $contact = $request->session()->get('contact');

        if (!$contact) {
            return redirect()
                ->route('contact.create')
                ->with('error', '確認画面を表示できません。フォームから入力してください。');
        }

        $genderLabel = [1=>'男性', 2=>'女性', 3=>'その他'][$contact['gender']] ?? '';

        $categoryName = \App\Models\Category::find($contact['category_id'])->content ?? '';

        $telDisplay = $contact['tel'];
        if (preg_match('/^\d{11}$/', $telDisplay)) {
            $telDisplay = substr($telDisplay,0,3).'-'.substr($telDisplay,3,4).'-'.substr($telDisplay,7,4);
        } elseif (preg_match('/^\d{10}$/', $telDisplay)) {
            $telDisplay = substr($telDisplay,0,3).'-'.substr($telDisplay,3,3).'-'.substr($telDisplay,6,4);
        }

        return view('confirm', compact('contact','genderLabel','categoryName','telDisplay'));
    }

    public function store(ContactRequest $request)
    {
        Contact::create($request->validated());

        $request->session()->forget('contact');

        return redirect()->route('thanks');
    }
}
