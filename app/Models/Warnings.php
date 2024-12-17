<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warnings extends Model
{
    use HasFactory;

    protected $primaryKey = 'warning_id';
    
    public function RWarningsUser() {
        return $this->belongsTo(User::class,'id', 'id');
    }

    public function RWarningsMerchant() {
        return $this->belongsTo(Merchants::class, 'merchant_id', 'merchant_id');
    }

}
