<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VehicleCustomerRequest extends Model
{
    use HasFactory;

    protected $table = 'customer_vehicle_request';
    protected $fillable = [
        'id',
        'vehicle_type',
        'brand',
        'year',
        'vehicle_color',
        'name',
        'email',
        'phone_number',
        'sending_mail',
        'unique_tokens',
        'description'

    ];
}
