<?php

namespace App\Interfaces\Http\OpenApi\Schemas\Responses;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'ProfileResponse',
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
            example: 'Administrador'
        ),
        new OA\Property(
            property: 'slug',
            type: 'string',
            example: 'admin'
        ),
        new OA\Property(
            property: 'description',
            type: 'string',
            nullable: true,
            example: 'Acesso administrativo'
        ),
        new OA\Property(
            property: 'created_at',
            type: 'string',
            format: 'date-time',
            example: '2026-08-14T02:35:02.000000Z'
        ),
        new OA\Property(
            property: 'updated_at',
            type: 'string',
            format: 'date-time',
            example: '2026-08-14T02:35:02.000000Z'
        ),
    ]
)]
class ProfileResponseSchema
{
}