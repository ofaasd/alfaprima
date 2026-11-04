<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'merk',
        'jenis',
        'plat',
        'trans',
        'status',
        'ownership',
        'partner_id',
        'partner_rate',
    ];

    protected function casts(): array
    {
        return [
            'partner_rate' => 'float',
        ];
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class, 'partner_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'car_id');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'car_id');
    }
}

