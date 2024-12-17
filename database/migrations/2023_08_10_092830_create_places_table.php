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
        Schema::create('places', function (Blueprint $table) {
            $table->id('place_id');
            $table->float('place_dimx', 8, 2);
            $table->float('place_dimy', 8, 2);
            $table->unsignedBigInteger('local_id')->nullable();
            $table->foreign('local_id')->references('local_id')->on('locals');
            $table->integer('place_status')->default('1')->comment('1 = activo, 2 = inactivo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('places');
    }
};
