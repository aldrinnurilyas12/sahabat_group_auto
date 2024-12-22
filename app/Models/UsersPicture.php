<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersPicture extends Model
{
    use HasFactory;

    protected $table = 'users_picture';

    protected $fillable = [
        'user_id',
        'users_foto',
        'created_by',
        'updated_by'
    ];
}