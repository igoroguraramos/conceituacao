<?php

namespace App\Interfaces\Http\Controllers;
use App\Interfaces\Http\Requests\UserProfile\SyncUserProfileRequest;
use App\Application\UserProfile\UseCases\SyncUserProfilesUseCase;
use App\Application\UserProfile\Jobs\DetachUserProfileJob;
use App\Interfaces\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class UserProfileController extends Controller
{
    public function __construct(
        private readonly SyncUserProfilesUseCase $syncUserProfilesUseCase
    ){
    }
    #[OA\Put(
        path: '/api/users/{user}/profiles',
        summary: 'Sincroniza os perfis do usuário',
        description: 'Remove os relacionamentos atuais e associa ao usuário os perfis informados.',
        tags: ['User Profiles'],
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
                ref: '#/components/schemas/UserProfileSyncRequest'
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Perfis sincronizados com sucesso',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/UserResponse'
                )
            )
        ]
    )]
    public function sync(
        SyncUserProfileRequest $request,
        User $user
    ): UserResource {

        $this->syncUserProfilesUseCase->execute($user, $request->validated()['profiles']);

        return new UserResource(
            $user->load('profiles')
        );
    }

    #[OA\Delete(
        path: '/api/users/{user}/profiles',
        summary: 'Desassocia os perfis do usuário',
        description: 'Remove os relacionamentos atuais do usuário com os perfis informados.',
        tags: ['User Profiles'],
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
                ref: '#/components/schemas/UserProfileSyncRequest'
            )
        ),
        responses: [
            new OA\Response(
                response: 202,
                description: 'Desassociação enfileirada com sucesso.',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/UserResponse'
                )
            )
        ]
    )]
    public function detach(
        SyncUserProfileRequest $request,
        User $user
    ): JsonResponse {
        foreach ($request->validated()['profiles'] as $profileId) {
            DetachUserProfileJob::dispatch($user->id, $profileId);
        }

        return response()->json(['message' => 'Desassociação enfileirada com sucesso.'], 202);
    }
}