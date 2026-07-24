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
        'overview_title',
        'curriculum_title',
        'curriculum_description',
        'eligibility_title',
        'eligibility_description',
        'documents_required',
        'fees_title',
        'fees_description',
        'scholarship_title',
        'scholarship_description',
        'outcomes_title',
        'outcomes_description',
        'slug',
        'total_fee',
        'yearly',
        'duration',
        'delivery_mode',
        'link',
        'syllabus_pdf',
        'image',
        'advisor_title',
        'advisor_description',
        'apply_button_text',
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
