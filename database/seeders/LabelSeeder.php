<?php

namespace Database\Seeders;

use App\Models\Label;
use Illuminate\Database\Seeder;

class LabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Label::factory()->create(['name' => 'Bug']);
        Label::factory()->create(['name' => 'Enhancement']);
        Label::factory()->create(['name' => 'Question']);
    }
}
