<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchants extends Model
{
    use HasFactory;

    protected $primaryKey = 'merchant_id';

    public function RMerchantPayments() {
        return $this->hasMany(Payments::class, 'merchant_id', 'merchant_id');
    }

    public function RMerchantWarnings() {
        return $this->hasMany(Warnings::class, 'merchant_id', 'merchant_id');
    }

    public function RMerchantRecords() {
        return $this->hasMany(Records::class, 'merchant_id', 'merchant_id')->where('record_status', 1);
    }
}
