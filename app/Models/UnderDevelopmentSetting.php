<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnderDevelopmentSetting extends Model
{
    use HasFactory;

    protected $table = 'under_development_setting';
    protected $fillable = [
        'admin_web',
        'landing_page_web',
        'description',
        'start_date_maintenance',
        'time_start_date_maintenance',
        'end_date_maintenance',
        'time_end_date_maintenance',
        'created_by'
    ];
}
