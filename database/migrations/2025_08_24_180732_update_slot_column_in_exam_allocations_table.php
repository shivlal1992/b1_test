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
        Schema::table('exam_allocations', function (Blueprint $table) {
            $table->enum('slot', ['morning', 'afternoon'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exam_allocations', function (Blueprint $table) {
            $table->enum('slot', ['morning', 'evening'])->change();
        });
    }
};
