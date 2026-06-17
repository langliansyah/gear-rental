<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $primaryKey = 'equipment_id';
    protected $table = 'equipments';
    
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price_per_day',
        'status',
        'stock',
        'image_url',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function rentalItems()
    {
        return $this->hasMany(RentalItem::class, 'equipment_id', 'equipment_id');
    }
}