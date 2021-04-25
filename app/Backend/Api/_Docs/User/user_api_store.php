<?php

/**
 * @OA\Post(
 *     path="/users",
 *     operationId="createUser",
 *     tags={"User Accounts"},
 *     summary="Create a new user",
 *     description="Returns user data",
 *     @OA\Parameter(
 *         name="X-Tenant",
 *         required=true,
 *         in="header",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 required={"name", "email", "paswword", "password_confirmation"},
 *                 @OA\Property(
 *                     property="name",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="email",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="paswword",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="password_confirmation",
 *                     type="string"
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
 *                     "password": "secret1234",
 *                     "password_confirmation": "secret1234",
 *                     "roles": {"HR Analyst"},
 *                     "permissions": {"Edit candidate"}
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Created",
 *         @OA\JsonContent(ref="#/components/schemas/User")
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
