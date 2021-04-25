<?php

namespace App\Backend\Api\Auth\Controllers;

use App\Backend\Api\Auth\Requests\PasswordUpdate;
use App\Backend\Api\Auth\Requests\ProfileUpdate;
use App\Backend\Api\User\Transformers\UserTransformer;
use App\Domain\User\Actions\ChangePassword;
use App\Domain\User\Actions\EditUser;
use App\Support\Core\Api\Controllers\Controller;
use App\Support\User\DTOs\UserDto;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        return fractal(
                Auth::user(),
                new UserTransformer()
            )
            ->respond()
        ;
    }

    /**
     * Update user's profile
     *
     * @param ProfileUpdate $request
     * @return JsonResponse
     */
    public function updateProfile(
        ProfileUpdate $request,
        EditUser $action
    ): JsonResponse {
        $user = Auth::user();
        $dto = UserDto::fromRequest($request);
        $user = DB::transaction(function () use ($action, $dto, $user) {
            return $action->execute($dto, $user);
        });

        return fractal($user, new UserTransformer())
            ->respond()
        ;
    }

    /**
     * Change password
     *
     * @return JsonResponse
     */
    public function changePassword(
        PasswordUpdate $request,
        ChangePassword $action
    ): JsonResponse {
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
