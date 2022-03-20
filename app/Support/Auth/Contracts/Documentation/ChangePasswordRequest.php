<?php

namespace App\Support\Auth\Contracts\Documentation;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "ChangePasswordRequest",
    type: "object",
    description: "Request data for changing user's password.",
    required: ["password", "password_confirmation"],
    properties: [
        new OA\Property(
            property: "password",
            type: "string",
            description: "The new password of the user."
        ),
        new OA\Property(
            property: "password_confirmation",
            type: "string",
            description: "The password confirmation of the user."
        ),
    ],
    example: [
        "password" => "secret1234",
        "password_confirmation" => "secret1234",
    ]
)]
interface ChangePasswordRequest
{
}
