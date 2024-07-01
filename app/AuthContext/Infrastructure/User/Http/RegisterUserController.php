<?php

declare(strict_types=1);

namespace App\AuthContext\Infrastructure\User\Http;

use App\AuthContext\Infrastructure\Hash;
use App\AuthContext\Infrastructure\Str;
use App\AuthContext\Infrastructure\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use League\Tactician\CommandBus;

class RegisterUserController
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function register(Request $request): JsonResponse
    {
//        $request->validate([
//            'name' => 'required|string',
//            'email' => 'required|email|unique:users,email',
//            'password' => 'required|string|min:6',
//        ]);


        // Crear usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'uuid' => Str::uuid(), // Generar UUID para el usuario
        ]);

        // Generar tokens de acceso
        $token = $user->createToken('Password Grant Client')->accessToken;

        return response()->json(['token' => $token], 201);
    }
}