<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'badge_text',
        'title',
        'subtitle',
        'image',
        'primary_tab_text',
        'secondary_tab_text',
        'search_placeholder',
        'button_text',
        'button_link',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
