<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeavesAbsences extends Model
{
    use HasFactory;

    protected $table = 'leave_of_absences';
    protected $fillable = [
        'employee_id',
        'absences_code',
        'type_of_leave',
        'start_date',
        'end_date',
        'reason',
        'status',
        'attachment',
        'approval_by_branch_head',
        'approval_by_hr_head',
        'created_by'
    ];
}
