<?php

namespace App\Backend\Api\User\Transformers;

use App\Backend\Api\Acl\Transformers\PermissionTransformer;
use App\Backend\Api\Acl\Transformers\RoleTransformer;
use App\Domain\User\Models\User;
use App\Support\Core\Concerns\Transformers\AddsTransformerCapabilities;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\NullResource;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    use AddsTransformerCapabilities;

    /**
     * Add default includes.
     *
     * @return void
     */
    public function __construct()
    {
        $this->setDefaultIncludes(['roles', 'permissions']);
    }

    /**
     * A Fractal transformer.
     *
     * @param User $user
     * @return array
     */
    public function transform(User $user): array
    {
        return $this->transformed([
            'id' => $user->uuid,
            'name' => $user->name,
            'email' => $user->email,
            'roles' => $user->roles->pluck('uuid'),
            'permissions' => $user->permissions->pluck('uuid'),
            'created_at' => $user->present()->createdAt,
            'updated_at' => $user->present()->updatedAt,
        ]);
    }

    /**
     * Include roles.
     *
     * @param User $user
     * @return Collection|NullResource
     */
    public function includeRoles(User $user): Collection|NullResource
    {
        if ($user->roles === null) {
            return $this->null();
        }

        return $this->collection(
            $user->roles,
            (new RoleTransformer())
                ->withoutTimestamps()
                ->withoutIncludes()
        );
    }

    /**
     * Include permissions.
     *
     * @param User $user
     * @return Collection|NullResource
     */
    public function includePermissions(User $user): Collection|NullResource
    {
        if ($user->permissions === null) {
            return $this->null();
        }

        return $this->collection(
            $user->permissions,
            (new PermissionTransformer())->withoutTimestamps()
        );
    }
}
