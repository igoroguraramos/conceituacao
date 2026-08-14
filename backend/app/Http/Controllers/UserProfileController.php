<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
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
}