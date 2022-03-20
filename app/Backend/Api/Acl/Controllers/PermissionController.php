<?php

namespace App\Backend\Api\Acl\Controllers;

use App\Backend\Api\Acl\Transformers\PermissionTransformer;
use App\Domain\Acl\Actions\PaginatePermission;
use App\Domain\Acl\Models\Permission;
use App\Support\Acl\Contracts\Documentation\PermissionController as Documentation;
use App\Support\Core\Api\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PermissionController extends Controller implements Documentation
{
    /**
     * Apply policies.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Permission::class);
    }

    /**
     * List permissions.
     *
     * @param Request $request
     * @param PaginatePermission $action
     * @return JsonResponse
     */
    public function index(Request $request, PaginatePermission $action): JsonResponse
    {
        $this->authorize('viewAny', Permission::class);
        $permissions = $action->execute(
            $request->get('per_page') ?? 50,
            $request->query()
        );

        return fractal(
            $permissions,
            new PermissionTransformer()
        )->respond();
    }
}
