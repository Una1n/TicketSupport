<?php

use Database\Seeders\CategorySeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        activity()->withoutLogs(function () {
            $seeder = new CategorySeeder();
            $seeder->run();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
