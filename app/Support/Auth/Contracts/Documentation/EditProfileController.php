<?php

namespace App\Support\Auth\Contracts\Documentation;

use App\Backend\Api\Auth\Requests\EditProfileRequest;
use App\Domain\User\Actions\EditUser;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

interface EditProfileController
{
    #[OA\Put(
        path: "/auth/me",
        operationId: "updateProfile",
        summary: "Edit the user's profile.",
        description: "Need to stay logged in to update the user's profile.",
        tags: ["Logged User"],
        requestBody: new OA\RequestBody(
            required: true,
            content: [
                new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(ref: "#/components/schemas/EditProfileRequest")
                ),
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: "User profile updated.",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: "data",
                    ref: "#/components/schemas/User"
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
        response: 422,
        description: "Validation error.",
        content: new OA\JsonContent(
            ref: "#/components/schemas/JsonResponse",
            example: [
                "message" => "The given data was invalid.",
                "errors" => [
                    "email" => ["The email must be a valid email address."],
                ],
            ]
        )
    )]
    public function __invoke(EditProfileRequest $request, EditUser $action): JsonResponse;
}
