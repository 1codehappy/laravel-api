<?php

namespace App\Support\Concerns\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

trait HasUuid
{
    /**
     * @param Builder $query
     * @param string|array $uuid
     * @return Builder
     */
    public function scopeByUuid(Builder $query, $uuid): Builder
    {
        $uuidField = $query->getModel()->getTable() . '.uuid';
        if (is_array($uuid)) {
            return $query->whereIn($uuidField, $uuid);
        }

        return $query->where($uuidField, $uuid);
    }

    /**
     * Boot the uuid scope trait for a model.
     *
     * @return void
     */
    protected static function bootHasUuid(): void
    {
        static::creating(function ($model) {
            if ($model->uuid === null) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}
