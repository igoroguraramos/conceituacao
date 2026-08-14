<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class UserController extends Controller
{
    #[OA\Get(
        path: '/api/users',
        summary: 'Lista os usuários',
        tags: ['Users'],
        security: [['sanctum' => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Lista de usuários',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        ref: '#/components/schemas/UserResponse'
                    )
                )
            )
        ]
    )]
    public function index(): JsonResponse
    {
        $users = User::with('profiles')->get();

        return response()->json($users);
    }

    #[OA\Post(
        path: '/api/users',
        summary: 'Cria um usuário',
        tags: ['Users'],
        security: [['sanctum' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                ref: '#/components/schemas/UserStoreRequest'
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Usuário criado',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/UserResponse'
                )
            )
        ]
    )]
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        return response()->json($user, 201);
    }

    #[OA\Get(
        path: '/api/users/{user}',
        summary: 'Busca um usuário',
        tags: ['Users'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(
                name: 'user',
                description: 'ID do usuário',
                in: 'path',
                required: true,
                schema: new OA\Schema(
                    type: 'integer'
                ),
                example: 1
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Usuário encontrado',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/UserResponse'
                )
            )
        ]
    )]
    public function show(User $user): JsonResponse
    {
        return response()->json(
            $user->load('profiles')
        );
    }

    #[OA\Put(
        path: '/api/users/{user}',
        summary: 'Atualiza um usuário',
        tags: ['Users'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(
                name: 'user',
                description: 'ID do usuário',
                in: 'path',
                required: true,
                schema: new OA\Schema(
                    type: 'integer'
                ),
                example: 1
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                ref: '#/components/schemas/UserUpdateRequest'
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Usuário atualizado',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/UserResponse'
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Usuário não encontrado'
            ),
            new OA\Response(
                response: 422,
                description: 'Dados inválidos'
            )
        ]
    )]
    public function update(
        Request $request,
        User $user
    ): JsonResponse {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $user->id,
            ],
        ]);

        $user->update($validated);

        return response()->json(
            $user->load('profiles')
        );
    }

    #[OA\Delete(
        path: '/api/users/{user}',
        summary: 'Exclui um usuário',
        tags: ['Users'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(
                name: 'user',
                description: 'ID do usuário',
                in: 'path',
                required: true,
                schema: new OA\Schema(
                    type: 'integer'
                ),
                example: 1
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Usuário excluído'
            ),
            new OA\Response(
                response: 404,
                description: 'Usuário não encontrado'
            )
        ]
    )]
    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json([
            'message' => 'Usuário excluído com sucesso.',
        ]);
    }
}