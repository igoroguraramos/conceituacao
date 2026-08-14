<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
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
});