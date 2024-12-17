<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tianguis extends Model
{
    use HasFactory;

    protected $primaryKey = 'tiangui_id';

    public function RTianguisLocals() {
        return $this->hasMany(Locals::class, 'tiangui_id', 'tiangui_id');
    }
}
