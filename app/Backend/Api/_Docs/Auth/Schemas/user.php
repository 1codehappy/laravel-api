<?php

/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     description="User's data",
 *     @OA\Property(
 *         type="string",
 *         property="id",
 *         description="The ID of user"
 *     ),
 *     @OA\Property(
 *         type="string",
 *         property="name",
 *         description="The name of user"
 *     ),
 *     @OA\Property(
 *         type="string",
 *         property="email",
 *         description="The email of user",
 *         format="email"
 *     ),
 *     @OA\Property(
 *         type="array",
 *         property="roles",
 *         description="The roles of user",
 *         @OA\Items(
 *             type="string"
 *         )
 *     ),
 *     @OA\Property(
 *         type="array",
 *         property="permissions",
 *         description="The permissions of user",
 *         @OA\Items(
 *             type="string"
 *         )
 *     ),
 *     @OA\Property(
 *         type="string",
 *         property="created_at",
 *         description="The date of creation",
 *         format="datetime"
 *     ),
 *     @OA\Property(
 *         type="string",
 *         property="updated_at",
 *         description="The date of modification",
 *         format="datetime"
 *     ),
 *     example={
 *         "id": "d3ba0542-73b2-4b19-be42-e5fa528d1a94",
 *         "name": "John Doe",
 *         "email": "john.doe@example.com",
 *         "roles": {"bb69f847-0166-4a84-8691-cba9a31e367c", "aa36460d-5de4-4553-a107-f7c90c4792cd"},
 *         "permissions": {"60bcd6e9-8ced-4526-aff8-e31bd4b430f3", "f9d318e0-5c60-4364-9977-d4539936ce80"},
 *         "created_at": "2020-10-22 16:31:03",
 *         "updated_at": "2020-10-22 16:31:03"
 *     }
 * )
 */
