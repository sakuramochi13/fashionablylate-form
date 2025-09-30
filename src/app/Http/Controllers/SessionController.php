<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function backToEdit(Request $request)
    {
        $data = $request->session()->get('contact', []);
        $data['gender'] = isset($data['gender']) ? (string) $data['gender'] : '';

        if (isset($data['tel']) && !is_array($data['tel'])) {
            $digits = preg_replace('/\D/', '', (string) $data['tel']);
            if (strlen($digits) === 11) {
                $data['tel'] = [substr($digits,0,3), substr($digits,3,4), substr($digits,7,4)];
            } elseif (strlen($digits) === 10) {
                $data['tel'] = [substr($digits,0,3), substr($digits,3,3), substr($digits,6,4)];
            } else {
                $parts = preg_split('/\D+/', (string)$data['tel']);
                $data['tel'] = array_pad($parts, 3, '');
            }
        }

        return redirect()->route('contact.create')->withInput($data);
    }
}
