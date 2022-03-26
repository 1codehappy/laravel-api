<?php

namespace App\Support\Auth\Contracts\Documentation;

use OpenApi\Attributes as OA;

#[OA\Post(
    path: "/auth/reset-password",
    operationId: "resetPassword",
    summary: "Reset the user's password.",
    description: "Reset the password.",
    tags: ["Auth"],
    requestBody: new OA\RequestBody(
        required: true,
        content: [
            new OA\MediaType(
                mediaType: "application/json",
                schema: new OA\Schema(ref: "#/components/schemas/ResetPasswordRequest")
            ),
        ]
    ),
    security: ["bearerAuth" => []]
)]
#[OA\Response(
    response: 201,
    description: "Ok.",
    content: new OA\JsonContent(
        ref: "#/components/schemas/JsonResponse",
        example: ["message" => "Your password has been reset!"]
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
                "email" => ["The selected email is invalid."],
            ],
        ]
    )
)]
interface ResetPasswordController
{
}
