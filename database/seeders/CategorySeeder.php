<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::factory()->create(['name' => 'Visual']);
        Category::factory()->create(['name' => 'Payment']);
        Category::factory()->create(['name' => 'Profile']);
        Category::factory()->create(['name' => 'Shipping']);
    }
}
