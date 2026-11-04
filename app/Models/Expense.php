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
        'amount',
        'car_id',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'float',
        ];
    }

    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }
}

