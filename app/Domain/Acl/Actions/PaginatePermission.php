<?php

namespace App\Domain\Acl\Actions;

use App\Domain\Acl\Models\Permission;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;

class PaginatePermission
{
    /**
     * Paginate permissions.
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
            ->defaultSort('updated_at')
            ->allowedSorts([
                'name',
                'created_at',
                'updated_at',
            ])
            ->paginate($perPage)
            ->appends($query);
    }
}
