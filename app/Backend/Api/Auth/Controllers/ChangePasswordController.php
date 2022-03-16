<?php

namespace App\Backend\Api\Auth\Controllers;

use App\Backend\Api\Auth\Requests\PasswordUpdate;
use App\Domain\User\Actions\ChangePassword;
use App\Support\Core\Api\Controllers\Controller;
use App\Support\User\DTOs\UserDto;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChangePasswordController extends Controller
{
    /**
     * Change password
     *
     * @return JsonResponse
     */
    public function __invoke(
        PasswordUpdate $request,
        ChangePassword $action
    ): JsonResponse {
        /** @var \App\Domain\User\Models\User $user */
        $user = Auth::user();
        $dto = UserDto::fromRequest($request);
        $user = DB::transaction(function () use ($action, $dto, $user) {
            return $action->execute($dto, $user);
        });

        return response()->json([
                'message' => 'Password updated.',
            ])
        ;
    }
}
