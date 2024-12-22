<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditSimulation extends Model
{
    use HasFactory;

    protected $table = 'credit_simulation';

    protected $fillable = [
        'vehicle_id',
        'down_payment',
        'insurance_id',
        'tenor_12_month',
        'tenor_24_month',
        'tenor_36_month',
        'tenor_48_month',
        'tenor_60_month',
        'tenor_72_month',
        'updated_by',
        'created_by'
    ];
}
