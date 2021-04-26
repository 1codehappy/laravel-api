<?php

/**
 * @OA\Schema(
 *     schema="Response",
 *     type="object",
 *     description="Api response",
 *     @OA\Property(
 *         property="message",
 *         description="The response message",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="errors",
 *         description="The structure of api response",
 *         type="array",
 *         @OA\Items(type="string")
 *     ),
 *     @OA\Property(
 *         property="data",
 *         description="The data of api response",
 *         type="array",
 *         @OA\Items(type="object")
 *     ),
 *     @OA\Property(
 *         property="meta",
 *         description="The data of api response",
 *         type="array",
 *         @OA\Items(type="object")
 *     ),
 *     example={
 *         "message"="Any message",
 *         "errors"={},
 *         "data"={},
 *         "meta"={}
 *     }
 * )
 */
