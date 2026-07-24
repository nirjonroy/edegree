<?php

namespace Database\Seeders;

use App\Models\HomePartner;
use App\Models\HomeSection;
use App\Models\HomeTestimonial;
use App\Models\Slider;
use App\Models\University;
use Illuminate\Database\Seeder;

class HomeContentSeeder extends Seeder
{
    public function run()
    {
        Slider::updateOrCreate(
            ['title' => 'Advance Your Career with Accredited Online University Degrees'],
            [
                'badge_text' => 'Accredited Global Partners',
                'subtitle' => "Secure recognized MBA, DBA, Master's, and Bachelor's programs without career disruption. 100% online schedules curated for working professionals.",
                'image' => 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=1170&auto=format&fit=crop',
                'primary_tab_text' => 'Find a Program',
                'secondary_tab_text' => 'Find a University',
                'search_placeholder' => 'Search course names, domains or keywords...',
                'button_text' => 'Search',
                'button_link' => '/programs',
                'sort_order' => 1,
                'status' => true,
            ]
        );

        $sections = [
            'testimonials' => [
                'title' => 'Learner Testimonials',
                'subtitle' => 'Hear from graduates who secured international qualifications while retaining their job roles.',
            ],
            'partners' => [
                'title' => 'Our Partner Universities & Accreditation Standards',
            ],
            'subscribe' => [
                'title' => 'Stay Ahead in Your Career',
                'subtitle' => 'Subscribe to receive program alerts, scholarship updates, and university admissions deadlines.',
                'button_text' => 'Subscribe Alerts',
                'input_placeholder' => 'Enter your work email',
                'privacy_note' => 'No spam. Unsubscribe at any time.',
            ],
        ];

        foreach ($sections as $key => $data) {
            HomeSection::updateOrCreate(['key' => $key], $data + ['status' => true]);
        }

        $testimonials = [
            [
                'name' => 'Liam S.',
                'designation' => 'B.Sc. Computer Science Graduate, IU Germany',
                'quote' => 'The flexibility of online study allowed me to complete assignments at my own pace without taking a career break.',
                'rating' => 5,
                'display_order' => 1,
            ],
            [
                'name' => 'Dr. Sarah Chen',
                'designation' => 'Doctor of Business Administration Alum, GGU USA',
                'quote' => 'The online DBA provided research frameworks that directly improved my consultancy work.',
                'rating' => 5,
                'display_order' => 2,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            HomeTestimonial::updateOrCreate(
                ['name' => $testimonial['name']],
                $testimonial + ['status' => true]
            );
        }

        $universities = University::where('status', true)
            ->orderBy('priority')
            ->latest()
            ->take(6)
            ->get();

        foreach ($universities as $index => $university) {
            HomePartner::updateOrCreate(
                ['name' => $university->name],
                [
                    'logo' => $university->image_1,
                    'link' => $university->slug ? route('frontend.universities.show', $university->slug, false) : null,
                    'display_order' => $index + 1,
                    'status' => true,
                ]
            );
        }
    }
}
