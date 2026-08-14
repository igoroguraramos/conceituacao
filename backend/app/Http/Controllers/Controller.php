<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'API - Gestão de Usuários',
    description: 'API para gerenciamento de usuários e perfis, incluindo operações de criação, leitura, atualização e exclusão (CRUD).'
)]
#[OA\SecurityScheme(
    securityScheme: 'sanctum',
    type: 'http',
    scheme: 'bearer',
    bearerFormat: 'token',
    description: 'Token retornado por /login ou /register. Enviar como '.
        'Authorization: Bearer {token}.'
)]
abstract class Controller
{
    //
}
