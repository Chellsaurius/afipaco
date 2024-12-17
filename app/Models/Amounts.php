<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amounts extends Model
{
    use HasFactory;

    protected $primaryKey = 'amount_id';
    
    public function RAmountPayments() {
        return $this->hasMany(User::class,'id', 'id');
    }

    public function RAmountRegulation() {
        return $this->belongsTo(Regulations::class, 'regulation_id', 'regulation_id');
    }

}
