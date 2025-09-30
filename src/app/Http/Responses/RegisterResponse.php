<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    public function toResponse($request)
    {
        Auth::logout();

        return $request->wantsJson()
            ? new JsonResponse(['status' => 'registered'], 201)
            : redirect('/register')->with('status', 'registered');
    }
}