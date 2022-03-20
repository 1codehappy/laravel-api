<?php

namespace App\Backend\Api\Acl\Transformers;

use App\Domain\Acl\Models\Role;
use App\Support\Core\Concerns\Transformers\AddsTransformerCapabilities;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\NullResource;
use League\Fractal\TransformerAbstract;

class RoleTransformer extends TransformerAbstract
{
    use AddsTransformerCapabilities;

    /**
     * Add default includes.
     *
     * @return void
     */
    public function __construct()
    {
        $this->setDefaultIncludes(['permissions']);
    }

    /**
     * A Fractal transformer.
     *
     * @param Role $role
     * @return array
     */
    public function transform(Role $role): array
    {
        return $this->transformed([
            'id' => $role->uuid,
            'name' => $role->name,
            'created_at' => $role->present()->createdAt,
            'updated_at' => $role->present()->updatedAt,
        ]);
    }

    /**
     * Include permissions.
     *
     * @param Role $role
     * @return Collection|NullResource
     */
    public function includePermissions(Role $role): Collection|NullResource
    {
        if ($role->permissions === null) {
            return $this->null();
        }

        return $this->collection(
            $role->permissions,
            (new PermissionTransformer())->withoutTimestamps()
        );
    }
}
