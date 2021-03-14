<?php

namespace App\Backend\Api\User\Transformers;

use App\Domain\User\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param User $user
     * @return array
     */
    public function transform(User $user): array
    {
        return [
            'id' => $user->uuid,
            'name' => $user->name,
            'email' => $user->email,
            'created_at' => $user->present()->createdAt,
            'updated_at' => $user->present()->updatedAt,
        ];
    }
}
