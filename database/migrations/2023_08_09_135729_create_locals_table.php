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
        Schema::create('locals', function (Blueprint $table) {
            $table->id('local_id');
            $table->float('local_dimx', 8, 2);
            $table->float('local_dimy', 8, 2);
            $table->float('local_area', 8, 2);
            $table->text('local_location');
            $table->time('local_startingHour');
            $table->time('local_endingHour');
            $table->integer('local_places')->default('1');
            $table->unsignedBigInteger('tiangui_id')->nullable();
            $table->foreign('tiangui_id')->references('tiangui_id')->on('tianguis');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('category_id')->on('categories');
            $table->unsignedBigInteger('regulation_id')->nullable();
            $table->foreign('regulation_id')->references('regulation_id')->on('regulations');
            $table->integer('local_status')->default('1')->comment('1 = activo, 2 = inactivo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locals');
    }
};
