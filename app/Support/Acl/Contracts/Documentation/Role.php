<?php

namespace App\Support\Acl\Contracts\Documentation;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Role",
    type: "object",
    description: "The schema of the role.",
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
            property: "permissions",
            type: "array",
            description: "The permissions of the role.",
            items: new OA\Items(ref: "#/components/schemas/Permission")
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
        "id" => "75a0f2d3-a0d3-4b0b-b02f-65e70656361d",
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
        "created_at" => "2022-03-18 20:00:00",
        "updated_at" => "2022-03-18 20:00:00",
    ]
)]
interface Role
{
}
