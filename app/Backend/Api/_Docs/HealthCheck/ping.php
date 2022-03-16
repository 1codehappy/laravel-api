<?php

/**
 * @OA\Get(
 *     path="/ping",
 *     operationId="ping",
 *     tags={"Health Check"},
 *     summary="Status",
 *     description="Check if the services are running",
 *     @OA\Response(
 *         response=200,
 *         description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="pong",
 *                 type="boolean",
 *                 value=true
 *             )
 *         )
 *     )
 * )
 */
