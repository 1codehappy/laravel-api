<?php

namespace App\Backend\Api\Auth\Controllers;

use App\Backend\Api\Auth\Concerns\UsesTokenResponse;
use App\Backend\Api\Auth\Requests\UserLogin;
use App\Support\Core\Api\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use UsesTokenResponse;

    /**
     * Get a JWT via given credentials.
     *
     * @param UserLogin $request
     * @return JsonResponse
     */
    public function __invoke(UserLogin $request): JsonResponse
    {
        $credentials = $request->validated();

        if (! $token = Auth::attempt($credentials)) {
            return response()
                ->json([
                    'message' => 'Invalid credentials.',
                ], 401);
        }

        return $this->respondWithToken($token);
    }
}
