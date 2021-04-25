<?php

/**
 * @OA\Put(
 *     path="/users/{id}",
 *     operationId="updateUser",
 *     tags={"User Accounts"},
 *     summary="Update user's data",
 *     description="Returns user data",
 *     @OA\Parameter(
 *         name="X-Tenant",
 *         required=true,
 *         in="header",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="id",
 *         description="The ID of user",
 *         required=true,
 *         in="path",
 *         @OA\Schema(
 *             type="string",
 *             example="d3ba0542-73b2-4b19-be42-e5fa528d1a94"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="name",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="email",
 *                     type="string",
 *                     format="email"
 *                 ),
 *                 @OA\Property(
 *                     property="roles",
 *                     type="array",
 *                     @OA\Items(
 *                         type="string"
 *                     )
 *                 ),
 *                 @OA\Property(
 *                     property="permissions",
 *                     type="array",
 *                     @OA\Items(
 *                         type="string"
 *                     )
 *                 ),
 *                 example={
 *                     "name": "John Doe",
 *                     "email": "john.doe@gmail.com",
 *                     "roles": {"HR Analyst"},
 *                     "permissions": {"Edit candidate"}
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", ref="#/components/schemas/User")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             ref="#/components/schemas/Response",
 *             example={"status_code"=401, "message"="Authentication failure."}
 *         )
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Access denied",
 *         @OA\JsonContent(
 *             ref="#/components/schemas/Response",
 *             example={"status_code"=403, "message"="User does not have the right permissions."}
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Not found",
 *         @OA\JsonContent(
 *             ref="#/components/schemas/Response",
 *             example={"status_code"=404, "message"="User not found."}
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Unprocessable Entity",
 *         @OA\JsonContent(
 *             ref="#/components/schemas/Response",
 *             example={"status_code"=422, "message"="The given data was invalid."}
 *         )
 *     ),
 *     security={
 *         {"bearerAuth": {}}
 *     }
 * )
 */
