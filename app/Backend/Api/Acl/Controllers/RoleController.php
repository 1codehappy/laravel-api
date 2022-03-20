<?php

namespace App\Backend\Api\Acl\Controllers;

use App\Backend\Api\Acl\Requests\RoleRequest;
use App\Backend\Api\Acl\Transformers\RoleTransformer;
use App\Domain\Acl\Actions\CreateRole;
use App\Domain\Acl\Actions\DeleteRole;
use App\Domain\Acl\Actions\EditRole;
use App\Domain\Acl\Actions\PaginateRole;
use App\Domain\Acl\Models\Role;
use App\Support\Acl\Contracts\Documentation\RoleController as Documentation;
use App\Support\Acl\DTOs\RoleDto;
use App\Support\Core\Api\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller implements Documentation
{
    /**
     * Apply policies.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Role::class);
    }

    /**
     * List roles.
     *
     * @param Request $request
     * @param PaginateRole $action
     * @return JsonResponse
     */
    public function index(Request $request, PaginateRole $action): JsonResponse
    {
        $roles = $action->execute(
            $request->get('per_page') ?? 50,
            $request->query()
        );

        return fractal(
            $roles,
            new RoleTransformer()
        )->respond();
    }

    /**
     * Show the role info.
     *
     * @param Role $role
     * @return JsonResponse
     */
    public function show(Role $role): JsonResponse
    {
        return fractal(
            $role,
            new RoleTransformer()
        )->respond();
    }

    /**
     * Create a new role.
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
        ) ->respond(201);
    }

    /**
     * Update the role data.
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
        )->respond();
    }

    /**
     * Delete the role.
     *
     * @param role $role
     * @param DeleteRole $action
     * @return JsonResponse
     */
    public function destroy(Role $role, DeleteRole $action): JsonResponse
    {
        DB::transaction(fn () => $action->execute($role));

        return response()->json([], 204);
    }
}
