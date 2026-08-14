<?php

namespace App\Http\Controllers;

use App\Application\Auth\UseCases\LoginUseCase;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function __construct(
        private readonly LoginUseCase $loginUseCase
    ) {}

    public function login(LoginRequest $request): JsonResponse
    {
        Log::info('Login request received', [
            'email' => $request->validated('email'),
        ]);
        $result = $this->loginUseCase->execute(
            email: $request->validated('email'),
            password: $request->validated('password'),
        );

        return response()->json($result);
    }
}