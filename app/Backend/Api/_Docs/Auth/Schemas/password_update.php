<?php

/**
 * @OA\Schema(
 *     schema="PasswordUpdate",
 *     type="object",
 *     description="Request data for changing password",
 *     required={"password", "password_confirmation"},
 *     @OA\Property(
 *         property="password",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="password_confirmation",
 *         type="string"
 *     ),
 *     example={
 *         "password": "abc9876543",
 *         "password_confirmation": "abc9876543"
 *     }
 * )
 */
