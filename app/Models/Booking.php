<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'customer_id',
        'car_id',
        'start',
        'end',
        'days',
        'rate',
        'partner_rate',
        'driver_id',
        'driver_name',
        'driver_fee_per_day',
        'driver_fee',
        'destination',
        'toll_cost',
        'fuel_cost',
        'meal_cost',
        'lodging_cost',
        'total',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'days' => 'integer',
            'rate' => 'float',
            'partner_rate' => 'float',
            'driver_fee_per_day' => 'float',
            'driver_fee' => 'float',
            'toll_cost' => 'float',
            'fuel_cost' => 'float',
            'meal_cost' => 'float',
            'lodging_cost' => 'float',
            'total' => 'float',
        ];
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'booking_id');
    }

    public function partnerPayments()
    {
        return $this->hasMany(PartnerPayment::class, 'booking_id');
    }
}

