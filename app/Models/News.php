<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $table = 'news';

    protected $fillable = [
        'category',
        'title',
        'slug',
        'image',
        'short_description',
        'description',
        'quote',
        'author',
        'published_at',
        'seo_title',
        'seo_description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'meta_robots',
        'meta_image',
        'publisher',
        'copyright',
        'site_name',
        'keywords',
        'robots',
        'status',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'status' => 'boolean',
    ];

    public function getSitemapUrl(): string
    {
        return $this->status ? route('frontend.news.show', $this->slug) : '';
    }
}
