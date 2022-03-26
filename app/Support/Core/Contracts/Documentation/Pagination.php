<?php

namespace App\Support\Core\Contracts\Documentation;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Pagination",
    type: "object",
    description: "The structure of the pagination.",
    properties: [
        new OA\Property(
            property: "total",
            type: "integer",
            format: "int32",
            description: "The total of records affected.",
        ),
        new OA\Property(
            property: "count",
            type: "integer",
            format: "int32",
            description: "The counting of displayed records.",
        ),
        new OA\Property(
            property: "per_page",
            type: "integer",
            format: "int32",
            description: "The maximun records displayed per page.",
        ),
        new OA\Property(
            property: "current_page",
            type: "integer",
            format: "int32",
            description: "The number of current page.",
        ),
        new OA\Property(
            property: "total_pages",
            type: "integer",
            format: "int32",
            description: "The total of pages.",
        ),
        new OA\Property(
            property: "links",
            type: "array",
            description: "The urls for these links.",
            items: new OA\Items(type: "string")
        ),
    ],
    example: [
        'total' => 1,
        'count' => 1,
        'per_page' => 1,
        'current_page' => 1,
        'total_pages' => 1,
        'links' => [],
    ]
)]
interface Pagination
{
}
