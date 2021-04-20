<?php

namespace App\Backend\Api\User\Transformers;

use App\Backend\Api\Permission\Transformers\PermissionTransformer;
use App\Backend\Api\Permission\Transformers\RoleTransformer;
use App\Domain\User\Models\User;
use App\Support\Concerms\Transformers\AddsTransformerCapabilities;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\NullResource;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    use AddsTransformerCapabilities;

    /**
     * Default includes
     *
     * @var array
     */
    protected $defaultIncludes = [
        'roles',
        'permissions',
    ];

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
            'created_at' => $user->present()->createdAt,
            'updated_at' => $user->present()->updatedAt,
        ]);
    }

    /**
     * Include roles
     *
     * @param User $user
     * @return Collection|NullResource
     */
    public function includeRoles(User $user)
    {
        $roles = $user->roles;
        if (is_null($roles)) {
            return $this->null();
        }
        return $this->collection(
            $roles,
            (new RoleTransformer())->withoutTimestamps()
        );
    }

    /**
     * Include permissions
     *
     * @param User $user
     * @return Collection|NullResource
     */
    public function includePermissions(User $user)
    {
        $permissions = $user->permissions;
        if (is_null($permissions)) {
            return $this->null();
        }
        return $this->collection(
            $permissions,
            (new PermissionTransformer())->withoutTimestamps()
        );
    }
}
