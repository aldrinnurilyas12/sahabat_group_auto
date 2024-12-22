<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSignature extends Model
{
    use HasFactory;

    protected $table = 'employee_signature';
    protected $fillable = [
        'employee_id',
        'signature',
        'created_by',
        'updated_by'
    ];
}
