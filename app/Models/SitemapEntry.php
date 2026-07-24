<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SitemapEntry extends Model
{
    use HasFactory;

    public const CHANGEFREQ_OPTIONS = [
        'always' => 'Always',
        'hourly' => 'Hourly',
        'daily' => 'Daily',
        'weekly' => 'Weekly',
        'monthly' => 'Monthly',
        'yearly' => 'Yearly',
        'never' => 'Never',
    ];

    protected $fillable = [
        'title',
        'url',
        'source_type',
        'source_id',
        'changefreq',
        'priority',
        'lastmod',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'lastmod' => 'datetime',
        'priority' => 'decimal:1',
    ];

    public function getAbsoluteUrlAttribute(): string
    {
        if (str_starts_with($this->url, 'http://') || str_starts_with($this->url, 'https://')) {
            return $this->url;
        }

        return url('/'.ltrim($this->url, '/'));
    }
}
