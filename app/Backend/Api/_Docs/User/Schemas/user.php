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
 *         "roles": {
 *             "4bc42490-311f-4945-8896-3341f2ecc31c",
 *             "805d864f-4233-429b-af61-eb3373ac27b6"
 *         },
 *         "permissions": {"d93d699c-9791-4383-92e8-01e6dd8051fd"},
 *         "created_at": "2020-10-22 16:31:03",
 *         "updated_at": "2020-10-22 16:31:03"
 *     }
 * )
 */
