<?php

namespace App\Backend\Api\Permission\Transformers;

use App\Domain\Permission\Models\Permission;
use League\Fractal\TransformerAbstract;

class PermissionTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param Permission $permission
     * @return array
     */
    public function transform(Permission $permission): array
    {
        return [
            'id' => $permission->uuid,
            'name' => $permission->name,
            'created_at' => $permission->present()->createdAt,
            'updated_at' => $permission->present()->updatedAt,
        ];
    }
}
