<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverPayment extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'assignment_key',
        'booking_id',
        'unit_index',
        'driver_id',
        'driver_name',
        'date',
        'amount',
        'note',
    ];

    protected $appends = [
        'assignmentKey',
        'bookingId',
        'unitIndex',
        'driverId',
        'driverName',
    ];

    protected function casts(): array
    {
        return [
            'unit_index' => 'integer',
            'amount' => 'float',
        ];
    }

    public function getAssignmentKeyAttribute()
    {
        return $this->attributes['assignment_key'] ?? null;
    }

    public function getBookingIdAttribute()
    {
        return $this->attributes['booking_id'] ?? null;
    }

    public function getUnitIndexAttribute()
    {
        return $this->attributes['unit_index'] ?? 0;
    }

    public function getDriverIdAttribute()
    {
        return $this->attributes['driver_id'] ?? null;
    }

    public function getDriverNameAttribute()
    {
        return $this->attributes['driver_name'] ?? null;
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }
}

