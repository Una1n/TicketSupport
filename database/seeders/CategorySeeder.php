<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::factory()->create(['name' => 'Uncategorized']);
        Category::factory()->create(['name' => 'Windows']);
        Category::factory()->create(['name' => 'Profile']);
        Category::factory()->create(['name' => 'Network']);
    }
}
