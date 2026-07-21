<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class University extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'link',
        'status',
        'is_done',
        'priority',
        'slider1',
        'slider2',
        'slider3',
        'short_description',
        'long_description',
        'rated',
        'global_network',
        'award',
        'rank',
        'image_1',
        'image_2',
        'image_3',
        'image_4',
        'image_5',
        'faq_question_1',
        'faq_question_2',
        'faq_question_3',
        'faq_question_4',
        'faq_question_5',
        'faq_answer_1',
        'faq_answer_2',
        'faq_answer_3',
        'faq_answer_4',
        'faq_answer_5',
        'meta_title',
        'meta_description',
        'keywords',
    ];

    protected $casts = [
        'status' => 'boolean',
        'is_done' => 'boolean',
    ];

    public function programs(): HasMany
    {
        return $this->hasMany(Program::class);
    }
}
