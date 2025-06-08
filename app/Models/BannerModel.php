<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerModel extends Model
{
    use HasFactory;

    protected $table = 'banner_landingpage';
    protected $fillable = [
        'banner_name',
        'banner_file',
        'banner_title',
        'text_content',
        'is_active',
        'button_1',
        'button_2',
        'link_1',
        'link_2',
        'created_by',
        'updated_by'
    ];
}
