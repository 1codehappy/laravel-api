<?php

namespace App\Domain\Permission\Actions;

use App\Domain\Permission\Models\Role;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;

class PaginateRole
{
    /**
     * List Roles
     *
     * @param integer $perPage
     * @param array $query
     * @return LengthAwarePaginator
     */
    public function execute(int $perPage, array $query): LengthAwarePaginator
    {
        return QueryBuilder::for(Role::class)
            ->allowedFilters([
                'name',
            ])
            ->defaultSort('name')
            ->allowedSorts([
                'name',
            ])
            ->paginate($perPage)
            ->appends($query)
        ;
    }
}
