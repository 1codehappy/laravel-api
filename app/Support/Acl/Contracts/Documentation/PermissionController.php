<?php

namespace App\Support\Acl\Contracts\Documentation;

use App\Domain\Acl\Actions\PaginatePermission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

interface PermissionController
{
    #[OA\Get(
        path: "/permissions",
        operationId: "paginatePermission",
        summary: "Get permission list.",
        description: "Paginate all permissions.",
        tags: ['ACL'],
        parameters: [
            new OA\Parameter(
                name: "filter[name]",
                description: "Search by permission name.",
                required: false,
                in: "query",
                schema: new OA\Schema(type: "string")
            ),
            new OA\Parameter(
                name: "sort",
                description: "Sort by.",
                required: false,
                in: "query",
                schema: new OA\Schema(
                    type: "string",
                    enum: ["name", "-name", "created_at", "-created_at", "updated_at", "-updated_at"]
                )
            ),
            new OA\Parameter(
                name: "page",
                description: "Get permissions by page.",
                required: false,
                in: "query",
                schema: new OA\Schema(type: "integer", format: "int32")
            ),
            new OA\Parameter(
                name: "per_page",
                description: "Show x permissions per page.",
                required: false,
                in: "query",
                schema: new OA\Schema(type: "integer", format: "int32")
            ),
        ]
    )]
    #[OA\Response(
        response: 200,
        description: "Success.",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: "data",
                    type: "array",
                    items: new OA\Items(ref: "#components/schemas/Permission")
                ),
                new OA\Property(
                    property: "meta",
                    type: "object",
                    properties: [
                        new OA\Property(
                            property: 'pagination',
                            type: "array",
                            items: new OA\Items(ref: "#components/schemas/Pagination")
                        ),
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
    #[OA\Response(
        response: 403,
        description: "User doesn't have the right permissions.",
        content: new OA\JsonContent(
            ref: "#/components/schemas/JsonResponse",
            example: ["message" => "Forbidden."]
        )
    )]
    public function index(Request $request, PaginatePermission $action): JsonResponse;
}
