<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'date',
        'category',
        'note',
        'amount',
        'car_id',
        'created',
    ];

    protected $appends = [
        'carId',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'float',
        ];
    }

    public function getCarIdAttribute()
    {
        return $this->attributes['car_id'] ?? null;
    }

    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }
}
