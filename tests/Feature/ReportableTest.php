<?php

namespace Jaktech\Anaphora\Tests;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Jaktech\Anaphora\Tests\Models\User;
use Orchestra\Testbench\TestCase;

class ReportableTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        // Migrate anaphoras package database tables
        $this->artisan('migrate', ['--database' => 'anaphora']);
    }

    /** @test */
    public function it_can_scope_yearly_report()
    {
        // Create a model using the Reportable trait
        $model = new User;

        // Create some sample data
        $this->createSampleData($model);

        // Use the scope
        $result = $model->yearlyReport(2022)->get();

        // Assert your expectations
        $this->assertCount(2, $result);
    }

    // Add more tests for other scopes...

    protected function getEnvironmentSetUp($app)
    {
        // Define your package's database migration
        include_once __DIR__ . '/../database/migrations/create_anaphora_tables.php.stub';

        // Run your package's database migrations
        (new \CreateAnaphoraTables())->up();
    }

    public function createApplication()
    {
        $app = parent::createApplication();

        // Use an in-memory database for testing
        $app['config']->set('database.default', 'anaphora');
        $app['config']->set('database.connections.anaphora', [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'anaphora'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),

        ]);

        return $app;
    }

    protected function createSampleData(Model $model)
    {
        $model->create(['created_at' => Carbon::now()]);
        $model->create(['created_at' => Carbon::now()->subYear()]);
        $model->create(['created_at' => Carbon::now()->subYear()]);
        $model->create(['created_at' => Carbon::now()->addYear()]);
    }
}
