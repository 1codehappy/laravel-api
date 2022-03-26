<?php

namespace App\Backend\Api\Auth\Controllers;

use App\Backend\Api\Auth\Concerns\UsesTokenResponse;
use App\Backend\Api\Auth\Requests\LoginRequest;
use App\Domain\Auth\Actions\Login;
use App\Support\Auth\Contracts\Documentation\LoginController as Documentation;
use App\Support\Auth\DTOs\LoginDto;
use App\Support\Core\Api\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller implements Documentation
{
    use UsesTokenResponse;

    /**
     * Get a JWT via given credentials.
     *
     * @param LoginRequest $request
     * @param Login $action
     * @return JsonResponse
     */
    public function __invoke(LoginRequest $request, Login $action): JsonResponse
    {
        $dto = LoginDto::fromRequest($request);
        if (! $token = $action->execute($dto)) {
            return response()
                ->json(['message' => __('auth.failed')], 401);
        }

        return $this->respondWithToken($token);
    }
}
