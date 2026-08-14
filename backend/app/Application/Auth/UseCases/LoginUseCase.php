<?php

namespace App\Application\Auth\UseCases;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginUseCase
{
    public function execute(string $email, string $password): array
    {
        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['As credenciais informadas são inválidas.'],
            ]);
        }

        $user->tokens()->delete();

        $token = $user
            ->createToken('api-token')
            ->plainTextToken;

        return [
            'token' => $token,
            'user' => $user,
        ];
    }
}