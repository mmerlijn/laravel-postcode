<?php

namespace mmerlijn\laravelPostcode\tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use mmerlijn\laravelHelpers\LaravelHelpersServiceProvider;
use mmerlijn\laravelPostcode\Database\Seeders\DatabaseSeeder;
use mmerlijn\laravelPostcode\LaravelPostcodeServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use RefreshDatabase;

    //protected $loadEnvironmentVariables = true;


    public function setUp(): void
    {
        // Code before application created.
        if (file_exists(__DIR__ . '/.env.testing')) {
            (\Dotenv\Dotenv::createImmutable(__DIR__, '.env.testing'))->load();
        }
        parent::setUp();
        $this->loadMigrationsFrom(__DIR__ . '/../vendor/orchestra/testbench-core/laravel/migrations');
        $this->artisan('cache:clear')->run();
        $this->artisan('config:clear')->run();

        $this->artisan('db:seed', [
            '--database' => config('postcode.database_connection_name'),
            '--class' => DatabaseSeeder::class
        ])->run();
        //$this->artisan('view:clear')->run();
        // Code after application created.


    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelHelpersServiceProvider::class,
            LaravelPostcodeServiceProvider::class,
        ];

    }

    protected function getEnvironmentSetUp($app)
    {

    }

    protected function getApplicationTimezone($app)
    {
        return "Europe/Amsterdam";
    }


    protected function defineEnvironment($app)
    {

        //$app->loadEnvironmentFrom('../../../../tests/.env.testing'); // specify the file to use for environment, must be run before boostrap
        $app['config']->set('database.default', 'testbench');

        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        $app['config']->set('database.connections.' . config('postcode.database_connection_name'), [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    protected function defineDatabaseMigrations()
    {
    }
}