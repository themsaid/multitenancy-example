<?php

namespace Tests\Feature;

use App\Tenant;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.connections.landlord' => config('database.connections.sqlite')
        ]);

        $this->artisan('migrate --database=landlord --path=database/migrations/landlord');
    }

    /**
     * @test
     */
    public function itReturnsListOfUsers()
    {
        $tenant = factory(Tenant::class)->create();

        $tenant->use();

        factory(User::class, 4)->create();

        $response = $this->getJson('/users');

        $response->assertJsonCount(4, 'users');

        $response->assertJsonFragment([
            'name' => $tenant->name
        ]);
    }
}
