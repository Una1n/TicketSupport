<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('category_ticket', function (Blueprint $table) {
            $table->foreignId('ticket_id')->constrained();
            $table->foreignId('category_id')->constrained();
            $table->primary(['category_id', 'ticket_id']);
        });
    }

    public function down(): void
    {
        Schema::table('category_ticket', function (Blueprint $table) {
            $table->dropForeign(['ticket_id']);
            $table->dropForeign(['category_id']);
        });

        Schema::dropIfExists('category_ticket');
    }
};
