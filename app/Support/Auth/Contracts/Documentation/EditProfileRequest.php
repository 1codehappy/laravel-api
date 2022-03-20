<?php

namespace App\Support\Auth\Contracts\Documentation;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "EditProfileRequest",
    type: "object",
    description: "Request data for updating user's profile.",
    required: ["name", "email"],
    properties: [
        new OA\Property(
            property: "name",
            type: "string",
            description: "The new name of the user."
        ),
        new OA\Property(
            property: "email",
            type: "string",
            format: "email",
            description: "The new email of the user."
        ),
    ],
    example: [
        "name" => "Gilberto Junior",
        "email" => "olamundo@gmail.com",
    ]
)]
interface EditProfileRequest
{
}
