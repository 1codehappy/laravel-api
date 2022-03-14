<?php

namespace App\Domain\Acl\Actions;

use App\Domain\Acl\Models\Permission;
use App\Support\Core\Contracts\Actions\ReadCachedData;

class ReadCachedPermission extends ReadCachedData
{
    /**
     * {@inheritDoc}
     */
    public function name(): string
    {
        return 'permissions';
    }

    /**
     * {@inheritDoc}
     */
    public function model(): string
    {
        return Permission::class;
    }
}
