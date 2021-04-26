<?php

/**
 * @OA\Post(
 *     path="/auth/logout",
 *     summary="Log out",
 *     description="Invalidate the token",
 *     tags={"Authentication"},
 *     @OA\Response(
 *         response=200,
 *         description="Ok",
 *         @OA\JsonContent(
 *             ref="#/components/schemas/Response",
 *             example={"message"="Successfully logged out."}
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
 *     security={
 *         {"bearerAuth": {}}
 *     }
 * )
 */
