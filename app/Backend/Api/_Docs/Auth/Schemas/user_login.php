<?php

/**
 * @OA\Schema(
 *     schema="UserLogin",
 *     type="object",
 *     description="Request data for login",
 *     required={"email", "password"},
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         format="password"
 *     ),
 *     example={
 *         "email": "john.doe@example.com",
 *         "password": "secret1234"
 *     }
 * )
 */
