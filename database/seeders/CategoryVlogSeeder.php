<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Vlog;
use App\Models\Category;

class CategoryVlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch all video and category IDs
        $vlogIds = Vlog::pluck('id')->toArray();
        $categoryIds = Category::pluck('id')->toArray();

        $pivotData = [];

        // Ensure each video has exactly 3 unique categories
        foreach ($vlogIds as $vlogId) {
            // Shuffle categories for randomness
            shuffle($categoryIds);

            // Select the first 3 unique categories
            $assignedCategories = array_slice($categoryIds, 0, 3);

            foreach ($assignedCategories as $categoryId) {
                $pivotData[] = [
                    'vlog_id' => $vlogId,
                    'category_id' => $categoryId,
                ];
            }
        }

        // Insert data into pivot table, ensuring no duplicate records
        DB::table('category_vlog')->insertOrIgnore($pivotData);
    }
}
