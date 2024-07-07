<?php

use App\AuthContext\Infrastructure\User\Http\RegisterUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::get('/aux', function () {
    return response()->json(['message' => 'Hello World!'], 200);
});

Route::post('/register', [RegisterUserController::class, 'register']);