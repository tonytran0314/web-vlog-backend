<?php

namespace Database\Seeders;

use App\Models\Vlog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class VlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        $numberOfPosts = 200;

        for ($i = 0; $i < $numberOfPosts; $i++) {
            Vlog::factory()->create([
                'created_at' => $now->copy()->addSeconds($i),
                'updated_at' => $now->copy()->addSeconds($i),
            ]);
        }
    }
}
