<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MasterVehicleAdvertisementModel extends Model
{
    use HasFactory;

    protected $casts = ['created_at' => 'date'];

    protected $table = 'vehicle_advertisement';
    protected $fillable = [
        'id',
        'vehicle_id',
        'foto',
        'is_active',
        'clicked',
        'created_by',
        'updated_by'
    ];
}
