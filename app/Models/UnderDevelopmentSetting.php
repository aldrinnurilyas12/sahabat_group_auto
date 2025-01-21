<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnderDevelopmentSetting extends Model
{
    use HasFactory;

    protected $table = 'under_development_setting';
    protected $fillable = [
        'under_development',
        'description',
        'admin_web',
        'landing_page_web',
        'updated_by'
    ];
}
