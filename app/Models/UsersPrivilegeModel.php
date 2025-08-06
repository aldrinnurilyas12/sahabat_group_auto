<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersPrivilegeModel extends Model

{

    use HasFactory;

    protected $table = 'users_privilege';
    protected $fillable =
    [
        'allowed',
        'disallowed',
        'created_by',
        'updated_by'
    ];
}
