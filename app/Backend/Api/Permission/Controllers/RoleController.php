<?php

namespace App\Backend\Api\Permission\Controllers;

use App\Backend\Api\Permission\Requests\RoleRequest;
use App\Backend\Api\Permission\Transformers\RoleTransformer;
use App\Domain\Permission\Actions\CreateRole;
use App\Domain\Permission\Actions\DeleteRole;
use App\Domain\Permission\Actions\EditRole;
use App\Domain\Permission\Actions\PaginateRole;
use App\Domain\Permission\Models\Role;
use App\Support\Core\Api\Controllers\Controller;
use App\Support\Permission\DTOs\RoleDto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
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
        $this->authorize('viewAny', Role::class);
        $roles = $action->execute(
            $request->get('per_page') ?? 50,
            $request->query()
        );

        return fractal(
            $roles,
            new RoleTransformer()
        )
            ->respond();
    }

    /**
     * Show role's info
     *
     * @param Role $role
     * @return JsonResponse
     */
    public function show(Role $role): JsonResponse
    {
        $this->authorize('view', Role::class);

        return fractal(
            $role,
            new RoleTransformer()
        )
            ->respond();
    }

    /**
     * Create new role
     *
     * @param RoleRequest $request
     * @param CreateRole $action
     * @return JsonResponse
     */
    public function store(RoleRequest $request, CreateRole $action): JsonResponse
    {
        $dto = RoleDto::fromRequest($request);
        $role = DB::transaction(fn () => $action->execute($dto));

        return fractal(
            $role,
            new RoleTransformer()
        )
            ->respond(201);
    }

    /**
     * Update role's data
     *
     * @param RoleRequest $request
     * @param Role $role
     * @param EditRole $action
     * @return JsonResponse
     */
    public function update(RoleRequest $request, Role $role, EditRole $action): JsonResponse
    {
        $dto = RoleDto::fromRequest($request);
        $role = DB::transaction(fn () => $action->execute($dto, $role));

        return fractal(
            $role,
            new RoleTransformer()
        )
            ->respond();
    }

    /**
     * Delete role
     *
     * @param role $role
     * @param DeleteRole $action
     * @return JsonResponse
     */
    public function destroy(Role $role, DeleteRole $action): JsonResponse
    {
        $this->authorize('delete', Role::class);
        DB::transaction(fn () => $action->execute($role));

        return response()->json([], 204);
    }
}
