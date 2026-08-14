<?php

namespace App\Http\Controllers;
use OpenApi\Attributes as OA;
use App\Application\Auth\UseCases\LoginUseCase;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function __construct(
        private readonly LoginUseCase $loginUseCase
    ) {}

    #[OA\Post(
        path: '/api/login',
        summary: 'Realiza o login',
        description: 'Autentica o usuário e retorna o token de acesso.',
        tags: ['Auth'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                ref: '#/components/schemas/LoginRequest'
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Login realizado com sucesso',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/LoginResponse'
                )
            ),
            new OA\Response(
                response: 422,
                description: 'Dados inválidos'
            ),
            new OA\Response(
                response: 401,
                description: 'Credenciais inválidas'
            )
        ]
    )]
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