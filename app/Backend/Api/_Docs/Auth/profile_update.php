<?php

/**
 * @OA\Put(
 *     path="/auth/me",
 *     operationId="updateMyProfile",
 *     tags={"Profile"},
 *     summary="Update my profile",
 *     description="Change my profile's data",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(ref="#/components/schemas/ProfileUpdate")
 *         )
 *     ),
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
 *             example={"message"="Authentication failure."}
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
 *     ),
 *     security={
 *         {"bearerAuth": {}}
 *     }
 * )
 */
