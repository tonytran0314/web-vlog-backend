<?php

namespace Database\Seeders;

use Database\Seeders\VlogSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CategoryVlogSeeder;
use Database\Seeders\UserSeeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            VlogSeeder::class,
            CategorySeeder::class,
            CategoryVlogSeeder::class,
        ]);
    }
}
