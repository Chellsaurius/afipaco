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
        Schema::create('records', function (Blueprint $table) {
            $table->id('record_id');
            $table->unsignedBigInteger('merchant_id')->nullable();
            $table->foreign('merchant_id')->references('merchant_id')->on('merchants');
            $table->unsignedBigInteger('local_id')->nullable();
            $table->foreign('local_id')->references('local_id')->on('locals');
            $table->integer('record_status')->default('1')->comment('1 = activo, 2 = inactivo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
