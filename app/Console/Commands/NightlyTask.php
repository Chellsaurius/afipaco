<?php

namespace App\Console\Commands;

use App\Models\Payments;
use Illuminate\Console\Command;

class NightlyTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:nightly-task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // call main function
        $this->paymentsResets();
        $this->info('Tarea diaria completada exitosamente');

        return 0;
    }

    public function paymentsResets() {
        $payments = Payments::all()->where('payment_status', 2);
        foreach ($payments as $payment) {
            $payment->payment_status = 3;
            $payment->save();
        }
    }
}
