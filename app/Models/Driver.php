<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'wa',
        'address',
        'license',
        'status',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'driver_id');
    }
}

