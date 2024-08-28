<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\VerifyEmailAction;
use App\Actions\Auth\SendEmailAction;
use App\DTO\User\VerifyUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\EmailVerifyUserRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class EmailController extends Controller
{

    public function sendEmailCode(SendEmailAction $sendEmailAction): Response
    {
        $sendEmailAction->execute();

        return response()->noContent();
    }

    public function verifyEmailCode(EmailVerifyUserRequest $request, VerifyEmailAction $verifyEmailAction): Response
    {
        $data = new VerifyUserDTO([
            'user' => Auth::user(),
            'code' => $request->getCode(),
        ]);

        $verifyEmailAction->execute($data);

        return response()->noContent();
    }
}
