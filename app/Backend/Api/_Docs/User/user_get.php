<?php

/**
 * @OA\Get(
 *     path="/users/{id}",
 *     operationId="getUserById",
 *     tags={"Users"},
 *     summary="Get user information",
 *     description="Returns user data",
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
 *     @OA\Response(
 *         response=200,
 *         description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 ref="#/components/schemas/User"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             ref="#/components/schemas/Response",
 *             example={"status_code"=401, "message"="Unauthenticated."}
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
 *     security={
 *         {"bearerAuth": {}}
 *     }
 * )
 */
