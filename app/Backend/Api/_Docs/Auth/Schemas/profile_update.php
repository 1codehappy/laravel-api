<?php

/**
 * @OA\Schema(
 *     schema="ProfileUpdate",
 *     type="object",
 *     description="Request data for update user's profile",
 *     @OA\Property(
 *         property="name",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email"
 *     ),
 *     example={"name": "John Doe", "email": "admin@example.com"}
 * )
 */
