<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeTestimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'designation',
        'quote',
        'rating',
        'image',
        'display_order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'rating' => 'integer',
    ];
}
