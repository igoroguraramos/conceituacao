<?php

namespace App\Interfaces\Http\OpenApi\Schemas\Requests;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'UserProfileSyncRequest',
    type: 'object',
    required: ['profiles'],
    properties: [
        new OA\Property(
            property: 'profiles',
            type: 'array',
            description: 'IDs dos perfis que serão associados ao usuário',
            items: new OA\Items(
                type: 'integer',
                example: 1
            ),
            example: [1, 2]
        ),
    ]
)]
class UserProfileSyncRequestSchema
{
}