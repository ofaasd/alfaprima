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
        'vehicle_class',
    ];

    protected $appends = [
        'vehicleClass',
        'partnerId',
        'partnerRate',
    ];

    protected function casts(): array
    {
        return [
            'partner_rate' => 'float',
        ];
    }

    public function getVehicleClassAttribute()
    {
        return $this->attributes['vehicle_class'] ?? 'City Car';
    }

    public function getPartnerIdAttribute()
    {
        return $this->attributes['partner_id'] ?? null;
    }

    public function getPartnerRateAttribute()
    {
        return $this->attributes['partner_rate'] ?? 0;
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
