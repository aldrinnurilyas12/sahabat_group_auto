<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleModel extends Model
{
    use HasFactory;
    protected $table = 'vehicle';


    protected $fillable = [
        'vehicle_registration_number',
        'vehicle_type',
        'price',
        'credit_price',
        'brand',
        'current_km',
        'manufacture_year',
        'vehicle_category',
        'model',
        'color',
        'fuel_type',
        'cylinder_capacity',
        'transmission',
        'vehicle_identity_number',
        'engine_number',
        'coding_number',
        'licence_plate_color',
        'old_vin',
        'registration_year',
        'tax_date',
        'bpkb_number',
        'location_code',
        'registration_queue_number',
        'name_of_owner',
        'address',
        'location_branch_vehicle',
        'status_vehicle_id',
        'payment_method',
        'updated_by',
        'created_by'
    ];

    public function images()
    {
        return $this->hasMany(VehicleFotos::class, 'vehicle_id');
    }
}
