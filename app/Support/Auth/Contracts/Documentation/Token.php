<?php

namespace App\Support\Auth\Contracts\Documentation;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Token",
    type: "object",
    description: "The response when the token was generated.",
    required: ["name", "email"],
    properties: [
        new OA\Property(
            property: "message",
            type: "string",
            description: "The message from response."
        ),
        new OA\Property(
            property: "data",
            type: "object",
            description: "The token data.",
            properties: [
                new OA\Property(
                    property: "access_token",
                    type: "string",
                    description: "The new JWT token."
                ),
                new OA\Property(
                    property: "bearer_type",
                    type: "string",
                    description: "The type of header authorization."
                ),
                new OA\Property(
                    property: "expires_in",
                    type: "integer",
                    format: "int32",
                    description: "The time of token expiration in seconds."
                ),
            ]
        ),
    ],
    example: [
        "message" => "The access token has been created.",
        "data" => [
            "access_token" => "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGkudGVuYW50MS5oaXJlZDM2NS5kb2NrZXIuaW50ZXJuYWxcL2xvZ2luIiwiaWF0IjoxNjAzNDc2NTE5LCJleHAiOjE2MDM0ODAxMTksIm5iZiI6MTYwMzQ3NjUxOSwianRpIjoiTlNkUXI0M2gzQTFLMWJRSiIsInN1YiI6MSwicHJ2IjoiMWM5OGY5ZmNlMjZkM2JhNDg0NGNkYmQ5M2MzNjcwZTViNGJkYzlmOSJ9.fPbaYuFhOMdrJdMGyGO01_02BzeAUXMO0gHFyDqPcY4",
            "token_type" => "Bearer",
            "expires_in" => 3600,
        ],
    ]
)]
interface Token
{
}
