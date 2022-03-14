<?php

/**
 * @OA\Schema(
 *     schema="Permission",
 *     type="object",
 *     description="permission data",
 *     @OA\Property(
 *         type="string",
 *         property="id",
 *         description="The ID of permission"
 *     ),
 *     @OA\Property(
 *         type="string",
 *         property="name",
 *         description="The name of permission"
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
 *         "id": "80ff5259-adfa-4ba7-8fa5-4bac6591b828",
 *         "name": "users.read",
 *         "created_at": "2020-10-22 16:31:03",
 *         "updated_at": "2020-10-22 16:31:03"
 *     }
 * )
 */
