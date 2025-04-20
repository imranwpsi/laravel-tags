<?php

namespace Ihossain\LaravelTags\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Ihossain\LaravelTags\LaravelTagsServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            LaravelTagsServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        // Setup package config
        $app['config']->set('laravel-tags', [
            'models' => [
                'course' => \Ihossain\LaravelTags\Tests\Models\Course::class,
                'blog' => \Ihossain\LaravelTags\Tests\Models\Blog::class,
            ],
        ]);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__ . '/../src/Database/migrations');
        $this->loadMigrationsFrom(__DIR__ . '/Database/migrations');
    }
}