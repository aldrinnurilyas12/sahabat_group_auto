<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EticketModel extends Model
{
    use HasFactory;
    protected $table = 'eticket';

    protected $fillable = [
        'eticket_code',
        'employee_id',
        'eticket_category',
        'title',
        'status',
        'main_issue',
        'attachment_files',
        'approval_by_it',
        'scheduled',
        'task_complete_date',
        'created_by',
        'updated_by'
    ];
}
