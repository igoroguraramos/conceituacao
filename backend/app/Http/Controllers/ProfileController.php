<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(): JsonResponse
    {
        $profiles = Profile::all();

        return response()->json($profiles);
    }

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

    public function show(Profile $profile): JsonResponse
    {
        return response()->json($profile);
    }

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

    public function destroy(Profile $profile): JsonResponse
    {
        $profile->delete();

        return response()->json([
            'message' => 'Perfil excluído com sucesso.',
        ]);
    }
}