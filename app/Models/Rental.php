<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $primaryKey = 'rental_id';
    
    protected $fillable = [
        'user_id',
        'rental_date',
        'return_date_expected',
        'total_price',
        'status_payment',
        'metode_pengambilan',
        'alamat',
        'toko_tujuan',
    ];

    protected $casts = [
        'rental_date' => 'datetime',
        'return_date_expected' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function rentalItems()
    {
        return $this->hasMany(RentalItem::class, 'rental_id', 'rental_id');
    }
}