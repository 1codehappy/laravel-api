<?php

/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
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
 *         "id": "17516740",
 *         "name": "Av Joao Procopio da Silva, 211",
 *         "email": "Casa 62, Jd. Esmeralda",
 *         "roles": "Marilia",
 *         "permissions": "SP",
 *         "created_at": "BR",
 *         "updated_at": "BR"
 *     }
 * )
 */
