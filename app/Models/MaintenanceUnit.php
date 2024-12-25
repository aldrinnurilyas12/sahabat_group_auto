<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceUnit extends Model
{
    use HasFactory;

    protected $table = 'maintenance_unit';
    protected $fillable = [
        'vehicle_id',
        'maintenance_type',
        'maintenance_detail',
        'cost',
        'maintenance_date',
        'mechanic_name',
        'foto',
        'created_by',
        'updated_by'
    ];
}
