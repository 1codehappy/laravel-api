<?php

namespace App\Backend\Api\User\Transformers;

use App\Domain\User\Models\User;
use App\Support\Concerns\Transformers\AddsTransformerCapabilities;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    use AddsTransformerCapabilities;

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
}
