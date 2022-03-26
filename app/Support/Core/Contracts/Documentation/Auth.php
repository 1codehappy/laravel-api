<?php

namespace App\Support\Core\Contracts\Documentation;

use OpenApi\Attributes as OA;

#[OA\SecurityScheme(
    securityScheme: "bearerAuth",
    in: "header",
    name: "bearerAuth",
    type: "http",
    scheme: "bearer",
    bearerFormat: "JWT"
)]
interface Auth
{
}
