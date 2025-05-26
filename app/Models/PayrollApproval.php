<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollApproval extends Model
{
    use HasFactory;
    protected $table = 'payroll_approval';
    protected $fillable = [
        'payroll_id',
        'head_branch_id',
        'approval_by_head_of_finance',
        'approval_by_head_of_human_resource',
        'approval_by_head_of_branch'
    ];
}
