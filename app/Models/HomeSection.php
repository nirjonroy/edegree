<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'title',
        'subtitle',
        'button_text',
        'input_placeholder',
        'privacy_note',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
