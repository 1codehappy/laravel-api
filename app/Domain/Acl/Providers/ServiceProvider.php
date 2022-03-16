<?php

namespace App\Domain\Acl\Providers;

use Illuminate\Support\AggregateServiceProvider;

class ServiceProvider extends AggregateServiceProvider
{
    /**
     * {@inheritDoc}
     */
    protected $providers = [
        AuthServiceProvider::class,
        DomainServiceProvider::class,
    ];
}
