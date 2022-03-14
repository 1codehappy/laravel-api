<?php

namespace App\Support\Core\Contracts\Factories;

use Closure;
use Illuminate\Database\Eloquent\Factories\Factory as LaravelFactory;

abstract class Factory extends LaravelFactory
{
    /**
     * Create a new instance of the factory builder with the given mutated properties.
     *
     * @param  array  $arguments
     * @return static
     */
    protected function newInstance(array $arguments = [])
    {
        return $this;
    }

    /**
     * Specify how many models should be generated.
     *
     * @param  int|null  $count
     * @return static
     */
    public function count(?int $count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Add a new "after creating" callback to the model definition.
     *
     * @param  \Closure  $callback
     * @return static
     */
    public function afterCreating(Closure $callback)
    {
        $this->afterCreating->push($callback);

        return $this;
    }

    /**
     * Add a new "after making" callback to the model definition.
     *
     * @param  \Closure  $callback
     * @return static
     */
    public function afterMaking(Closure $callback)
    {
        $this->afterMaking->push($callback);

        return $this;
    }

    /**
     * Add a new state transformation to the model definition.
     *
     * @param  callable|array  $state
     * @return static
     */
    public function state($state)
    {
        $this->states->push(
            is_callable($state)
                ? $state
                : function () use ($state) {
                    return $state;
                }
        );

        return $this;
    }
}
