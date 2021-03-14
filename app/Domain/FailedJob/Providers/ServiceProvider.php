<?php

namespace App\Domain\FailedJob\Providers;

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
