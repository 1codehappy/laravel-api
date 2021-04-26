<?php

namespace App\Backend\Api\Auth\Controllers;

use App\Backend\Api\Auth\Concerns\UsesTokenResponse;
use App\Support\Core\Api\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class RefreshTokenController extends Controller
{
    use UsesTokenResponse;

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        return $this->respondWithToken(Auth::refresh());
    }
}
