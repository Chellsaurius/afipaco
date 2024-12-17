<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Places extends Model
{
    use HasFactory;

    protected $primaryKey = 'place_id';

    public function RPlaceLocals() {
        return $this->belongsTo(Locals::class, 'local_id', 'local_id');
    }
}
