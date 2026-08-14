<?php

namespace App\Interfaces\Http\OpenApi\Schemas\Requests;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'ProfileUpdateRequest',
    type: 'object',
    required: ['name'],
    properties: [
        new OA\Property(
            property: 'name',
            type: 'string',
            maxLength: 255,
            example: 'Administrador'
        ),
        new OA\Property(
            property: 'description',
            type: 'string',
            nullable: true,
            example: 'Acesso administrativo'
        ),
    ]
)]
class ProfileUpdateRequestSchema
{
}