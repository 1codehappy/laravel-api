<?php

namespace App\Support\Acl\Contracts\Documentation;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "RoleRequest",
    type: "object",
    properties: [
        new OA\Property(
            property: "name",
            type: "string",
            description: "The name of the role."
        ),
        new OA\Property(
            property: "permissions",
            type: "array",
            description: "The set of permission names.",
            items: new OA\Items(type: "string")
        ),
    ],
    example: [
        "name" => "Administrator",
        "permissions" => [
            "permissions.viewAny",
            "roles.viewAny",
            "roles.view",
            "roles.create",
            "roles.update",
            "roles.delete",
            "users.viewAny",
            "users.view",
            "users.create",
            "users.update",
            "users.delete",
        ],
    ]
)]
interface RoleRequest
{
}
