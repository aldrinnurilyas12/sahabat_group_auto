<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleFotos extends Model
{
    use HasFactory;
    protected $table = 'vehicle_fotos';

    protected $fillable  = [
        'vehicle_id',
        'images',
        'updated_by',
        'created_by'
    ];
}
