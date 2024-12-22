<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainMenuModel extends Model
{
    use HasFactory;
    protected $table = 'main_menu';

    protected $fillable = [
        'menu_name',
        'menu_icon',
        'location',
        'is_active',
        'updated_by',
        'created_by'

    ];
}
