<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\RegisterAction;
use App\DTO\User\UserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterUserRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class RegisterUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterUserRequest $request, RegisterAction $registerAction): Response
    {
        $data = new UserDTO([
            'name' => $request->getName(),
            'email' => $request->getEmail(),
            'password' => Hash::make($request->getPassword()),
        ]);

        $registerAction->execute($data);

        return response()->noContent();
    }
}
