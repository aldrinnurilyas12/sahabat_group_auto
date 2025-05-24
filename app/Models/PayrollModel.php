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
        'payroll_code',
        'status',
        'payroll_file',
        'created_by',
        'updated_by'
    ];
}
