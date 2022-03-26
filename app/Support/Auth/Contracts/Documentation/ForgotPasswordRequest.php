<?php

namespace App\Support\Auth\Contracts\Documentation;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "ForgotPasswordRequest",
    type: "object",
    description: "Request data for sending a reset link to the user.",
    required: ["email"],
    properties: [
        new OA\Property(
            property: "email",
            type: "string",
            format: "email",
            description: "The email of the user."
        ),
    ],
    example: [
        "email" => "olamundo@gmail.com",
    ]
)]
interface ForgotPasswordRequest
{
}
