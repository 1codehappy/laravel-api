<?php

/**
 * @OA\Delete(
 *     path="/users/{id}",
 *     operationId="deleteUser",
 *     tags={"User Accounts"},
 *     summary="Delete user",
 *     description="Remove user from database",
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
 *     @OA\Response(
 *         response=204,
 *         description="No content"
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
 *         response=500,
 *         description="Fatal error",
 *         @OA\JsonContent(
 *             ref="#/components/schemas/Response",
 *             example={"status_code"=500, "message"="An error occurs while deleting the user."}
 *         )
 *     ),
 *     security={
 *         {"bearerAuth": {}}
 *     }
 * )
 */
