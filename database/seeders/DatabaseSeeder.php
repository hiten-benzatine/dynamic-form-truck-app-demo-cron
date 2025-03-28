<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
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
        // \App\Models\User::factory(10)->create();

        User::create([
            'name' => 'Admin',
            'email' => 'admin@benzatine.com',
            'password' => bcrypt('password'),
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin1@benzatine.com',
            'password' => bcrypt('password'),
        ]);
    }
}
