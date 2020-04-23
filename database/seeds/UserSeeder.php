<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name' => 'Mohamed',
            'email' => 'hey@themsaid.com',
            'password' => \Illuminate\Support\Facades\Hash::make('secret'),
        ]);
    }
}
