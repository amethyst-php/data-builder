<?php

namespace Amethyst\Tests;

abstract class BaseTest extends \Orchestra\Testbench\TestCase
{
    /**
     * Setup the test environment.
     */
    public function setUp(): void
    {
        $dotenv = \Dotenv\Dotenv::create(__DIR__.'/..', '.env');
        $dotenv->load();

        parent::setUp();

        $this->artisan('migrate:fresh');
    }

    protected function getPackageProviders($app)
    {
        return [
            \Amethyst\Providers\DataBuilderServiceProvider::class,
            \Amethyst\Providers\FooServiceProvider::class,
        ];
    }
}
