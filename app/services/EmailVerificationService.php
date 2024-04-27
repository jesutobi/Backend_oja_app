<?php

namespace App\Services;

use App\Mail\verificationMail;
use Illuminate\Support\Facades\Mail;

class EmailVerificationService
{
    public static function sendVerificationEmail($user)
    {
        // if ($user->hasVerifiedEmail()) {
        //     return [
        //         'message' => 'Already Verified'
        //     ];
        // }

        $token = uniqid();
        $hashedToken = hash('sha256', $token);

        Mail::to($user->email)->send(new verificationMail(['user_data' => $user, 'hashedToken' => $hashedToken]));

        return ['status' => 'verification-link-sent'];
    }
}
