<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAttedanceModel extends Model
{
    use HasFactory;

    protected $table = 'employee_attedance';

    protected $fillable = [
        'employee_id',
        'attedance_type',
        'reasons',
        'attedance_date',
        'fotos',
        'created_by',
        'updated_by'
    ];
}
