<?php

use Illuminate\Database\Seeder;

class LandlordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Tenant::create([
            'name' => 'Laravel',
            'domain' => 'laravel.wip',
            'database' => 'laravel',
        ]);

        \App\Tenant::create([
            'name' => 'Paravel',
            'domain' => 'paravel.wip',
            'database' => 'paravel',
        ]);
    }
}
