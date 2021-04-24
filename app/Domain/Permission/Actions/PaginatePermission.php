<?php

namespace App\Domain\Permission\Actions;

use App\Domain\Permission\Models\Permission;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;

class PaginatePermission
{
    /**
     * List permissions
     *
     * @param int $perPage
     * @param array $query
     * @return LengthAwarePaginator
     */
    public function execute(int $perPage, array $query): LengthAwarePaginator
    {
        return QueryBuilder::for(Permission::class)
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
