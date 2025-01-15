<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingsScheduleTime extends Model
{
    use HasFactory;
    protected $table = 'settings_schedule_time';

    protected $fillable = [
        'open_schedule_time',
        'updated_by'
    ];
}