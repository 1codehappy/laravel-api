<?php

namespace App\Support\Auth\Contracts\Documentation;

use OpenApi\Attributes as OA;

#[OA\Put(
    path: "/auth/me/password",
    operationId: "changePassword",
    summary: "Change the user's password.",
    description: "Need to stay logged in to change the password.",
    tags: ["Logged User"],
    requestBody: new OA\RequestBody(
        required: true,
        content: [
            new OA\MediaType(
                mediaType: "application/json",
                schema: new OA\Schema(ref: "#/components/schemas/ChangePasswordRequest")
            ),
        ]
    )
)]
#[OA\Response(
    response: 200,
    description: "Ok.",
    content: new OA\JsonContent(
        ref: "#/components/schemas/JsonResponse",
        example: ["message" => "Your password has been changed."]
    )
)]
#[OA\Response(
    response: 401,
    description: "User not authenticated.",
    content: new OA\JsonContent(
        ref: "#/components/schemas/JsonResponse",
        example: ["message" => "Unauthenticated."]
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
                "password" => ["The selected password is invalid."],
            ],
        ]
    )
)]
interface ChangePasswordController
{
}
