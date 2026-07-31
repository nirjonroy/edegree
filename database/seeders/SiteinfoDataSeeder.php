<?php

namespace Database\Seeders;

use App\Models\Siteinfo;
use Illuminate\Database\Seeder;

class SiteinfoDataSeeder extends Seeder
{
    public function run(): void
    {
        Siteinfo::updateOrCreate(
            ['sidebar_lg_header' => 'eDegree+'],
            [
                'sidebar_sm_header' => 'eD+',
                'footer_contact_note' => 'Connecting professionals with premium, accredited online university degree programs worldwide.',
                'maintenance_mode' => false,
                'contact_email' => 'support@edegreeplus.com',
                'topbar_email' => 'support@edegreeplus.com',
                'topbar_phone' => '+1 (800) 555-DEGREE',
                'default_phone_code' => '+1',
                'frontend_url' => url('/'),
                'homepage_section_title' => 'eDegree+ | Accredited Online University Degree Programs',
                'enable_user_register' => true,
                'phone_number_required' => false,
                'enable_subscription_notify' => false,
                'enable_save_contact_message' => true,
                'text_direction' => 'ltr',
                'default_theme' => 'light',
                'timezone' => 'UTC',
                'image_output_format' => 'webp',
            ]
        );
    }
}
