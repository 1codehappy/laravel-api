<?php

namespace App\Backend\Api\Auth\Concerns;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

trait UsesTokenResponse
{
    /**
     * Get the token array structure.
     *
     * @param  string $token
     * @return JsonResponse
     */
    public function respondWithToken(string $token): JsonResponse
    {
        return response()->json(
            [
                'message' => __('auth.success'),
                'data' => [
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'expires_in' => Auth::factory()->getTTL() * 60,
                ],
            ],
            201
        );
    }
}
