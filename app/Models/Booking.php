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
        'units_json',
        'created',
    ];

    protected $appends = [
        'customerId',
        'carId',
        'partnerRate',
        'driverId',
        'driverName',
        'driverFee',
        'driverFeePerDay',
        'tollCost',
        'fuelCost',
        'mealCost',
        'lodgingCost',
        'unitsJson',
        'units',
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

    public function getCustomerIdAttribute()
    {
        return $this->attributes['customer_id'] ?? null;
    }

    public function getCarIdAttribute()
    {
        return $this->attributes['car_id'] ?? null;
    }

    public function getPartnerRateAttribute()
    {
        return $this->attributes['partner_rate'] ?? 0;
    }

    public function getDriverIdAttribute()
    {
        return $this->attributes['driver_id'] ?? null;
    }

    public function getDriverNameAttribute()
    {
        return $this->attributes['driver_name'] ?? null;
    }

    public function getDriverFeeAttribute()
    {
        return $this->attributes['driver_fee'] ?? 0;
    }

    public function getDriverFeePerDayAttribute()
    {
        return $this->attributes['driver_fee_per_day'] ?? 0;
    }

    public function getTollCostAttribute()
    {
        return $this->attributes['toll_cost'] ?? 0;
    }

    public function getFuelCostAttribute()
    {
        return $this->attributes['fuel_cost'] ?? 0;
    }

    public function getMealCostAttribute()
    {
        return $this->attributes['meal_cost'] ?? 0;
    }

    public function getLodgingCostAttribute()
    {
        return $this->attributes['lodging_cost'] ?? 0;
    }

    public function getUnitsJsonAttribute()
    {
        return $this->attributes['units_json'] ?? null;
    }

    public function getUnitsAttribute()
    {
        if (!empty($this->attributes['units_json'])) {
            $decoded = json_decode($this->attributes['units_json'], true);
            if (is_array($decoded)) {
                return $decoded;
            }
        }
        return [];
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

    public function driverPayments()
    {
        return $this->hasMany(DriverPayment::class, 'booking_id');
    }
}
