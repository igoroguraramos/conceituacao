<?php

namespace App\Interfaces\Http\OpenApi\Schemas\Responses;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'LoginResponse',
    type: 'object',
    properties: [
        new OA\Property(
            property: 'token',
            type: 'string',
            example: '1|xxxxxxxxxxxxxxxxxxxxxxxx'
        ),
        new OA\Property(
            property: 'user',
            ref: '#/components/schemas/UserResponse'
        ),
    ]
)]
class LoginResponseSchema
{
}