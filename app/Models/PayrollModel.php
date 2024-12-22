<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollModel extends Model
{
    use HasFactory;

    protected $table = 'payroll';
    protected $fillable = [
        'employee_id',
        'job_id',
        'status',
        'created_by',
        'updated_by'
    ];
}
