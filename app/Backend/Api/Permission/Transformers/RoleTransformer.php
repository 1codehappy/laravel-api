<?php

namespace App\Backend\Api\Permission\Transformers;

use App\Domain\Permission\Models\Role;
use App\Support\Concerms\Transformers\AddsTransformerCapabilities;
use League\Fractal\TransformerAbstract;

class RoleTransformer extends TransformerAbstract
{
    use AddsTransformerCapabilities;

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
}
