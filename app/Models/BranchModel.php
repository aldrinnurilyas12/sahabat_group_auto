<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchModel extends Model
{
    use HasFactory;

    protected $table = 'branch';

    protected $fillable = [
        'location_code',
        'location_name',
        'address',
        'branch_head_name',
        'created_by',
        'updated_by'
    ];
}
