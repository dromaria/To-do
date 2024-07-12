<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\LoginAction;
use App\Actions\Auth\LogoutAction;
use App\Actions\Auth\MeAction;
use App\Actions\Auth\RefreshAction;
use App\Actions\Auth\RegisterAction;
use App\DTO\User\RegisterUserDTO;
use App\DTO\User\UserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request, RegisterAction $registerAction): Response
    {
        $data = new RegisterUserDTO([
            'name' => $request->getName(),
            'email' => $request->getEmail(),
            'password' => $request->getPassword(),
        ]);

        $registerAction->execute($data);

        return response()->noContent();
    }
    public function login(LoginUserRequest $request, LoginAction $loginAction): JsonResponse
    {
        $data = new UserDTO(['email' => $request->getEmail(), 'password' => $request->getPassword()]);

        $respondWithToken = $loginAction->execute($data);

        return response()->json($respondWithToken);
    }

    public function me(MeAction $meAction): JsonResponse
    {
        $user = $meAction->execute();

        return response()->json($user);
    }

    public function logout(LogoutAction $logoutAction): Response
    {
        $logoutAction->execute();

        return response()->noContent();
    }

    public function refresh(RefreshAction $refreshAction): JsonResponse
    {
        $respondWithToken = $refreshAction->execute();

        return response()->json($respondWithToken);
    }
}
