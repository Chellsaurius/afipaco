<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Markets extends Model
{
    use HasFactory;

    protected $primaryKey = 'market_id';

    public function RLocalsMarkets() {
        return $this->hasMany(Locals::class, 'local_id', 'local_id');
    }
}
