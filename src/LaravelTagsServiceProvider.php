<?php

namespace Ihossain\LaravelTags;

use Illuminate\Support\ServiceProvider;

class LaravelTagsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');

        $this->publishes([
            __DIR__.'/config/laravel-tags.php' => config_path('laravel-tags.php'),
        ], 'laravel-tags-config');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/Database/migrations' => database_path('migrations'),
            ], 'laravel-tags-migrations');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/laravel-tags.php',
            'laravel-tags'
        );

        $this->app->bind(
            \Ihossain\LaravelTags\Contracts\TagServiceContract::class,
            \Ihossain\LaravelTags\Services\TagService::class
        );
    }
}
