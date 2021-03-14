<?php

namespace App\Domain\User\Actions;

use App\Domain\User\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PaginateUser
{
    /**
     * Paginate user
     *
     * @param int $perPage
     * @param array $query
     * @return LengthAwarePaginator
     */
    public function execute(int $perPage, array $query): LengthAwarePaginator
    {
        return QueryBuilder::for(User::class)
            ->allowedFilters([
                'name',
                AllowedFilter::exact('email'),
            ])
            ->defaultSort('name')
            ->allowedSorts([
                'name',
                'created_at',
            ])
            ->paginate($perPage)
            ->appends($query)
        ;
    }
}
