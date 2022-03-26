<?php

namespace App\Support\Auth\Contracts\Documentation;

use OpenApi\Attributes as OA;

#[OA\Post(
    path: "/auth/refresh",
    operationId: "refreshToken",
    summary: "Refresh the token.",
    description: "Logged users are able to refresh the JWT Token.",
    tags: ["Auth"]
)]
#[OA\Response(
    response: 201,
    description: "Created.",
    content: new OA\JsonContent(
        ref: "#/components/schemas/Token",
    )
)]
#[OA\Response(
    response: 401,
    description: "Unauthorized.",
    content: new OA\JsonContent(
        ref: "#/components/schemas/JsonResponse",
        example: ["message" => "Unauthenticated."]
    )
)]
interface RefreshTokenController
{
}
