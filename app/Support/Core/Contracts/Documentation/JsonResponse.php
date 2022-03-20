<?php

namespace App\Support\Core\Contracts\Documentation;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "JsonResponse",
    type: "object",
    description: "The structure of the api response.",
    properties: [
        new OA\Property(
            property: "message",
            type: "string",
            description: "The message of the response.",
        ),
        new OA\Property(
            property: "errors",
            type: "array",
            description: "The error messages of the response if exists.",
            items: new OA\Items(type: "string")
        ),
    ]
)]
interface JsonResponse
{
}
