<?php

namespace App\Support\Auth\Contracts\Documentation;

use OpenApi\Attributes as OA;

#[OA\Post(
    path: "/auth/logout",
    operationId: "logout",
    summary: "Sign out.",
    description: "Logged users are able to log out.",
    tags: ["Auth"]
)]
#[OA\Response(
    response: 200,
    description: "Ok.",
    content: new OA\JsonContent(
        ref: "#/components/schemas/JsonResponse",
        example: ["message" => "You've been logged out."]
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
interface LogoutController
{
}
