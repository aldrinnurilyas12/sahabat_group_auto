<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmenuModel extends Model
{
    use HasFactory;
    protected $table = 'submenu';

    protected $fillable = [
        'submenu_name',
        'submenu_icons',
        'submenu_link',
        'parent_id',
        'superadmin_role',
        'admin_role',
        'branch_head_role',
        'is_active',
        'updated_by',
        'created_by'

    ];
}
