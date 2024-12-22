<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentModel extends Model
{
    use HasFactory;

    protected $table = 'department';
    protected $fillable = [
        'department_code',
        'department_name',
        'created_by',
        'updated_by'
    ];
}