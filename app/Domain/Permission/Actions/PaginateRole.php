<?php

namespace App\Domain\Permission\Actions;

use App\Domain\Permission\Models\Role;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;

class PaginateRole
{
    /**
     * Paginate roles.
     *
     * @param int $perPage
     * @param array $query
     * @return LengthAwarePaginator
     */
    public function execute(int $perPage, array $query): LengthAwarePaginator
    {
        return QueryBuilder::for(Role::class)
            ->allowedFilters([
                'name',
            ])
            ->defaultSort('-updated_at')
            ->allowedSorts([
                'name',
                'created_at',
                'updated_at',
            ])
            ->paginate($perPage)
            ->appends($query);
    }
}
