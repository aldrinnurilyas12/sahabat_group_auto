<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebVisitor extends Model
{
    use HasFactory;

    protected $table = 'webvisitor';
    protected $fillable = [
        'ip_address'
    ];
}
