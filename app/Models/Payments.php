<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;

    protected $primaryKey = 'payment_id';

    public function RPaymentsMerchant() {
        return $this->belongsTo(Merchants::class,'merchant_id', 'merchant_id');
    }

    public function RPaymentsLocals() {
        return $this->belongsTo(Locals::class, 'local_id', 'local_id');
    }
}
