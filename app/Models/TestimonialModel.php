<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestimonialModel extends Model
{
    use HasFactory;


    protected $table = 'customers_testimonial';
    protected $fillable = [
        'customer_name',
        'email',
        'testimonial',
        'rating',
        'criticsm_and_suggestion',
        'hidden_name'
    ];
}
