<?php

/**
 * @OA\Delete(
 *     path="/roles/{id}",
 *     operationId="deleteRole",
 *     tags={"Roles & Permissions"},
 *     summary="Delete role",
 *     description="Remove role from database",
 *     @OA\Parameter(
 *         name="id",
 *         description="The ID of role",
 *         required=true,
 *         in="path",
 *         @OA\Schema(
 *             type="string",
 *             example="75a0f2d3-a0d3-4b0b-b02f-65e70656361d"
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
 *         response=500,
 *         description="Fatal error",
 *         @OA\JsonContent(
 *             ref="#/components/schemas/Response",
 *             example={"status_code"=500, "message"="An error occurs while deleting the role."}
 *         )
 *     ),
 *     security={
 *         {"bearerAuth": {}}
 *     }
 * )
 */
