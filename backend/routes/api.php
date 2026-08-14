<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/hello', function () {
    return response()->json([
        'message' => 'Olá, Vue 3!',
    ]);
});

Route::get('/user', function (Request $request) {
    return $request->user()->load('profiles');
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);