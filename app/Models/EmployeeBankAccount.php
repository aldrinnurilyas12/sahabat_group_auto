<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeBankAccount extends Model
{
    use HasFactory;

    protected $table = 'employee_bank_account';
    protected $fillable = [
        'nik',
        'bank_id',
        'bank_account',
        'created_by',
        'updated_by'
    ];
}
