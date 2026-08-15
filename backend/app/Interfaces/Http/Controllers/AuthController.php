<?php

namespace App\Interfaces\Http\Controllers;

use App\Application\Auth\UseCases\LoginUseCase;
use App\Application\Auth\UseCases\LogoutUseCase;
use App\Interfaces\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class AuthController extends Controller
{
    public function __construct(
        private readonly LoginUseCase $loginUseCase,
        private readonly LogoutUseCase $logoutUseCase,

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
        $result = $this->loginUseCase->execute(
            email: $request->validated('email'),
            password: $request->validated('password'),
        );

        return response()->json($result);
    }

    #[OA\Post(
        path: '/api/logout',
        summary: 'Realiza o logout',
        description: 'Revoga o token de acesso atual do usuário autenticado.',
        tags: ['Auth'],
        security: [['sanctum' => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Logout realizado com sucesso',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'message',
                            type: 'string',
                            example: 'Logout realizado com sucesso.'
                        ),
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthenticated.'
            )
        ]
    )]
    public function logout(Request $request): JsonResponse
    {
        $this->logoutUseCase->execute($request);

        return response()->json([
            'message' => 'Logout realizado com sucesso.',
        ]);
    }
}
