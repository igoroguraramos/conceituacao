<?php

namespace App\Interfaces\Http\Controllers;

use App\Application\User\UseCases\CreateUserUseCase;
use App\Application\User\UseCases\DeleteUserUseCase;
use App\Application\User\UseCases\GetUserUseCase;
use App\Application\User\UseCases\ListUsersUseCase;
use App\Application\User\UseCases\UpdateUserUseCase;
use App\Interfaces\Http\Requests\User\StoreUserRequest;
use App\Interfaces\Http\Requests\User\UpdateUserRequest;
use App\Interfaces\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class UserController extends Controller
{
    public function __construct(
        private readonly ListUsersUseCase $listUsers,
        private readonly GetUserUseCase $getUser,
        private readonly CreateUserUseCase $createUser,
        private readonly UpdateUserUseCase $updateUser,
        private readonly DeleteUserUseCase $deleteUser,
    ) {
    }

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
    public function index(): AnonymousResourceCollection
    {
        return UserResource::collection(
            $this->listUsers->execute()
        );
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
    public function store(
        StoreUserRequest $request
    ): UserResource {
        $user = $this->createUser->execute(
            $request->validated()
        );

        return new UserResource($user);
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
    public function show(User $user): UserResource
    {
        $user = $this->getUser->execute($user->id);

        return new UserResource($user);
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
        UpdateUserRequest $request,
        User $user
    ): UserResource {
        $user = $this->updateUser->execute(
            $user,
            $request->validated()
        );

        return new UserResource($user);
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
        $this->deleteUser->execute($user);

        return response()->json(
            status: 204
        );
    }
}