<?php

declare(strict_types=1);

namespace App\AuthContext\Infrastructure\User\Http;

use App\AuthContext\Application\User\Service\RegisterUserService;
use App\AuthContext\Infrastructure\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterUserController
{
    private RegisterUserService $registerUserService;

    public function __construct(RegisterUserService $registerUserService)
    {
        $this->registerUserService = $registerUserService;
    }

    public function register(Request $request): JsonResponse
    {
        $token = $this->registerUserService->execute(
            $request->input('name'),
            $request->input('email'),
            bcrypt($request->input('password'))
        );

        return response()->json([
            'token' => $token,
            'name' => $request->input('name'),
            'email' => $request->input('email')
        ], 201);
    }
}