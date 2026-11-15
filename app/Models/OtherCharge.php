<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherCharge extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'customer_id',
        'booking_id',
        'date',
        'amount',
        'description',
    ];

    protected $appends = [
        'customerId',
        'bookingId',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'float',
        ];
    }

    public function getCustomerIdAttribute()
    {
        return $this->attributes['customer_id'] ?? null;
    }

    public function getBookingIdAttribute()
    {
        return $this->attributes['booking_id'] ?? null;
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
}

