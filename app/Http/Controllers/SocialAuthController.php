<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    /**
     * @return RedirectResponse
     */
    public function redirect($provider)
    {
        $url =  Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();

        return response()->json([
            'url' => $url
        ]);
    }

    /**
     * @return RedirectResponse
     */
    public function callback(Request $request, $provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();

        $existingUser = User::where('google_id', $user->id)->first();

        if ($existingUser) {

            $credentials = $request->validate([
                'email' => 'required|email|string|exists:users,email',
            ]);

            if (!Auth::attempt($credentials)) {
                return response([
                    'error' => 'The Provided credentials are not correct'
                ], 422);
            }

            /** @var \App\Models\User $user */
            $user = Auth::user();
            $token = $user->createToken('main')->plainTextToken;

            return response([
                'message' => 'User Logged In Successfully',
                'user' => $user,
                'token' => $token
            ]);
        } else {
            /** @var \App\Models\User $user */
            $user = User::create([
                'first_name' => $user->name,
                // 'last_name' => $user->email,
                // 'agree_terms_conditions' => $user['agree_terms_conditions'],
                'email' => $user->email,
                'google_id' => $user->id,
                'password' => bcrypt(request(Str::random()))
            ]);
            $token = $user->createToken('main')->plainTextToken;
            return response([
                'user' => $user,

                'message' => 'User Created Successfully',
                'token' => $token
            ]);
        }
        // return response([
        //     'message' => $user
        // ]);
        dd($user);
    }
}
