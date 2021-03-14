<?php

namespace App\Domain\Permission\Providers;

use Illuminate\Support\AggregateServiceProvider;

class ServiceProvider extends AggregateServiceProvider
{
    /**
     * {@inheritDoc}
     */
    protected $providers = [
        DomainServiceProvider::class,
    ];
}
