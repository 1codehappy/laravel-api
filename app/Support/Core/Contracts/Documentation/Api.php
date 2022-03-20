<?php

namespace App\Support\Core\Contracts\Documentation;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: "Laravel Apis",
    version: "1.0.0",
    description: "A simplest boilerplate for Laravel Apis",
    contact: new OA\Contact(name: "Gilberto Junior", email: "contact@codehappy.com"),
    license: new OA\License(name: "MIT")
)]
interface Api
{
}
