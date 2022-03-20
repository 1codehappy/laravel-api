<?php

namespace App\Support\Core\Api\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Attributes as OA;

#[OA\Info(
    title: "Laravel Apis",
    version: "1.0.0",
    description: "A simplest boilerplate for Laravel Apis",
    contact: new OA\Contact(name: "Gilberto Junior", email: "contact@codehappy.com"),
    license: new OA\License(name: "MIT")
)]
class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;
}
