<?php

namespace Database\Seeders;

use App\Models\CustomPage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CustomPageDataSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'page_name' => 'Buy Guide',
                'slug' => 'buy-guide',
                'desired_url' => 'guides/buy-guide',
                'subtitle' => 'A practical checklist for comparing online university degrees before enrollment.',
                'short_description' => 'Use this guide to verify accreditation, tuition, eligibility, delivery mode, and application documents before selecting a program.',
                'description' => '<h2>How to Choose an Online Degree</h2><p>Start by confirming the awarding university, accreditation body, admission requirements, program duration, and total payable tuition. A good online degree should clearly explain the credential awarded, assessment model, student support process, and expected career outcomes.</p><h3>Before You Apply</h3><ul><li>Check university accreditation and awarding authority.</li><li>Compare total fee, installment options, and scholarship eligibility.</li><li>Review the curriculum, assessment structure, and delivery mode.</li><li>Confirm whether the certificate or transcript mentions online delivery.</li></ul><p>When a program matches your career goal and admission profile, request counseling before submitting documents.</p>',
                'meta_title' => 'Buy Guide for Online Degrees | eDegree+',
                'meta_description' => 'Compare online degree programs with a practical checklist covering accreditation, fees, documents, and career outcomes.',
                'meta_keywords' => 'online degree guide, buy guide, accredited online programs',
            ],
            [
                'page_name' => 'Why Choose Us',
                'slug' => 'why-choose-us',
                'desired_url' => 'why-choose-us',
                'subtitle' => 'eDegree+ connects working professionals with recognized online degree pathways.',
                'short_description' => 'We help learners compare global universities, understand admissions, and choose online programs that fit their schedule and goals.',
                'description' => '<h2>Built for Working Professionals</h2><p>eDegree+ focuses on accredited online programs that can be completed without leaving your job role. The platform brings university profiles, program details, fees, curriculum summaries, and counseling support into one place.</p><h3>What Makes Us Useful</h3><ul><li>Curated universities and programs from recognized institutions.</li><li>Clear program pages with duration, tuition, eligibility, and outcomes.</li><li>Advisor support for document review and application preparation.</li><li>Regular news and blog updates for online higher education decisions.</li></ul>',
                'meta_title' => 'Why Choose eDegree+',
                'meta_description' => 'Learn why eDegree+ is useful for comparing accredited online university programs.',
                'meta_keywords' => 'edegree plus, online degree counseling, accredited universities',
            ],
            [
                'page_name' => 'About University',
                'slug' => 'about-university',
                'desired_url' => 'about-university',
                'subtitle' => 'Learn how eDegree+ presents partner universities, accreditation details, and online degree pathways.',
                'short_description' => 'This page explains how partner university information is structured, including location, ranking, accreditation, available programs, admissions guidance, and student outcomes.',
                'description' => '<h2>Partner University Information</h2><p>Each university profile on eDegree+ is designed to help learners understand the institution before selecting a program. Profiles include university background, location, foundation year, accreditation details, ranking highlights, admission requirements, available online programs, and career-focused learning outcomes.</p><h3>What Students Can Compare</h3><ul><li>University name, location, and official profile information.</li><li>Accreditation body, ranking badge, and degree recognition details.</li><li>Available online programs connected with that university.</li><li>Admission guidelines, required documents, tuition, and duration.</li><li>Student reviews, accomplishments, and advisor contact options.</li></ul><p>Administrators can manage university records from the admin panel, and those records automatically reflect on university listing pages, university detail pages, program pages, and home-page partner sections.</p>',
                'meta_title' => 'About Partner Universities | eDegree+',
                'meta_description' => 'Learn how eDegree+ presents partner university profiles, accreditation, admissions, and online program information.',
                'meta_keywords' => 'partner universities, university profiles, online university data, accreditation',
            ],
            [
                'page_name' => 'Dhaka Property Sitemap',
                'slug' => 'dhaka-property-sitemap',
                'desired_url' => 'sitemap/dhaka/property',
                'subtitle' => 'Demo custom page showing that any public URL path can be managed from admin.',
                'short_description' => 'This seeded page demonstrates nested custom URLs using the Desired URL field in the admin panel.',
                'description' => '<h2>Custom URL Demo</h2><p>This page is intentionally seeded at a nested URL path to demonstrate that custom pages can be published outside the default slug path. Editors can set URLs such as <strong>guides/buy-guide</strong>, <strong>why-choose-us</strong>, or <strong>sitemap/dhaka/property</strong>.</p><p>Use this for policy pages, guides, landing pages, campaign pages, and other static content managed through the admin panel.</p>',
                'meta_title' => 'Dhaka Property Sitemap Demo',
                'meta_description' => 'Demo custom page for nested custom URL support.',
                'meta_keywords' => 'custom page, sitemap demo, dynamic page',
            ],
        ];

        foreach ($pages as $page) {
            CustomPage::updateOrCreate(
                ['slug' => $page['slug']],
                array_merge([
                    'canonical_url' => url('/'.trim($page['desired_url'], '/')),
                    'meta_robots' => 'index,follow',
                    'status' => true,
                    'published_at' => now(),
                ], $page)
            );
        }
    }
}
