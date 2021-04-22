<?php

namespace App\Support\Contracts\DTOs;

use Illuminate\Support\Collection as LaravelCollection;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\DataTransferObjectCollection;

abstract class Collection extends DataTransferObjectCollection
{
    /**
     * Add data transfer object
     *
     * @param DataTransferObject $data
     * @return void
     */
    public function add(DataTransferObject $data): void
    {
        if (! property_exists($this, 'key')) {
            return ;
        }
        $position = $this->search($this->key, $data);
        if ($position === false) {
            $position = null;
        }
        $this->offsetSet($position, $data);
    }

    /**
     * Remove data transfer object
     *
     * @param DataTransferObject $data
     * @return void
     */
    public function remove(DataTransferObject $data): void
    {
        if (! property_exists($this, 'key')) {
            return ;
        }
        $position = $this->search($this->key, $data);
        if ($position !== false) {
            $this->offsetUnset($position);
        }
    }

    /**
     * Get data transfer object by key-value
     *
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function findBy(string $key, $value)
    {
        $position = array_search($value, array_column($this->items(), $key));

        return $position !== false ? $this->offsetGet($position) : null;
    }

    /**
     * Get position in array
     *
     * @param string|array $key
     * @param mixed $value
     * @return int|bool
     */
    public function search($key, $data)
    {
        if (is_array($key)) {
            $query = [];
            foreach ($key as $attribute) {
                $query[$attribute] = $data->{$attribute};
            }
            $result = array_keys($this->items(), $query);

            return count($result) ? $result[0] : false;
        }

        return array_search($data->{$key}, array_column($this->items(), $key));
    }

    /**
     * Get Laravel collection
     *
     * @return LaravelCollection
     */
    public function collection(): LaravelCollection
    {
        return collect($this->collection);
    }
}
