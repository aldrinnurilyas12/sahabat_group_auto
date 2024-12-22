<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPositionModel extends Model
{
    use HasFactory;

    protected $table = 'job_position';

    protected $fillable = [
        'id',
        'position_name',
        'salary',
        'updated_by',
        'created_by'

    ];
}
