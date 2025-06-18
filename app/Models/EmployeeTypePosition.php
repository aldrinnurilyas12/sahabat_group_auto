<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeTypePosition extends Model
{
    use HasFactory;
    protected $table = 'employee_type_position';

    protected $fillable = [
        'employee_id',
        'type_of_employee',
        'start_date',
        'end_date'
    ];
}
