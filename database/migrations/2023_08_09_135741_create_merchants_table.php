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
        Schema::create('merchants', function (Blueprint $table) {
            $table->id('merchant_id');
            $table->string('merchant_names');
            $table->string('merchant_curp');
            $table->string('merchant_address');
            $table->string('merchant_phone1')->nullable();
            $table->string('merchant_phone2')->nullable();
            $table->string('merchant_activity');
            $table->string('merchant_days');
            $table->string('merchant_daysText');
            $table->text('merchant_observations')->nullable();
            $table->integer('merchant_warnings')->default('0');
            $table->unsignedBigInteger('id')->nullable();
            $table->foreign('id')->references('id')->on('users');
            $table->integer('merchant_status')->default('1')->comment('1 = activo, 2 = inactivo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchants');
    }
};
