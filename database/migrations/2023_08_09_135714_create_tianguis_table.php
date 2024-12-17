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
        Schema::create('tianguis', function (Blueprint $table) {
            $table->id('tiangui_id');
            $table->string('tiangui_name');
            $table->integer('tiangui_day');
            $table->string('tiangui_dayText');
            $table->time('tiangui_startingHour');
            $table->time('tiangui_endingHour');
            $table->integer('tiangui_status')->default('1')->comment('1 = activo, 2 = inactivo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tianguis');
    }
};
