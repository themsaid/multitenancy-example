<?php

namespace Tests\Feature;

use App\User;
use App\Tenant;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.connections.landlord' => [
                'driver' => 'sqlite',
                'database' => ':memory:'
            ],

            'database.connections.tenant' => [
                'driver' => 'sqlite',
                'database' => ':memory:'
            ]
        ]);

        $this->artisan('migrate --database=landlord --path=database/migrations/landlord');
        $this->artisan('migrate --database=tenant');
    }

    /**
     * @test
     */
    public function itReturnsCurrentTenantAndListOfItsUsers()
    {
        $tenant = factory(Tenant::class)->create();

        $tenant->use();

        factory(User::class, 4)->create();

        $response = $this->getJson('/users');

        $response->assertJsonCount(4, 'users');

        $response->assertJsonFragment([
            'name' => $tenant->name,
            'domain' => $tenant->domain,
        ]);
    }
}
