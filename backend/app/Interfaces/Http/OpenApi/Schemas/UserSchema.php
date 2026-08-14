<?php

namespace App\Interfaces\Http\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'User',
    type: 'object',
    properties: [
        new OA\Property(
            property: 'id',
            type: 'integer',
            example: 1
        ),
        new OA\Property(
            property: 'name',
            type: 'string',
            example: 'Igor Ogura Ramos'
        ),
        new OA\Property(
            property: 'email',
            type: 'string',
            format: 'email',
            example: 'igor@email.com'
        ),
        new OA\Property(
            property: 'created_at',
            type: 'string',
            format: 'date-time',
            example: '2026-08-14T10:30:00Z'
        ),
        new OA\Property(
            property: 'updated_at',
            type: 'string',
            format: 'date-time',
            example: '2026-08-14T10:30:00Z'
        ),
    ]
)]
class UserSchema
{
}