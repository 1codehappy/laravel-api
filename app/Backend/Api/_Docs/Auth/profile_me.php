<?php

/**
 * @OA\Get(
 *     path="/auth/me",
 *     operationId="getUserProfile",
 *     tags={"Profile"},
 *     summary="Get user's profile information",
 *     description="Returns user's profile data",
 *     @OA\Response(
 *         response=200,
 *         description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="data",
 *                 ref="#/components/schemas/User"
 *             ),
 *             @OA\Property(
 *                 property="meta",
 *                 type="object",
 *                 @OA\Property(
 *                     property="roles",
 *                     type="array",
 *                     @OA\Items(ref="#/components/schemas/RoleShort"),
 *                     example={
 *                        {
 *                            "id": "4bc42490-311f-4945-8896-3341f2ecc31c",
 *                            "name": "Administrator"
 *                        },
 *                        {
 *                            "id": "805d864f-4233-429b-af61-eb3373ac27b6",
 *                            "name": "Developer"
 *                        }
 *                     }
 *                 ),
 *                 @OA\Property(
 *                     property="permissions",
 *                     type="array",
 *                     @OA\Items(ref="#/components/schemas/PermissionShort"),
 *                     example={
 *                         {
 *                             "id": "96bc4181-02b1-43e9-a304-6eb9373895b8",
 *                             "name": "permissions.read"
 *                         },
 *                         {
 *                             "id": "c411b9d7-4c16-4a2f-8055-89cd2d8f16a8",
 *                             "name": "roles.create"
 *                         },
 *                         {
 *                             "id": "e62cb99f-8644-4886-8e93-c80308fda49f",
 *                             "name": "roles.read"
 *                         },
 *                         {
 *                             "id": "3493826c-cb11-48c8-80bc-5fbab01b3654",
 *                             "name": "roles.update"
 *                         },
 *                         {
 *                             "id": "daa9c159-cabd-4ef1-b7cc-307620c3a3e4",
 *                             "name": "roles.delete"
 *                         },
 *                         {
 *                             "id": "3016ec07-9265-43c7-a49d-a44ac1e9b600",
 *                             "name": "users.create"
 *                         },
 *                         {
 *                             "id": "80ff5259-adfa-4ba7-8fa5-4bac6591b828",
 *                             "name": "users.read"
 *                         },
 *                         {
 *                             "id": "09bbb037-cb8e-4867-9c94-90d7577e4e71",
 *                             "name": "users.update"
 *                         },
 *                         {
 *                             "id": "6442f069-ddbf-4938-bd9a-33551bc3a5cf",
 *                             "name": "users.delete"
 *                         },
 *                         {
 *                             "id": "2c3b38bb-f19d-4e1f-abf8-03d0aa6b6fe2",
 *                             "name": "failed_jobs.read"
 *                         },
 *                         {
 *                             "id": "73e2e120-8f7c-4df0-b423-3e832af12760",
 *                             "name": "projects.create"
 *                         },
 *                         {
 *                             "id": "5f2dbb73-32cc-4d5f-8f3f-5c9524ac36d5",
 *                             "name": "projects.read"
 *                         },
 *                         {
 *                             "id": "a9b35d9a-cba4-41cd-8ba9-a7d9f431e368",
 *                             "name": "projects.update"
 *                         },
 *                         {
 *                             "id": "28d6ac5d-974c-436d-9882-c817aa67bb3b",
 *                             "name": "projects.delete",
 *                         },
 *                         {
 *                             "id": "d93d699c-9791-4383-92e8-01e6dd8051fd",
 *                             "name": "projects.a103e4a1-b3e1-4d1a-bf5b-05f32c7561bf"
 *                         }
 *                     }
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             ref="#/components/schemas/Response",
 *             example={ "message"="Authentication failure."}
 *         )
 *     ),
 *     security={
 *         {"bearerAuth": {}}
 *     }
 * )
 */
