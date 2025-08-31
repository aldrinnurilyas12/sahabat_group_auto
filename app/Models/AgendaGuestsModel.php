<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaGuestsModel extends Model
{
    use HasFactory;

    protected $table = 'agenda_guests';
    protected $fillable = [
        'employee_id',
        'agenda_id',
        'status'
    ];
}
