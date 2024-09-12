<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\VerifyEmailAction;
use App\Actions\Auth\SendEmailAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\EmailVerifyUserRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class EmailController extends Controller
{

    public function sendEmailCode(SendEmailAction $sendEmailAction): Response
    {
        $sendEmailAction->execute();

        return response()->noContent();
    }

    /**
     * @throws ValidationException
     */
    public function verifyEmailCode(EmailVerifyUserRequest $request, VerifyEmailAction $verifyEmailAction): Response
    {
        $code = $request->getCode();

        $verifyEmailAction->execute($code);

        return response()->noContent();
    }
}
