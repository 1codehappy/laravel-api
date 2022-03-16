<?php

namespace App\Domain\Acl\Actions;

use App\Domain\Acl\Models\Role;
use App\Support\Core\Contracts\Actions\ReadCachedData;

class ReadCachedRole extends ReadCachedData
{
    /**
     * {@inheritDoc}
     */
    public function name(): string
    {
        return 'roles';
    }

    /**
     * {@inheritDoc}
     */
    public function model(): string
    {
        return Role::class;
    }
}
