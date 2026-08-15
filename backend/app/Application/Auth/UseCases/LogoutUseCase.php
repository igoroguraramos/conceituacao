<?php

namespace App\Application\Auth\UseCases;

use Illuminate\Http\Request;

class LogoutUseCase
{
    public function execute(Request $request): void
    {
        $request->user()->currentAccessToken()?->delete();
    }
}