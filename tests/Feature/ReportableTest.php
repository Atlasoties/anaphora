<?php

namespace Jaktech\Anaphora\Tests;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Jaktech\Anaphora\Exceptions\ArgumentExceptions;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Jaktech\Anaphora\Traits\Reportable;
use Orchestra\Testbench\TestCase;
use Jaktech\Anaphora\Tests\Database\Migrations\CreateUsersTable;

use Jaktech\Anaphora\Tests\Models\User;

class ReportableTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        // Set up the database for testing
        $this->setUpDatabase();
    }

    protected function setUpDatabase()
    {
        // Define a test model
        (new CreateUsersTable())->down();

        (new CreateUsersTable())->up();
    }

    public function testYearlyReport()
    {
        $model = User::create();

        $this->assertCount(1, User::yearlyReport()->get());
        $this->assertCount(0, User::yearlyReport(2022)->get());
        $this->assertCount(1, User::thisYearReport()->get());
        $this->assertCount(0, User::lastYearReport()->get());
    }

    public function testMonthlyReport()
    {
        $model = User::create();

        $this->assertCount(1, User::monthlyReport()->get());
        $this->assertCount(0, User::monthlyReport(null, 2022)->get());
        $this->assertCount(1, User::thisMonthReport()->get());
        $this->assertCount(0, User::lastMonthReport()->get());
    }

    // ... (similar tests for other scopes)

    public function testCustomColumnReport()
    {
        $model = User::create();

        $this->assertCount(1, User::yearlyReport(null, 'custom_date_column')->get());
        $this->assertCount(1, User::thisYearReport('custom_date_column')->get());
        $this->assertCount(0, User::lastYearReport('custom_date_column')->get());
    }

    public function testInvalidColumnException()
    {
        $this->expectException(\Exception::class);

        $model = User::create();

        // Invalid column 'invalid_column'
        User::yearlyReport(null, 'invalid_column')->get();
    }
}
