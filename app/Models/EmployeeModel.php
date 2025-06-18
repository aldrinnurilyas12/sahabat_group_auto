<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeModel extends Model
{
    use HasFactory;
    protected $table = 'employee';
    protected $fillable = [
        'id',
        'nik',
        'name',
        'address',
        'phone_number',
        'email',
        'job_position',
        'branch_id',
        'is_active',
        'birth_date',
        'start_date',
        'qr_code_path',
        'tunjangan_transport',
        'tunjangan_kesehatan',
        'tunjangan_lainnya',
        'updated_by',
        'created_by'
    ];
}
