<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpkUnitModel extends Model
{
    use HasFactory;


    protected $table = 'spk_unit';

    protected $fillable = [
        'vehicle_id',
        'location_unit',
        'payment_method',
        'price',
        'price_nominal',
        'down_payment',
        'customer',
        'address',
        'phone_number',
        'email',
        'approval_by_head_branch',
        'approval_by_sales_manager',
        'created_by',
        'updated_by'
    ];
}
