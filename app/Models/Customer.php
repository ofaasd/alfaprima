<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'nama',
        'alamat',
        'wa',
        'nik',
        'sim',
        'status',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'customer_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'customer_id');
    }
}

