<?php

namespace App\Interfaces\Http\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'UserStoreRequestSchema',
    type: 'object',
    required: ['name', 'email', 'password'],
    properties: [
        new OA\Property(
            property: 'name',
            type: 'string',
            maxLength: 255,
            example: 'Igor'
        ),
        new OA\Property(
            property: 'email',
            type: 'string',
            format: 'email',
            maxLength: 255,
            example: 'igor@email.com'
        ),
        new OA\Property(
            property: 'password',
            type: 'string',
            format: 'password',
            minLength: 8,
            example: '12345678'
        ),
    ]
)]
class UserStoreRequestSchema
{
}