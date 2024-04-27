<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\Rules\Password as PasswordRule;
// use App\Http\Requests\ResetPasswordRequest;

class ForgotPasswordController extends Controller
{
    //

    public function forgot_password(Request $request)
    {
        $data = $request->validate(['email' => 'required|email']);

        Password::sendResetLink(
            $data
        );

        return response()->json(['message' => 'Reset password link has been sent to your email address'], Response::HTTP_OK);
    }
    public function reset_password(Request $request)
    {
        $data = $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', PasswordRule::min(8)->mixedCase()->numbers()],
            'password_confirmation' => 'required|same:password',

        ]);

        $status = Password::reset(
            $data,
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return response()->json(['message' => 'Password Reset Successful'], Response::HTTP_OK);
    }
}
