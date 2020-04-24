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
            'database.connections.landlord' => config('database.connections.sqlite')
        ]);

        config([
            'database.connections.tenant' => config('database.connections.sqlite')
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
