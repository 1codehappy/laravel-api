<?php

namespace App\Support\Acl\Contracts\Documentation;

use App\Backend\Api\Acl\Requests\RoleRequest;
use App\Domain\Acl\Actions\CreateRole;
use App\Domain\Acl\Actions\DeleteRole;
use App\Domain\Acl\Actions\EditRole;
use App\Domain\Acl\Actions\PaginateRole;
use App\Domain\Acl\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

interface RoleController
{
    #[OA\Get(
        path: "/roles",
        operationId: "paginateRole",
        summary: "Get role list.",
        description: "Paginate all roles.",
        tags: ['ACL'],
        parameters: [
            new OA\Parameter(
                name: "filter[name]",
                description: "Search by role name.",
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
        ],
        security: ["bearerAuth" => []]
    )]
    #[OA\Response(
        response: 200,
        description: "Success.",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: "data",
                    type: "array",
                    items: new OA\Items(ref: "#components/schemas/Role")
                ),
                new OA\Property(
                    property: "meta",
                    type: "object",
                    properties: [
                        new OA\Property(
                            property: 'pagination',
                            type: "array",
                            items: new OA\Items(ref: "#components/schemas/Role")
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
    public function index(Request $request, PaginateRole $action): JsonResponse;

    #[OA\Get(
        path: "/roles/{uuid}",
        operationId: "getRole",
        summary: "Get the role data.",
        description: "Display the role data.",
        tags: ['ACL'],
        parameters: [
            new OA\Parameter(
                name: "uuid",
                description: "The UUID of the role",
                required: true,
                in: "path",
                schema: new OA\Schema(type: "string", example: "75a0f2d3-a0d3-4b0b-b02f-65e70656361d")
            ),
        ],
        security: ["bearerAuth" => []]
    )]
    #[OA\Response(
        response: 200,
        description: "Success.",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: "data",
                    type: "array",
                    items: new OA\Items(ref: "#components/schemas/Role")
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
    #[OA\Response(
        response: 404,
        description: "Role not found.",
        content: new OA\JsonContent(
            ref: "#/components/schemas/JsonResponse",
            example: ["message" => "Not found."]
        )
    )]
    public function show(Role $role): JsonResponse;

    #[OA\Post(
        path: "/roles",
        operationId: "createRole",
        summary: "Create a new role.",
        description: "Create a new role with permissions.",
        tags: ['ACL'],
        requestBody: new OA\RequestBody(
            description: "Form request.",
            required: true,
            content: [
                new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(ref: "#/components/schemas/RoleRequest")
                ),
            ]
        ),
        security: ["bearerAuth" => []]
    )]
    #[OA\Response(
        response: 201,
        description: "Created.",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: "data",
                    type: "object",
                    properties: [new OA\Property(ref: "#components/schemas/Role")]
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
    #[OA\Response(
        response: 422,
        description: "Validation error.",
        content: new OA\JsonContent(
            ref: "#/components/schemas/JsonResponse",
            example: [
                "message" => "The given data was invalid.",
                "errors" => [
                    "field1" => ["The field1 field is required."],
                    "field2" => ["The selected field2 is invalid."],
                ],
            ]
        )
    )]
    public function store(RoleRequest $request, CreateRole $action): JsonResponse;

    #[OA\Put(
        path: "/roles/{uuid}",
        operationId: "updateRole",
        summary: "Update the role data.",
        description: "Update the role with permissions.",
        tags: ['ACL'],
        parameters: [
            new OA\Parameter(
                name: "uuid",
                description: "The UUID of the role",
                required: true,
                in: "path",
                schema: new OA\Schema(type: "string", example: "75a0f2d3-a0d3-4b0b-b02f-65e70656361d")
            ),
        ],
        requestBody: new OA\RequestBody(
            description: "Form request.",
            required: true,
            content: [
                new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(ref: "#/components/schemas/RoleRequest")
                ),
            ]
        ),
        security: ["bearerAuth" => []]
    )]
    #[OA\Response(
        response: 200,
        description: "Updated.",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: "data",
                    type: "object",
                    properties: [new OA\Property(ref: "#components/schemas/Role")]
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
    #[OA\Response(
        response: 422,
        description: "Validation error.",
        content: new OA\JsonContent(
            ref: "#/components/schemas/JsonResponse",
            example: [
                "message" => "The given data was invalid.",
                "errors" => [
                    "field1" => ["The field1 field is required."],
                    "field2" => ["The selected field2 is invalid."],
                ],
            ]
        ),
    )]
    public function update(RoleRequest $request, Role $role, EditRole $action): JsonResponse;

    #[OA\Delete(
        path: "/roles/{uuid}",
        operationId: "deleteRole",
        summary: "Delete the role data.",
        description: "Remove the role. The permissions related with the role won't be removed.",
        tags: ['ACL'],
        parameters: [
            new OA\Parameter(
                name: "uuid",
                description: "The UUID of the role",
                required: true,
                in: "path",
                schema: new OA\Schema(type: "string", example: "75a0f2d3-a0d3-4b0b-b02f-65e70656361d")
            ),
        ],
        security: ["bearerAuth" => []]
    )]
    #[OA\Response(
        response: 204,
        description: "Deleted."
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
    #[OA\Response(
        response: 404,
        description: "Role not found.",
        content: new OA\JsonContent(
            ref: "#/components/schemas/JsonResponse",
            example: ["message" => "Not found."]
        )
    )]
    public function destroy(Role $role, DeleteRole $action): JsonResponse;
}
