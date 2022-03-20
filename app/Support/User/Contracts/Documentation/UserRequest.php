<?php

namespace App\Support\User\Contracts\Documentation;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "UserRequest",
    type: "object",
    properties: [
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
            description: "The set of role names.",
            items: new OA\Items(type: "string")
        ),
        new OA\Property(
            property: "permissions",
            type: "array",
            description: "The set of permission names.",
            items: new OA\Items(type: "string")
        ),
    ],
    example: [
        "name" => "John Doe",
        "email" => "john@exampple.com",
        "roles" => ["Administrator"],
        "permissions" => ["custom.permission1", "custom.permission2"],
    ]
)]
interface UserRequest
{
}
