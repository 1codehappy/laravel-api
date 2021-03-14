<?php

namespace App\Backend\Api\Permission\Controllers;

use App\Backend\Api\Permission\Request\RoleStore;
use App\Backend\Api\Permission\Request\RoleUpdate;
use App\Backend\Api\Permission\Transformers\RoleTransformer;
use App\Domain\Permission\Actions\CreateRole;
use App\Domain\Permission\Actions\DeleteRole;
use App\Domain\Permission\Actions\EditRole;
use App\Domain\Permission\Actions\PaginateRole;
use App\Domain\Permission\Models\Role;
use App\Support\Core\Api\Controllers\Controller;
use App\Support\Permission\Data\RoleData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    /**
     * List roles
     *
     * @param Request $request
     * @param PaginateRole $action
     * @return JsonResponse
     */
    public function index(Request $request, PaginateRole $action): JsonResponse
    {
        $roles = $action->execute(50, $request->query());

        return fractal($roles, new RoleTransformer())
            ->respond()
        ;
    }

    /**
     * Show role's info
     *
     * @param Role $role
     * @return JsonResponse
     */
    public function show(Role $role): JsonResponse
    {
        return fractal($role, new RoleTransformer())
            ->respond()
        ;
    }

    /**
     * Create new role
     *
     * @param RoleStore $request
     * @param CreateRole $action
     * @return JsonResponse
     */
    public function store(RoleStore $request, CreateRole $action): JsonResponse
    {
        $data = RoleData::fromRequest($request);
        $role = DB::transaction(function () use ($action, $data) {
            return $action->execute($data);
        });

        return fractal($role, new RoleTransformer())
            ->respond(201)
        ;
    }

    /**
     * Update role's data
     *
     * @param RoleUpdate $request
     * @param Role $role
     * @param EditRole $action
     * @return JsonResponse
     */
    public function update(RoleUpdate $request, Role $role, EditRole $action): JsonResponse
    {
        $data = RoleData::fromRequest($request);
        $role = DB::transaction(function () use ($action, $data, $role) {
            return $action->execute($data, $role);
        });

        return fractal($role, new RoleTransformer())
            ->respond()
        ;
    }

    /**
     * Delete role
     *
     * @param role $role
     * @param DeleteRole $action
     * @return JsonResponse
     */
    public function destroy(role $role, DeleteRole $action): JsonResponse
    {
        DB::transaction(function () use ($action, $role) {
            return $action->execute($role);
        });

        return response()->json([], 204);
    }
}
