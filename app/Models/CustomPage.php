<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_name',
        'slug',
        'desired_url',
        'subtitle',
        'short_description',
        'description',
        'background_image',
        'seo_title',
        'seo_description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'meta_robots',
        'meta_image',
        'author',
        'publisher',
        'copyright',
        'site_name',
        'keywords',
        'robots',
        'status',
        'published_at',
    ];

    protected $casts = [
        'status' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected $appends = [
        'public_url',
    ];

    public function getPublicUrlAttribute(): string
    {
        return '/'.($this->desired_url ?: $this->slug);
    }

    public function getSitemapUrl(): string
    {
        return $this->status ? url($this->desired_url ?: $this->slug) : '';
    }
}
