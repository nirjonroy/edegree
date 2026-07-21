<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'degree_id',
        'university_id',
        'type',
        'program',
        'short_name',
        'short_description',
        'long_description',
        'slug',
        'total_fee',
        'yearly',
        'duration',
        'link',
        'syllabus_pdf',
        'status',
        'recommend',
        'meta_title',
        'meta_description',
        'keywords',
        'canonical_url',
        'author',
        'publisher',
    ];

    protected $casts = [
        'status' => 'boolean',
        'recommend' => 'boolean',
    ];

    public function degree(): BelongsTo
    {
        return $this->belongsTo(ProgramCategory::class, 'degree_id');
    }

    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
    }
}
