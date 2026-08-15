<?php

namespace App\Interfaces\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasProfile
{
    public function handle(
        Request $request,
        Closure $next,
        string $profile
    ): Response {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Não autenticado.',
            ], 401);
        }

        if (!$user->profiles()->where('slug', $profile)->exists()) {
            return response()->json([
                'message' => 'Você não possui permissão para realizar esta ação.',
            ], 403);
        }

        return $next($request);
    }
}