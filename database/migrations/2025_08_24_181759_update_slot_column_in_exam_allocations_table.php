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
    DB::statement("ALTER TABLE exam_allocations MODIFY slot ENUM('morning','afternoon') NOT NULL");
}

public function down()
{
    DB::statement("ALTER TABLE exam_allocations MODIFY slot ENUM('morning') NOT NULL");
}


    /**
     * Reverse the migrations.
     */
   
    
};
