<?php

namespace App\Interfaces\Http\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'UserUpdateRequestSchema',
    type: 'object',
    required: [
        'name',
        'email',
    ],
    properties: [
        new OA\Property(
            property: 'name',
            type: 'string',
            maxLength: 255,
            example: 'Igor Ogura Ramos'
        ),
        new OA\Property(
            property: 'email',
            type: 'string',
            format: 'email',
            maxLength: 255,
            example: 'igor@email.com'
        ),
    ]
)]
class UserUpdateRequestSchema
{
}