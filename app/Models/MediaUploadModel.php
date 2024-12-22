<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaUploadModel extends Model
{
    use HasFactory;

    protected  $table = 'vehicle_media_player';

    protected  $fillable = [
        'vehicle_id',
        'media_type',
        'media_files',
        'media_size',
        'created_by',
        'updated_by'
    ];
}
