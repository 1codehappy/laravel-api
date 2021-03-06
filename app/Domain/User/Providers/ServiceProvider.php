<?php

namespace App\Domain\User\Providers;

use Illuminate\Support\AggregateServiceProvider;

class ServiceProvider extends AggregateServiceProvider
{
    /**
     * {@inheritDoc}
     */
    protected $providers = [
        AuthServiceProvider::class,
        DomainServiceProvider::class,
        EventServiceProvider::class,
    ];
}
