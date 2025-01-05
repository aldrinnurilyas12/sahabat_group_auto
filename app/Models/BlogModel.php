<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogModel extends Model
{
    use HasFactory;

    protected $table = 'blog';
    protected $fillable = [
        'title',
        'subtitle',
        'blog_foto',
        'post_date',
        'created_by',
        'updated_by'
    ];
}