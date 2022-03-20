<?php

namespace App\Support\Auth\Contracts\Documentation;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "LoginRequest",
    type: "object",
    description: "Request data to generate a valid token to authenticate.",
    required: ["email", "password"],
    properties: [
        new OA\Property(
            property: "email",
            type: "string",
            format: "email",
            description: "The email of the user."
        ),
        new OA\Property(
            property: "password",
            type: "string",
            description: "The password of the user."
        ),
    ],
    example: [
        "email" => "olamundo@gmail.com",
        "password" => "secret1234",
    ]
)]
interface LoginRequest
{
}
