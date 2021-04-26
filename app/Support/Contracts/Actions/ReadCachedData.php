<?php

namespace App\Support\Contracts\Actions;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

abstract class ReadCachedData
{
    /**
     * Get all status
     *
     * @param integer $seconds
     * @return array
     */
    public function execute(): array
    {
        return Cache::remember($this->name(), Carbon::now()->addHours(3), function () {
            $results = [];
            $class = $this->model();
            $rows = $class::all();
            if ($this->sorted() === true) {
                $rows = $rows->sortBy('name');
            }
            foreach ($rows as $model) {
                $results[$model->uuid] = $model->name;
            }
            return $results;
        });
    }

    /**
     * Sort by name?
     *
     * @return boolean
     */
    public function sorted(): bool
    {
        return false;
    }

    /**
     * Get cache name
     *
     * @return string
     */
    abstract public function name(): string;

    /**
     * Get model class
     *
     * @return string
     */
    abstract public function model(): string;
}
