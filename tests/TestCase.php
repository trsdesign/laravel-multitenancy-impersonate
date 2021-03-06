<?php

namespace VictorYoalli\MultitenancyImpersonate\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use VictorYoalli\MultitenancyImpersonate\MultitenancyImpersonateServiceProvider;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        $this->withFactories(__DIR__.'/database/factories');
    }

    protected function getPackageProviders($app)
    {
        return [
            MultitenancyImpersonateServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        include_once __DIR__.'/../database/migrations/create_multitenancy_impersonate_tables.php.stub';
        (new \CreateMultitenancyImpersonateTables())->up();
    }
}
