<?php

namespace App\Backend\Api\Permission\Controllers;

use App\Backend\Api\Permission\Transformers\PermissionTransformer;
use App\Domain\Permission\Actions\PaginatePermission;
use App\Domain\Permission\Models\Permission;
use App\Support\Core\Api\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * List permissions
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
        )
            ->respond();
    }
}
