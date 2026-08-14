<?php

namespace App\Http\Controllers;

use App\Application\UserProfile\Jobs\DetachUserProfileJob;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class UserProfileController extends Controller
{
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
        Request $request,
        User $user
    ): JsonResponse {
        $validated = $request->validate([
            'profiles' => ['required', 'array'],
            'profiles.*' => ['integer', 'exists:profiles,id'],
        ]);

        $user->profiles()->sync($validated['profiles']);

        return response()->json(
            $user->load('profiles')
        );
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
                response: 202,
                description: 'Desassociação enfileirada com sucesso.',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/UserResponse'
                )
            )
        ]
    )]
    public function detach(
        Request $request,
        User $user
    ): JsonResponse {
        $validated = $request->validate([
            'profiles' => ['required', 'array'],
            'profiles.*' => ['integer', 'exists:profiles,id'],
        ]);

        foreach ($validated['profiles'] as $profileId) {
            DetachUserProfileJob::dispatch($user->id, $profileId);
        }

        return response()->json(['message' => 'Desassociação enfileirada com sucesso.'], 202);
    }
}