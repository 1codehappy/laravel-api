<?php

namespace App\Backend\Api\Auth\Controllers;

use App\Backend\Api\Auth\Requests\ProfileUpdate;
use App\Backend\Api\User\Transformers\UserTransformer;
use App\Domain\Permission\Actions\ReadCachedPermission;
use App\Domain\Permission\Actions\ReadCachedRole;
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
     * @param ReadCachedRole $metaRole
     * @param ReadCachedPermission $metaPermission
     * @return JsonResponse
     */
    public function index(
        ReadCachedRole $metaRole,
        ReadCachedPermission $metaPermission
    ): JsonResponse {
        return fractal(
                Auth::user(),
                new UserTransformer()
            )
            ->addMeta('roles', $metaRole->execute())
            ->addMeta('permissions', $metaPermission->execute())
            ->respond()
        ;
    }

    /**
     * Update user's profile
     *
     * @param ProfileUpdate $request
     * @return JsonResponse
     */
    public function update(
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
}