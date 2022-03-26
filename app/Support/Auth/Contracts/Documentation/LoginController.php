<?php

namespace App\Support\Auth\Contracts\Documentation;

use OpenApi\Attributes as OA;

#[OA\Post(
    path: "/auth/login",
    operationId: "login",
    summary: "Sign in.",
    description: "Registered users are able to log in.",
    tags: ['Auth'],
    requestBody: new OA\RequestBody(
        description: "Form request.",
        required: true,
        content: [
            new OA\MediaType(
                mediaType: "application/json",
                schema: new OA\Schema(ref: "#/components/schemas/LoginRequest")
            ),
        ]
    ),
    security: ["bearerAuth" => []]
)]
#[OA\Response(
    response: 201,
    description: "Created.",
    content: new OA\JsonContent(
        ref: "#/components/schemas/Token"
    )
)]
#[OA\Response(
    response: 401,
    description: "Unauthorized.",
    content: new OA\JsonContent(
        ref: "#/components/schemas/JsonResponse",
        // example: ["message" => __("auth.failed")]
    )
)]
#[OA\Response(
    response: 422,
    description: "Validation error.",
    content: new OA\JsonContent(
        ref: "#/components/schemas/JsonResponse",
        example: [
            "message" => "The given data was invalid.",
            "errors" => [
                "email" => ["The email field is required."],
                "password" => ["The selected email is invalid."],
            ],
        ]
    )
)]
interface LoginController
{
}
