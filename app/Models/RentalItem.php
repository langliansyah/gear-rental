<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalItem extends Model
{
    protected $primaryKey = 'rental_item_id';
    
    protected $fillable = [
        'rental_id',
        'equipment_id',
        'quantity',
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class, 'rental_id', 'rental_id');
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'equipment_id', 'equipment_id');
    }
}