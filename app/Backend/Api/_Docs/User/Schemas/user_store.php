<?php

/**
 * @OA\Schema(
 *     schema="UserStore",
 *     type="object",
 *     description="Request data for creating new user",
 *     @OA\Property(
 *         property="name",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="password_confirmation",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="roles",
 *         type="array",
 *         @OA\Items(type="string")
 *     ),
 *     @OA\Property(
 *         property="permissions",
 *         type="array",
 *         @OA\Items(type="string")
 *     ),
 *     example={
 *         "name": "John Doe",
 *         "email": "admin@example.com",
 *         "password": "secret1234",
 *         "password_confirmation": "secret1234",
 *         "roles": {
 *             "4bc42490-311f-4945-8896-3341f2ecc31c",
 *             "805d864f-4233-429b-af61-eb3373ac27b6"
 *         },
 *         "permissions": {"d93d699c-9791-4383-92e8-01e6dd8051fd"}
 *     }
 * )
 */
