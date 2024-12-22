<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSalaryModel extends Model
{
    use HasFactory;

    protected $table = 'job_position';

    protected $fillable = [
        'department_id',
        'position_name',
        'salary',
        'tunjangan_transport',
        'tunjangan_kesehatan',
        'tunjangan_lainnya',
        'updated_by',
        'created_by'
    ];
}