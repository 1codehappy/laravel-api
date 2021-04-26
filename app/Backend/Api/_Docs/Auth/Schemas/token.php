<?php

/**
 * @OA\Schema(
 *     schema="Token",
 *     type="object",
 *     description="The response when the token was generated.",
 *     @OA\Property(
 *         property="message",
 *         description="The message from response.",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="data",
 *         type="object",
 *         @OA\Property(
 *             property="access_token",
 *             description="The JWT token to authorization.",
 *             type="string"
 *         ),
 *         @OA\Property(
 *             property="bearer_type",
 *             description="The type of header authorization.",
 *             type="string"
 *         ),
 *         @OA\Property(
 *             property="expires_in",
 *             description="The time of token expiration in seconds.",
 *             type="integer",
 *             format="int32"
 *         ),
 *     ),
 *     example={
 *         "message"="Token generated.",
 *         "data"={
 *             "access_token"="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGkudGVuYW50MS5oaXJlZDM2NS5kb2NrZXIuaW50ZXJuYWxcL2xvZ2luIiwiaWF0IjoxNjAzNDc2NTE5LCJleHAiOjE2MDM0ODAxMTksIm5iZiI6MTYwMzQ3NjUxOSwianRpIjoiTlNkUXI0M2gzQTFLMWJRSiIsInN1YiI6MSwicHJ2IjoiMWM5OGY5ZmNlMjZkM2JhNDg0NGNkYmQ5M2MzNjcwZTViNGJkYzlmOSJ9.fPbaYuFhOMdrJdMGyGO01_02BzeAUXMO0gHFyDqPcY4",
 *             "token_type"="Bearer",
 *             "expires_in"=3600
 *         }
 *     }
 * )
 */
