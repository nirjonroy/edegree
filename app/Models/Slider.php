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
        'seo_title',
        'seo_description',
        'meta_title',
        'meta_description',
        'meta_image',
        'author',
        'publisher',
        'copyright',
        'site_name',
        'keywords',
        'robots',
        'canonical_url',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
