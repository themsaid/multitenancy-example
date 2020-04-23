<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if ($_SERVER['argv'][1] != 'tenants:migrate') {
            $this->call(LandlordSeeder::class);
        }

        $this->call(UserSeeder::class);
    }
}
