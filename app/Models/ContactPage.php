<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_title',
        'subtitle',
        'details_title',
        'email_label',
        'email',
        'phone_label',
        'phone_1',
        'phone_2',
        'office_label',
        'office_1',
        'office_2',
        'form_title',
        'name_placeholder',
        'email_placeholder',
        'subject_placeholder',
        'message_placeholder',
        'button_text',
        'success_title',
        'success_message',
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
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
