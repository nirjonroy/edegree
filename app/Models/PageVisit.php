<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'visitor_id',
        'session_id',
        'ip_address',
        'mac_address',
        'is_frontend',
        'method',
        'url',
        'path',
        'route_name',
        'user_agent',
        'referer',
        'visited_at',
    ];

    protected $casts = [
        'is_frontend' => 'boolean',
        'visited_at' => 'datetime',
    ];

    public function scopeFrontend(Builder $query): Builder
    {
        return $query->where('is_frontend', true);
    }

    public static function uniqueVisitorExpression(): string
    {
        return "COALESCE(visitor_id, session_id, ip_address)";
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
