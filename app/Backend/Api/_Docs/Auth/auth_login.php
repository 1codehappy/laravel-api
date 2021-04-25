<?php

/**
 * @OA\Post(
 *     path="/auth/login",
 *     operationId="login",
 *     summary="Sign in",
 *     description="Get a JWT via given credentials",
 *     tags={"Authentication"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 ref="#/components/schemas/UserLogin"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Ok",
 *         @OA\JsonContent(
 *             ref="#/components/schemas/Token"
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             ref="#/components/schemas/Response",
 *             example={"message"="Invalid credentials."}
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Unprocessable Entity",
 *         @OA\JsonContent(
 *             ref="#/components/schemas/Response",
 *             example={
 *                 "message"="The given data was invalid.",
 *                 "errors"={
 *                 "status_code"=422,
 *                     "field_name"={
 *                         "Error description 1",
 *                         "Error description 2",
 *                         "...",
 *                     }
 *                 },
 *             }
 *         )
 *     )
 * )
 */
