<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_title',
        'profile_title',
        'image_1',
        'image_2',
        'image_3',
        'about_us',
        'stat_1_value',
        'stat_1_label',
        'stat_2_value',
        'stat_2_label',
        'stat_3_value',
        'stat_3_label',
        'faq_title',
        'faq_question_1',
        'faq_answer_1',
        'faq_question_2',
        'faq_answer_2',
        'faq_question_3',
        'faq_answer_3',
        'meta_title',
        'meta_description',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
