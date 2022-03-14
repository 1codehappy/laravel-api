<?php

/**
 * @OA\Schema(
 *     schema="RoleUpdate",
 *     type="object",
 *     description="Request data for updating role",
 *     @OA\Property(
 *         property="name",
 *         description="The name of role",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="permissions",
 *         type="array",
 *         description="The permissions can be the ID or the name",
 *         @OA\Items(type="string")
 *     ),
 *     example={
 *         "name": "Administrator",
 *         "permissions": {
 *             "96bc4181-02b1-43e9-a304-6eb9373895b8",
 *             "c411b9d7-4c16-4a2f-8055-89cd2d8f16a8",
 *             "e62cb99f-8644-4886-8e93-c80308fda49f",
 *             "3493826c-cb11-48c8-80bc-5fbab01b3654",
 *             "daa9c159-cabd-4ef1-b7cc-307620c3a3e4",
 *             "3016ec07-9265-43c7-a49d-a44ac1e9b600",
 *             "80ff5259-adfa-4ba7-8fa5-4bac6591b828",
 *             "09bbb037-cb8e-4867-9c94-90d7577e4e71",
 *             "6442f069-ddbf-4938-bd9a-33551bc3a5cf",
 *             "2c3b38bb-f19d-4e1f-abf8-03d0aa6b6fe2",
 *         }
 *     }
 * )
 */
