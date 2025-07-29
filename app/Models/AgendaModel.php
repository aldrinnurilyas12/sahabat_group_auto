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
        'meeting_leader',
        'agenda_name',
        'agenda_date',
        'status',
        'start_time',
        'end_time',
        'created_by',
        'updated_by'
    ];
}
