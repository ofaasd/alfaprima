<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerPayment extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'booking_id',
        'partner_id',
        'date',
        'amount',
        'status',
        'note',
    ];

    protected $appends = [
        'bookingId',
        'partnerId',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'float',
        ];
    }

    public function getBookingIdAttribute()
    {
        return $this->attributes['booking_id'] ?? null;
    }

    public function getPartnerIdAttribute()
    {
        return $this->attributes['partner_id'] ?? null;
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class, 'partner_id');
    }
}
