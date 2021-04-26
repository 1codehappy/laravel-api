<?php

/**
 * @OA\Get(
 *     path="/users",
 *     operationId="getUsersList",
 *     tags={"Users"},
 *     summary="Get list of users",
 *     description="Returns list of users",
 *     @OA\Parameter(
 *         name="id",
 *         description="The ID of user",
 *         required=false,
 *         in="query",
 *         @OA\Schema(
 *              type="string"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="name",
 *         description="Name",
 *         required=false,
 *         in="query",
 *         @OA\Schema(
 *              type="string"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="name",
 *         description="Email",
 *         required=false,
 *         in="query",
 *         @OA\Schema(
 *              type="string"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="sort",
 *         description="Sort by id, name, email, created_at",
 *         required=false,
 *         in="query",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="page",
 *         description="Current page",
 *         required=false,
 *         in="query",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="limit",
 *         description="Rows per page",
 *         required=false,
 *         in="query",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(
 *                     ref="#/components/schemas/User"
 *                 )
 *             ),
 *             @OA\Property(
 *                 property="meta",
 *                 type="object",
 *                 @OA\Property(
 *                     property="pagination",
 *                     type="array",
 *                     @OA\Items(
 *                         ref="#/components/schemas/Pagination",
 *                     )
 *                 )
 *             )
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
 *     security={{"bearerAuth": {}}}
 * )
 */
