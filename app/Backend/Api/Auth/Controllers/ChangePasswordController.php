<?php

namespace App\Backend\Api\Auth\Controllers;

use App\Backend\Api\Auth\Requests\ChangePasswordRequest;
use App\Domain\User\Actions\ChangePassword;
use App\Support\Auth\Contracts\Documentation\ChangePasswordController as Documentation;
use App\Support\Core\Api\Controllers\Controller;
use App\Support\User\DTOs\UserDto;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChangePasswordController extends Controller implements Documentation
{
    /**
     * Change the password (only to logged users).
     *
     * @param ChangePasswordRequest $request
     * @param ChangePassword $action
     * @return JsonResponse
     */
    public function __invoke(
        ChangePasswordRequest $request,
        ChangePassword $action
    ): JsonResponse {
        /** @var \App\Domain\User\Models\User $user */
        $user = Auth::user();
        $dto = UserDto::fromRequest($request);
        $user = DB::transaction(fn () => $action->execute($dto, $user));

        return response()
            ->json([
                'message' => __('passwords.change'),
            ]);
    }
}
