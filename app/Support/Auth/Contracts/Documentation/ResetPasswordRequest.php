<?php

namespace App\Support\Auth\Contracts\Documentation;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "ResetPasswordRequest",
    type: "object",
    description: "Request data for changing user's password.",
    required: ["token", "email", "password", "password_confirmation"],
    properties: [
        new OA\Property(
            property: "token",
            type: "string",
            description: "The token to reset the password."
        ),
        new OA\Property(
            property: "email",
            type: "string",
            description: "The email of the user."
        ),
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
        "token" => "",
        "email" => "olamundo@gmail.com",
        "password" => "newsecret1234",
        "password_confirmation" => "newsecret1234",
    ]
)]
interface ResetPasswordRequest
{
}
