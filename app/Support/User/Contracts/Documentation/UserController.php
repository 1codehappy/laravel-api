<?php

namespace App\Support\User\Contracts\Documentation;

use App\Backend\Api\User\Requests\UserRequest;
use App\Domain\User\Actions\CreateUser;
use App\Domain\User\Actions\DeleteUser;
use App\Domain\User\Actions\EditUser;
use App\Domain\User\Actions\PaginateUser;
use App\Domain\User\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

interface UserController
{
    #[OA\Get(
        path: "/users",
        operationId: "paginateUser",
        summary: "Get user list.",
        description: "Paginate all users.",
        tags: ['User'],
        parameters: [
            new OA\Parameter(
                name: "filter[name]",
                description: "Search by user's name.",
                required: false,
                in: "query",
                schema: new OA\Schema(type: "string")
            ),
            new OA\Parameter(
                name: "filter[email]",
                description: "Search by user's email.",
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
                description: "Get users by page.",
                required: false,
                in: "query",
                schema: new OA\Schema(type: "integer", format: "int32")
            ),
            new OA\Parameter(
                name: "per_page",
                description: "Show x users per page.",
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
                    items: new OA\Items(ref: "#components/schemas/User")
                ),
                new OA\Property(
                    property: "meta",
                    type: "object",
                    properties: [
                        new OA\Property(
                            property: 'pagination',
                            type: "array",
                            items: new OA\Items(ref: "#components/schemas/User")
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
    public function index(Request $request, PaginateUser $action): JsonResponse;

    #[OA\Get(
        path: "/users/{uuid}",
        operationId: "getUser",
        summary: "Get the user data.",
        description: "Display the user data.",
        tags: ['User'],
        parameters: [
            new OA\Parameter(
                name: "uuid",
                description: "The UUID of the user",
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
        description: "User not found.",
        content: new OA\JsonContent(
            ref: "#/components/schemas/JsonResponse",
            example: ["message" => "Not found."]
        )
    )]
    public function show(User $user): JsonResponse;

    #[OA\Post(
        path: "/users",
        operationId: "createUser",
        summary: "Create a new user.",
        description: "Create a new user with permissions.",
        tags: ['User'],
        requestBody: new OA\RequestBody(
            description: "Form request.",
            required: true,
            content: [
                new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(ref: "#/components/schemas/UserRequest")
                ),
            ]
        )
    )]
    #[OA\Response(
        response: 201,
        description: "Created.",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: "data",
                    type: "object",
                    properties: [new OA\Property(ref: "#components/schemas/User")]
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
    public function store(UserRequest $request, CreateUser $action): JsonResponse;

    #[OA\Put(
        path: "/users/{uuid}",
        operationId: "updateUser",
        summary: "Update the user data.",
        description: "Update the user with permissions.",
        tags: ['User'],
        parameters: [
            new OA\Parameter(
                name: "uuid",
                description: "The UUID of the user",
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
                    schema: new OA\Schema(ref: "#/components/schemas/UserRequest")
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
                    properties: [new OA\Property(ref: "#components/schemas/User")]
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
    public function update(UserRequest $request, User $user, EditUser $action): JsonResponse;

    #[OA\Delete(
        path: "/users/{uuid}",
        operationId: "deleteUser",
        summary: "Delete the user data.",
        description: "Remove the user. The permissions related with the user won't be removed.",
        tags: ['User'],
        parameters: [
            new OA\Parameter(
                name: "uuid",
                description: "The UUID of the user",
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
        description: "User not found.",
        content: new OA\JsonContent(
            ref: "#/components/schemas/JsonResponse",
            example: ["message" => "Not found."]
        )
    )]
    public function destroy(User $user, DeleteUser $action): JsonResponse;
}
