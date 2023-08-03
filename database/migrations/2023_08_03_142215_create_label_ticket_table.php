<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('label_ticket', function (Blueprint $table) {
            $table->foreignId('label_id')->constrained();
            $table->foreignId('ticket_id')->constrained();
            $table->primary(['label_id', 'ticket_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('label_ticket', function (Blueprint $table) {
            $table->dropForeign(['label_id']);
            $table->dropForeign(['ticket_id']);
        });

        Schema::dropIfExists('label_ticket');
    }
};
