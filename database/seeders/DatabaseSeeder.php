<?php

namespace Database\Seeders;

use App\Models\Vlog;
use App\Models\Category;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Vlog::factory(20)->create();
        Category::factory(30)->create();
    }
}
