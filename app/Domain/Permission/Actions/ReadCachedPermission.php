<?php

namespace App\Domain\Permission\Actions;

use App\Domain\Permission\Models\Permission;
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
