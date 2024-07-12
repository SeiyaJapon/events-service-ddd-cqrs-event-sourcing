<?php

use App\AuthContext\Infrastructure\User\Http\CreateUserTokenController;
use App\AuthContext\Infrastructure\User\Http\RegisterUserController;
use App\AuthContext\Infrastructure\User\Http\UpdateUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::get('/aux', function () {
    return response()->json(['message' => 'Hello World!'], 200);
});

Route::group(['middleware' => 'guest'], function () {
    Route::post('/createToken', [CreateUserTokenController::class, 'createToken']);
    Route::post('/register', [RegisterUserController::class, 'register']);
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::put('/update', [UpdateUserController::class, 'update']);
});
