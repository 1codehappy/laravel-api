<?php

namespace App\Support\Acl\Contracts\Documentation;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Permission",
    type: "object",
    description: "The schema of the permission.",
    properties: [
        new OA\Property(
            property: "id",
            type: "string",
            description: "The UUID of the role."
        ),
        new OA\Property(
            property: "name",
            type: "string",
            description: "The name of the role."
        ),
        new OA\Property(
            property: "created_at",
            type: "string",
            format: "datetime",
            description: "The date of the creation."
        ),
        new OA\Property(
            property: "updated_at",
            type: "string",
            format: "datetime",
            description: "The date of the last update."
        ),
    ],
    example: [
        "id" => "51a0f12a-5e73-4c04-a5aa-f9322e61e2b7",
        "name" => "permission.viewAny",
        "created_at" => "2022-03-18 20:00:00",
        "updated_at" => "2022-03-18 20:00:00",
    ]
)]
interface Permission
{
}
