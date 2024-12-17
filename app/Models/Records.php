<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Records extends Model
{
    use HasFactory;

    protected $primaryKey = 'record_id';

    public function RRecordsMerchant() {
        return $this->belongsTo(Merchants::class, 'merchant_id', 'merchant_id');
    }

    public function RRecordsLocals() {
        return $this->belongsTo(Locals::class, 'local_id', 'local_id');
    }
}
