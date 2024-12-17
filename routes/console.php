<?php

use App\Models\Payments;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::call(function () {
    $payments = Payments::all()->where('payment_status', 2);
    foreach ($payments as $payment) {
        $payment->payment_status = 3;
        $payment->save();
    }
})->timezone('America/Mexico_City')->dailyAt('16:00');

// Artisan::command('delete:recent-payments', function () {
//     DB::table('payments')->where('payment_status', 2)->delete();
// })->purpose('Delete recent unpayd payments')->timezone('America/Mexico_City')->dailyAt('09:46')->runInBackground();