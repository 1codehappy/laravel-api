<?php

/**
 * @OA\Get(
 *     path="/roles",
 *     operationId="getRolesList",
 *     tags={"Roles & Permissions"},
 *     summary="Get list of roles",
 *     description="Returns list of roles",
 *     @OA\Parameter(
 *         name="name",
 *         description="The name of role",
 *         required=false,
 *         in="query",
 *         @OA\Schema(
 *              type="string"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="sort",
 *         description="Sort by name, created_at",
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
 *             type="integer",
 *             format="int32"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="per_page",
 *         description="Rows per page",
 *         required=false,
 *         in="query",
 *         @OA\Schema(
 *             type="integer",
 *             format="int32"
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
 *                     ref="#/components/schemas/Role"
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
 *             example={"message"="Authentication failure."}
 *         )
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Access denied",
 *         @OA\JsonContent(
 *             ref="#/components/schemas/Response",
 *             example={"message"="User does not have the right permissions."}
 *         )
 *     ),
 *     security={{"bearerAuth": {}}}
 * )
 */
