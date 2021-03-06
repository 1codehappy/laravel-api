<?php

namespace App\Backend\Api\Acl\Transformers;

use App\Domain\Acl\Models\Permission;
use App\Support\Core\Concerns\Transformers\AddsTransformerCapabilities;
use League\Fractal\TransformerAbstract;

class PermissionTransformer extends TransformerAbstract
{
    use AddsTransformerCapabilities;

    /**
     * A Fractal transformer.
     *
     * @param Permission $permission
     * @return array
     */
    public function transform(Permission $permission): array
    {
        return $this->transformed([
            'id' => $permission->uuid,
            'name' => $permission->name,
            'created_at' => $permission->present()->createdAt,
            'updated_at' => $permission->present()->updatedAt,
        ]);
    }
}
