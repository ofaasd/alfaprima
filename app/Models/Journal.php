<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'date',
        'note',
        'debit_account',
        'credit_account',
        'amount',
        'source',
        'reference',
    ];

    protected $appends = [
        'debitAccount',
        'creditAccount',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'float',
        ];
    }

    public function getDebitAccountAttribute()
    {
        return $this->attributes['debit_account'] ?? null;
    }

    public function getCreditAccountAttribute()
    {
        return $this->attributes['credit_account'] ?? null;
    }
}
