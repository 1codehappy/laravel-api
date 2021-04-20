<?php

namespace App\Backend\Api\Permission\Transformers;

use App\Domain\Permission\Models\Permission;
use App\Support\Concerms\Transformers\AddsTransformerCapabilities;
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
