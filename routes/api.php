<?php

use App\Http\Controllers\PaymentsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(PaymentsController::class)->group(function() {
    Route::get('pendientesPorPagar', 'APIindex');
    Route::post('completePaymentO', 'APIcompletePayment')->middleware('auth:sanctum');
});

Route::middleware(['web', 'auth:sanctum'])->group(function () {
    Route::post('completePayment', [PaymentsController::class, 'APIcompletePayment']);
});
