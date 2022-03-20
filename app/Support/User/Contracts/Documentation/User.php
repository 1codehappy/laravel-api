<?php

namespace App\Support\User\Contracts\Documentation;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "User",
    type: "object",
    description: "The schema of the user.",
    properties: [
        new OA\Property(
            property: "id",
            type: "string",
            description: "The UUID of the user."
        ),
        new OA\Property(
            property: "name",
            type: "string",
            description: "The name of the user."
        ),
        new OA\Property(
            property: "email",
            type: "string",
            description: "The email of the user."
        ),
        new OA\Property(
            property: "roles",
            type: "array",
            description: "The roles of the user.",
            items: new OA\Items(ref: "#/components/schemas/Role")
        ),
        new OA\Property(
            property: "permissions",
            type: "array",
            description: "The permissions of the user.",
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
        "id" => "beceedca-46b4-4067-a636-eb9dd5ac5569",
        "name" => "John Doe",
        "email" => "john@example.com",
        "roles" => [
            ["id" => "75a0f2d3-a0d3-4b0b-b02f-65e70656361d", "name" => "Administrator"],
        ],
        "permissions" => [
            ["id" => "aa6fa2a0-65a9-4ea6-84ff-7a82faa10439", "name" => "custom.permission1"],
            ["id" => "a455ac30-f00d-4a23-a0f9-315e03d82f04", "name" => "custom.permission2"],
        ],
        "created_at" => "2022-03-18 20:00:00",
        "updated_at" => "2022-03-18 20:00:00",
    ]
)]
interface User
{
}
