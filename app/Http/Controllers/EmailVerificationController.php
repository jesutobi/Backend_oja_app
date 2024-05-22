<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use App\Models\emailVerification;


class EmailVerificationController extends Controller
{

    public function verify(Request $request)
    {
        if ($request->user()) {
            $userData = $request->user();
            $isAuthenticatedUser = User::find($userData->id);

            if (!is_null($isAuthenticatedUser->verified_at)) {
                return response()->json([
                    'error' => 'User has already been verified'
                ], 400);
            } else {
                $data = $request->validate([
                    'token' => 'required|string',
                    'user_id' => 'required|exists:users,id',
                ]);
                /** @var \App\Models\emailVerification $userVerfication */
                emailVerification::create([
                    'token' => $data['token'],
                    'user_id' => $data['user_id'],

                ]);
                $verification = emailVerification::where('token', $data['token'])->first();
                if (!$verification) {
                    // Handle token not found or invalid token
                    // Return error response
                    return response()->json(['error' => 'Invalid token'], 404);
                }
                $user = User::find($verification->user_id);
                $user->markEmailAsVerified();

                $verification->update(['verified_at' => now()]);
                return response()->json([
                    'user' => $user,
                    'message' => 'User successfully verified'
                ], 200);
            }
        }
    }
}
