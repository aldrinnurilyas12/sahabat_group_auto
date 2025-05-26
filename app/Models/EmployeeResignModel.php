<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeResignModel extends Model
{

    use HasFactory;

    protected $table = 'employee_resign';
    protected $fillable = [
        'employee_id',
        'branch_head_id',
        'resign_reasons',
        'resign_date',
        'last_day_of_work',
        'return_company_property',
        'approval_by_branch_head',
        'approval_by_hr_head',
        'resign_status',
        'feedback',
        'resign_attachment'
    ];
}
