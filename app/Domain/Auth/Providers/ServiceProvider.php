<?php

namespace App\Domain\Auth\Providers;

use Illuminate\Support\AggregateServiceProvider;

class ServiceProvider extends AggregateServiceProvider
{
    /**
     * {@inheritDoc}
     */
    protected $providers = [
        EventServiceProvider::class,
    ];
}
