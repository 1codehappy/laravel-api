<?php

namespace App\Support\Auth\Contracts\Documentation;

use OpenApi\Attributes as OA;

#[OA\Get(
    path: "/auth/me",
    operationId: "getProfile",
    summary: "Get the user's profile.",
    description: "Display the user's profile.",
    tags: ['Logged User'],
    security: ["bearerAuth" => []]
)]
#[OA\Response(
    response: 200,
    description: "Success.",
    content: new OA\JsonContent(
        properties: [
            new OA\Property(
                property: "data",
                type: "object",
                properties: [
                    new OA\Property(ref: "#components/schemas/User"),
                ]
            ),
        ]
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
interface GetProfileController
{
}
