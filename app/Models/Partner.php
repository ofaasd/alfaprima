<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'wa',
        'address',
        'bank',
        'account_no',
        'account_name',
    ];

    public function cars()
    {
        return $this->hasMany(Car::class, 'partner_id');
    }

    public function partnerPayments()
    {
        return $this->hasMany(PartnerPayment::class, 'partner_id');
    }
}

