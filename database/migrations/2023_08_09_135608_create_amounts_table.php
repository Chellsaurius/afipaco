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
        Schema::create('amounts', function (Blueprint $table) {
            $table->id('amount_id');
            $table->float('amount_cost', 8, 2);
            $table->integer('amount_year');
            $table->unsignedBigInteger('regulation_id')->nullable();
            $table->foreign('regulation_id')->references('regulation_id')->on('regulations');
            $table->integer('amount_status')->default('1')->comment('1 = activo, 2 = inactivo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amounts');
    }
};
