<?php

namespace App\Support\Contracts\Casts;

use App\Support\Exceptions\InvalidDataTransferObject as InvalidDataTransferObjectException;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\DataTransferObject\DataTransferObject;

abstract class Cast implements CastsAttributes
{
    /**
     * @param  Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return DataTransferObject|DataTrasnferObjectCollection|null
     */
    public function get($model, $key, $value, $attributes)
    {
        $dtoClass = $this->dtoClass();
        if (is_subclass_of($dtoClass, DataTransferObject::class)) {
            if (! $value) {
                return null;
            }

            return new $dtoClass(json_decode($value, true));
        }
        if ($dtoClass instanceof Collection) {
            if ($value->isEmpty()) {
                $value = '[]';
            }

            return $dtoClass::create(json_decode($value, true));
        }

        return null;
    }

    /**
     * @param  Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return string
     * @throws InvalidDtoInstanceException
     */
    public function set($model, $key, $value, $attributes): string
    {
        $dtoClass = $this->dtoClass();

        if (! $value instanceof $dtoClass) {
            throw new InvalidDataTransferObjectException($dtoClass);
        }
        /** @var DataTransferObject|Collection $value */
        return json_encode($value->toArray());
    }

    /**
     * Get DTO class
     *
     * @return string
     */
    abstract protected function dtoClass(): string;
}
