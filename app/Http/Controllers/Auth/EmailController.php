<?php

namespace App\Http\Controllers\Auth;

use App\DTO\User\VerifyUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\EmailVerifyUserRequest;
use App\Mail\VerifyMail;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{

    public function sendEmailCode(): void
    {
        $user = Auth::user();
        $data = new VerifyUserDTO([
            'userId' => $user->getAuthIdentifier(),
            'code' => fake()->randomNumber(6),
        ]);

        Cache::put('users:' . $data->userId, $data->code, 60*60);

        Mail::to($user)->send(new VerifyMail($data->code));
    }

    public function confirmEmailCode(EmailVerifyUserRequest $request): void
    {
        $data = new VerifyUserDTO([
            'userId' => Auth::user()->getAuthIdentifier(),
            'code' => $request->getCode(),
        ]);

        $code = Cache::get('users:' . $data->userId);

        if ($data->code == $code) {
            $user = User::find($data->userId);
            $user->forceFill(['email_verified_at' => now()])->save();
        }
    }
}
