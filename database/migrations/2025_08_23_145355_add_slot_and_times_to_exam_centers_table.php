<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('exam_centers', function (Blueprint $table) {
        $table->string('slot')->nullable();          // Slot name/number
        $table->time('start_time')->nullable();      // Start time
        $table->time('end_time')->nullable();        // End time
    });
}

public function down()
{
    Schema::table('exam_centers', function (Blueprint $table) {
        $table->dropColumn(['slot', 'start_time', 'end_time']);
    });
}

};
