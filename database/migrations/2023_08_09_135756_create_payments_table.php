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
        Schema::create('payments', function (Blueprint $table) {
            $table->id('payment_id');
            $table->string('payment_folio')->nullable()->default('null');
            $table->date('payment_startingDate');
            $table->date('payment_endingDate');
            $table->float('payment_amount', 8, 2);
            $table->string('payment_daysText');
            $table->integer('payment_daysWorked');
            $table->unsignedBigInteger('merchant_id')->nullable();
            $table->foreign('merchant_id')->references('merchant_id')->on('merchants');
            $table->unsignedBigInteger('local_id')->nullable();
            $table->foreign('local_id')->references('local_id')->on('locals');
            $table->unsignedBigInteger('amount_id')->nullable();
            $table->foreign('amount_id')->references('amount_id')->on('amounts');
            $table->integer('payment_status')->default('2')->comment('1 = pagado, 2 = no pagado, 3 = cancelado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
