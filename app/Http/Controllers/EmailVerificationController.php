<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\emailVerification;


class EmailVerificationController extends Controller
{

    public function verify(Request $request)
    {
        if ($request->user()) {
            $data = $request->validate([
                'token' => 'required|string',
                'user_id' => 'required|exists:users,id',
            ]);
            /** @var \App\Models\emailVerification $userVerfication */
            emailVerification::create([
                'token' => $data['token'],
                'user_id' => $data['user_id'],

            ]);
            return response([
                'message' => 'Successfully verified',
            ]);
        }
    }
}
