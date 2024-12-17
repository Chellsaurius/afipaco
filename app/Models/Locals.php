<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locals extends Model
{
    use HasFactory;

    protected $primaryKey = 'local_id';

    public function RLocalsTianguis() {
        return $this->belongsTo(Tianguis::class, 'tiangui_id', 'tiangui_id');
    }

    public function RLocalsMarkets() {
        return $this->belongsTo(Markets::class, 'market_id', 'market_id');
    }

    public function RLocalsCategories() {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function RLocalsRegulations() {
        return $this->belongsTo(Regulations::class, 'regulation_id', 'regulation_id');
    }

    public function RLocalPayments() {
        return $this->hasMany(Payments::class, 'local_id', 'local_id');
    }

    public function RLocalPlaces() {
        return $this->hasMany(Places::class, 'local_id', 'local_id')->where('place_status', 1);
    }
    
    public function RLocalRecords() {
        return $this->hasMany(Records::class, 'local_id', 'local_id');
    }
}
