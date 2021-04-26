<?php

/**
 * @OA\Schema(
 *     schema="UserUpdate",
 *     type="object",
 *     description="Request data for updating user",
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
 *         "roles": {
 *             "4bc42490-311f-4945-8896-3341f2ecc31c",
 *             "805d864f-4233-429b-af61-eb3373ac27b6"
 *         },
 *         "permissions": {"d93d699c-9791-4383-92e8-01e6dd8051fd"}
 *     }
 * )
 */
