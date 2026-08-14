<?php

use App\Interfaces\Http\Controllers\AuthController;
use App\Interfaces\Http\Controllers\ProfileController;
use App\Interfaces\Http\Controllers\UserProfileController;
use App\Interfaces\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/hello', function () {
    return response()->json([
        'message' => 'Olá, Vue 3!',
    ]);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserController::class);
});

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'profile:admin'])->group(function () {

    Route::apiResource('profiles', ProfileController::class);

    Route::put(
        '/users/{user}/profiles',
        [UserProfileController::class, 'sync']
    );

    Route::delete(
        '/users/{user}/profiles',
        [UserProfileController::class, 'detach']
    );
});