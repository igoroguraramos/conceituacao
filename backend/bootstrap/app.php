<?php

use App\Domain\Profile\Exceptions\SlugAlreadyInUseException;
use App\Domain\User\Exceptions\EmailAlreadyInUseException;
use App\Http\Middleware\EnsureUserHasProfile;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'profile' => EnsureUserHasProfile::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (EmailAlreadyInUseException|SlugAlreadyInUseException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json(['message' => $e->getMessage()], 422);
            }
        });

            $exceptions->render(function (QueryException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json(['message' => 'Erro ao acessar o banco de dados.'], 500);
            }
        });
    })->create();
