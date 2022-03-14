<?php

namespace App\Support\Core\Concerns\Models;

use Illuminate\Database\Eloquent\Builder;

trait HasJoins
{
    /**
     * Is query joined?
     *
     * @param Builder $query
     * @param string $table
     * @return bool
     */
    public function isJoined(Builder $query, string $table): bool
    {
        return collect($query->getQuery()->joins ?? [])->pluck('table')->contains($table);
    }
}
