<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserControlModel extends Model
{
    use HasFactory;

    protected $table = 'user_control';

    protected $fillable = [
        'submenu_id',
        'user_role',
        'created_by',
        'updated_by'
    ];
}
