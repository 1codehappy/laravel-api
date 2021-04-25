<?php

/**
 * @OA\Get(
 *     path="/roles/{id}",
 *     operationId="getRoleById",
 *     tags={"Roles & Permissions"},
 *     summary="Get role information",
 *     description="Returns role data",
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
 *         description="The ID of role",
 *         required=true,
 *         in="path",
 *         @OA\Schema(
 *             type="string",
 *             example="75a0f2d3-a0d3-4b0b-b02f-65e70656361d"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 ref="#/components/schemas/Role"
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
 *     @OA\Response(
 *         response=404,
 *         description="Not found",
 *         @OA\JsonContent(
 *             ref="#/components/schemas/Response",
 *             example={"status_code"=404, "message"="Role not found."}
 *         )
 *     ),
 *     security={
 *         {"bearerAuth": {}}
 *     }
 * )
 */
