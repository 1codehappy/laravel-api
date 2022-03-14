<?php

namespace App\Backend\Api\HealthCheck\Controllers;

use App\Support\Core\Api\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class PingController extends Controller
{
    /**
     * Health check
     *
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        return response()->json([
                'pong' => true,
            ]);
    }
}
