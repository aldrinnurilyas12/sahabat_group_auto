<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogActivityUsers extends Model
{
    use HasFactory;
    protected $table = 'log_activity_users';

    protected $fillable = [
        'user_id',
        'ip_address',
        'log_activity',
        'created_by'
    ];
}
