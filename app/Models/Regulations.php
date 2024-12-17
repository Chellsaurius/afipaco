<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regulations extends Model
{
    use HasFactory;

    public function RAmountRegulation() {
        return $this->hasMany(Amounts::class, 'regulation_id', 'regulation_id');
    }

    public function RLocalsRegulations() {
        return $this->hasMany(Locals::class, 'regulation_id', 'regulation_id');
    }


}
