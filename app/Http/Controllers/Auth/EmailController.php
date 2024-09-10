<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\MeAction;
use App\Actions\Auth\VerifyEmailAction;
use App\Actions\Auth\SendEmailAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\EmailVerifyUserRequest;
use Illuminate\Http\Response;

class EmailController extends Controller
{

    public function sendEmailCode(SendEmailAction $sendEmailAction, MeAction $meAction): Response
    {
        $sendEmailAction->execute($meAction);

        return response()->noContent();
    }

    public function verifyEmailCode(
        EmailVerifyUserRequest $request,
        VerifyEmailAction $verifyEmailAction,
        MeAction $meAction
    ): Response {

        $code = $request->getCode();

        $verifyEmailAction->execute($code, $meAction);

        return response()->noContent();
    }
}
