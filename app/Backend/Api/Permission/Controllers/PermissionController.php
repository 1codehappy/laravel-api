<?php

namespace App\Backend\Api\Permission\Controllers;

use App\Backend\Api\Permission\Request\PermissionStore;
use App\Backend\Api\Permission\Request\PermissionUpdate;
use App\Backend\Api\Permission\Transformers\PermissionTransformer;
use App\Domain\Permission\Actions\CreatePermission;
use App\Domain\Permission\Actions\DeletePermission;
use App\Domain\Permission\Actions\EditPermission;
use App\Domain\Permission\Actions\PaginatePermission;
use App\Domain\Permission\Models\Permission;
use App\Support\Core\Api\Controllers\Controller;
use App\Support\Permission\Data\PermissionData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $permissions = $action->execute(50, $request->query());

        return fractal($permissions, new PermissionTransformer())
            ->respond()
        ;
    }

    /**
     * Show permission's info
     *
     * @param Permission $permission
     * @return JsonResponse
     */
    public function show(Permission $permission): JsonResponse
    {
        return fractal($permission, new PermissionTransformer())
            ->respond()
        ;
    }

    /**
     * Create new permission
     *
     * @param PermissionStore $request
     * @param CreatePermission $action
     * @return JsonResponse
     */
    public function store(PermissionStore $request, CreatePermission $action): JsonResponse
    {
        $data = PermissionData::fromRequest($request);
        $permission = DB::transaction(function () use ($action, $data) {
            return $action->execute($data);
        });

        return fractal($permission, new PermissionTransformer())
            ->respond(201)
        ;
    }

    /**
     * Update permission's data
     *
     * @param PermissionUpdate $request
     * @param Permission $permission
     * @param EditPermission $action
     * @return JsonResponse
     */
    public function update(PermissionUpdate $request, Permission $permission, EditPermission $action): JsonResponse
    {
        $data = PermissionData::fromRequest($request);
        $permission = DB::transaction(function () use ($action, $data, $permission) {
            return $action->execute($data, $permission);
        });

        return fractal($permission, new PermissionTransformer())
            ->respond()
        ;
    }

    /**
     * Delete permission
     *
     * @param Permission $permission
     * @param DeletePermission $action
     * @return JsonResponse
     */
    public function destroy(Permission $permission, DeletePermission $action): JsonResponse
    {
        DB::transaction(function () use ($action, $permission) {
            return $action->execute($permission);
        });

        return response()->json([], 204);
    }
}
