<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaModel extends Model
{
    use HasFactory;

    protected $table = 'agenda';
    protected $fillable = [
        'department',
        'branch',
        'agenda_name',
        'agenda_date',
        'start_time',
        'end_time',
        'created_by',
        'updated_by'
    ];
}
