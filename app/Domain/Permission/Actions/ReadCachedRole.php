<?php

namespace App\Domain\Permission\Actions;

use App\Domain\Permission\Models\Role;
use App\Support\Contracts\Actions\ReadCachedData;

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
