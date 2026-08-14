<?php

namespace App\Interfaces\Http\Controllers;

use App\Application\Profile\UseCases\CreateProfileUseCase;
use App\Application\Profile\UseCases\DeleteProfileUseCase;
use App\Application\Profile\UseCases\GetProfileUseCase;
use App\Application\Profile\UseCases\ListProfilesUseCase;
use App\Application\Profile\UseCases\UpdateProfileUseCase;
use App\Interfaces\Http\Requests\Profile\StoreProfileRequest;
use App\Interfaces\Http\Requests\Profile\UpdateProfileRequest;
use App\Interfaces\Http\Resources\ProfileResource;
use App\Models\Profile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class ProfileController extends Controller
{
    public function __construct(
        private readonly ListProfilesUseCase $listProfiles,
        private readonly GetProfileUseCase $getProfile,
        private readonly CreateProfileUseCase $createProfile,
        private readonly UpdateProfileUseCase $updateProfile,
        private readonly DeleteProfileUseCase $deleteProfile,
    ) {
    }

    #[OA\Get(
        path: '/api/profiles',
        summary: 'Lista os perfis',
        tags: ['Profiles'],
        security: [['sanctum' => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Lista de perfis',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        ref: '#/components/schemas/ProfileResponse'
                    )
                )
            )
        ]
    )]
    public function index(): AnonymousResourceCollection
    {
        return ProfileResource::collection(
            $this->listProfiles->execute()
        );
    }

    #[OA\Post(
        path: '/api/profiles',
        summary: 'Cria um perfil',
        tags: ['Profiles'],
        security: [['sanctum' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                ref: '#/components/schemas/ProfileStoreRequest'
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Perfil criado',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/ProfileResponse'
                )
            ),
            new OA\Response(
                response: 422,
                description: 'Dados inválidos'
            )
        ]
    )]
    public function store(StoreProfileRequest $request): ProfileResource
    {
        $profile = $this->createProfile->execute(
            $request->validated()
        );

        return new ProfileResource($profile);
    }

    #[OA\Get(
        path: '/api/profiles/{profile}',
        summary: 'Busca um perfil',
        tags: ['Profiles'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(
                name: 'profile',
                description: 'ID do perfil',
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
                description: 'Perfil encontrado',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/ProfileResponse'
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Perfil não encontrado'
            )
        ]
    )]
    public function show(Profile $profile): ProfileResource
    {
        $profile = $this->getProfile->execute($profile->id);

        return new ProfileResource($profile);
    }

    #[OA\Put(
        path: '/api/profiles/{profile}',
        summary: 'Atualiza um perfil',
        tags: ['Profiles'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(
                name: 'profile',
                description: 'ID do perfil',
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
                ref: '#/components/schemas/ProfileUpdateRequest'
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Perfil atualizado',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/ProfileResponse'
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Perfil não encontrado'
            ),
            new OA\Response(
                response: 422,
                description: 'Dados inválidos'
            )
        ]
    )]
    public function update(
        UpdateProfileRequest $request,
        Profile $profile
    ): ProfileResource {
        $profile = $this->updateProfile->execute(
            $profile,
            $request->validated()
        );

        return new ProfileResource($profile);
    }

    #[OA\Delete(
        path: '/api/profiles/{profile}',
        summary: 'Exclui um perfil',
        tags: ['Profiles'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(
                name: 'profile',
                description: 'ID do perfil',
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
                description: 'Perfil excluído'
            ),
            new OA\Response(
                response: 404,
                description: 'Perfil não encontrado'
            )
        ]
    )]
    public function destroy(Profile $profile): JsonResponse
    {
        $this->deleteProfile->execute($profile);

        return response()->json(
            status: 204
        );
    }
}