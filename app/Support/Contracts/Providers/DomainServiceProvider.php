<?php

namespace App\Support\Contracts\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use ReflectionClass;

abstract class DomainServiceProvider extends ServiceProvider
{
    /**
     * {@inheritDoc}
     */
    public function boot()
    {
        $this->registerCommands();
        $this->registerConfigs();
        $this->registerMigrations();
        $this->registerRoutes();
        $this->registerTranslations();
    }

    /**
     * Register commands
     *
     * @return void
     */
    public function registerCommands(): void
    {
        if (! property_exists($this, 'commands')) {
            return;
        }
        $this->commands($this->commands);
    }

    /**
     * Register configs
     *
     * @return void
     */
    public function registerConfigs(): void
    {
        $configDir = $this->domainPath('Resources/Config');
        if (! File::isDirectory($configDir)) {
            return;
        }
        $domainName = Str::lower(Str::snake($this->domainName()));
        foreach (glob("$configDir/*.php") as $filename) {
            $this->mergeConfigFrom(
                $filename,
                $domainName
            );
        }
    }

    /**
     * Register migrations
     *
     * @return void
     */
    public function registerMigrations(): void
    {
        $migrationsDir = $this->domainPath('Database/Migrations');
        if (! File::isDirectory($migrationsDir)) {
            return;
        }
        $this->loadMigrationsFrom($migrationsDir);
    }

    /**
     * Register routes
     *
     * @return void
     */
    public function registerRoutes(): void
    {
        if (! property_exists($this, 'routes')) {
            return ;
        }
        foreach ($this->routes as $route) {
            $this->loadRoutesFrom(app_path($route));
        }
    }

    /**
     * Register translations
     *
     * @return void
     */
    public function registerTranslations(): void
    {
        $translationDir = $this->domainPath('Resources/Lang');
        if (! File::isDirectory($translationDir)) {
            return;
        }
        $domainName = Str::lower(Str::snake($this->domainName()));
        $this->loadTranslationsFrom($translationDir, $domainName);
    }

    /**
     * Get domain path
     *
     * @param string $path
     * @return string
     */
    protected function domainPath($path = null): string
    {
        $reflection = new ReflectionClass($this);
        $realPath = realpath(dirname($reflection->getFileName()) . '/../');

        if (! $path) {
            return $realPath;
        }

        return $realPath . Str::start($path, '/');
    }

    /**
     * Get domain name
     *
     * @return string
     */
    protected function domainName(): string
    {
        return Arr::last(explode('/', $this->domainPath()));
    }
}
