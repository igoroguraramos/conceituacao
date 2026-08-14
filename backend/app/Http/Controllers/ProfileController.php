<?php

namespace App\Http\Controllers;
use OpenApi\Attributes as OA;
use App\Models\Profile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
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
    public function index(): JsonResponse
    {
        $profiles = Profile::all();

        return response()->json($profiles);
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
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $profile = Profile::create([
            'name' => $validated['name'],
            'slug' => \Illuminate\Support\Str::slug($validated['name']),
            'description' => $request->input('description', ''),
        ]);

        return response()->json($profile, 201);
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
    public function show(Profile $profile): JsonResponse
    {
        return response()->json($profile);
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
        Request $request,
        Profile $profile
    ): JsonResponse {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'], 
        ]);

        $profile->update([
            'name' => $validated['name'],
            'slug' => \Illuminate\Support\Str::slug($validated['name']),
            'description' => $request->input('description', $profile->description),
        ]);

        return response()->json($profile);
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
        $profile->delete();

        return response()->json([
            'message' => 'Perfil excluído com sucesso.',
        ]);
    }
}