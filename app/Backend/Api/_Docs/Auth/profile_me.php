<?php

/**
 * @OA\Get(
 *     path="/auth/me",
 *     operationId="getUserProfile",
 *     tags={"Profile"},
 *     summary="Get user's profile information",
 *     description="Returns user's profile data",
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
 *             example={ "message"="Authentication failure."}
 *         )
 *     ),
 *     security={
 *         {"bearerAuth": {}}
 *     }
 * )
 */
