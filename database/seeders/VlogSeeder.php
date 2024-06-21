<?php

namespace Database\Seeders;

use App\Models\Vlog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vlog::factory(20)->create();
    }
}
