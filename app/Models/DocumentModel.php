<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentModel extends Model
{
    use HasFactory;

    protected $table = 'vehicle_document';

    protected $fillable = [
        'vehicle_id',
        'document_files',
        'updated_by',
        'created_by'
    ];
}
