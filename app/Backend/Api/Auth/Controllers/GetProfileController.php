<?php

namespace App\Backend\Api\Auth\Controllers;

use App\Backend\Api\User\Transformers\UserTransformer;
use App\Domain\Acl\Actions\ReadCachedPermission;
use App\Domain\Acl\Actions\ReadCachedRole;
use App\Support\Auth\Contracts\Documentation\GetProfileController as Documentation;
use App\Support\Core\Api\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class GetProfileController extends Controller implements Documentation
{
    /**
     * Get the authenticated User.
     *
     * @param ReadCachedRole $metaRole
     * @param ReadCachedPermission $metaPermission
     * @return JsonResponse
     */
    public function __invoke(
        ReadCachedRole $metaRole,
        ReadCachedPermission $metaPermission
    ): JsonResponse {
        return fractal(Auth::user(), new UserTransformer())
            ->addMeta('roles', $metaRole->execute())
            ->addMeta('permissions', $metaPermission->execute())
            ->respond();
    }
}
