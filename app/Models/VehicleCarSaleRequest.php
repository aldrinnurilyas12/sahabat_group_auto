<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleCarSaleRequest extends Model
{
    use HasFactory;


    protected $table = 'vehicle_sale_request';

    protected $fillable = [
        'vehicle_type',
        'brand_id',
        'vehicle_year',
        'current_km',
        'vehicle_color',
        'name',
        'email',
        'phone_number',
        'status',
        'unique_tokens'
    ];
}
