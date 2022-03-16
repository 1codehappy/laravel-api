<?php

namespace App\Domain\User\Actions;

use App\Domain\User\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PaginateUser
{
    /**
     * Paginate users.
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
            ->defaultSort('-updated_at')
            ->allowedSorts([
                'name',
                'email',
                'created_at',
                'updated_at',
            ])
            ->paginate($perPage)
            ->appends($query);
    }
}
