<?php

namespace App\Support\Core\Api\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use OpenApi\Attributes as OA;

#[OA\SecurityScheme(type: "http", securityScheme: "bearerAuth", scheme: "bearer", bearerFormat: "JWT")]
class Authenticate extends Middleware
{
}
