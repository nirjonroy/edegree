<?php

namespace Database\Seeders;

use App\Models\CustomPage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CustomPageDataSeeder extends Seeder
{
    public function run(): void
    {
        CustomPage::where('slug', 'terms')->update([
            'slug' => 'terms-of-service',
            'desired_url' => 'terms-of-service',
        ]);

        $pages = [
            [
                'page_name' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'desired_url' => 'privacy-policy',
                'subtitle' => 'How eDegree+ handles privacy, submitted information, cookies, and partner data sharing.',
                'short_description' => 'Read the privacy rules, cookie parameters, and data protection guidelines of the eDegree+ online degree portal.',
                'description' => '<h2>1. Data Gathering Disclosures</h2><p>eDegree+ respects user choices regarding information collection. When you request admissions counseling, use search filters, or submit contact forms, we may store submitted fields such as name, email address, phone number, preferred program, and inquiry details.</p><h2>2. Partner Data Sharing</h2><p>Information submitted for enrollment checks or counseling requests may be shared with the selected partner university or authorized admissions representative. eDegree+ does not sell, lease, or license user credentials to unrelated third-party direct marketing companies.</p><h2>3. Cookie Configuration</h2><p>We may use cookies and similar browser storage to support search preferences, active degree selections, form usability, analytics, and security. Users can modify browser settings to block or remove cookies, although some website features may work less effectively.</p><h2>4. Analytics and Tracking</h2><p>Administrators may configure tools such as Google Analytics, Google Tag Manager, and Google Search Console from the admin panel. These tools help understand page performance, visitor behavior, and technical indexing status.</p><h2>5. Data Protection</h2><p>We use reasonable administrative and technical controls to protect submitted information. No internet-based platform can guarantee absolute security, so users should avoid submitting sensitive documents unless requested through an approved admissions process.</p>',
                'seo_title' => 'Privacy Policy | eDegree+',
                'seo_description' => 'Read how eDegree+ handles user privacy, cookies, analytics, contact data, and partner admissions data sharing.',
                'meta_title' => 'Privacy Policy | eDegree+',
                'meta_description' => 'Read the privacy rules, cookie parameters, and data protection guidelines of the eDegree+ online degree portal.',
                'meta_keywords' => 'privacy policy, edegree privacy, online degree portal privacy',
                'keywords' => 'privacy policy, edegree privacy, online degree portal privacy',
            ],
            [
                'page_name' => 'Terms of Service',
                'slug' => 'terms-of-service',
                'desired_url' => 'terms-of-service',
                'subtitle' => 'Terms and usage guidelines for the eDegree+ online university degree marketplace.',
                'short_description' => 'Review the Terms of Service and guidelines for the eDegree+ online university degree marketplace directory.',
                'description' => '<h2>1. Marketplace Usage Guidelines</h2><p>By using eDegree+, you agree to these service terms. The platform provides educational information, program discovery tools, comparison resources, and links or inquiry forms connected to partner university admissions processes.</p><h2>2. Information Accuracy</h2><p>We work to keep university data, tuition details, curriculum summaries, admissions requirements, and program pages accurate. Final decisions, fee structures, academic policies, and enrollment requirements are controlled by the relevant university or institution.</p><h2>3. User Responsibilities</h2><p>Users are responsible for reviewing official university documentation, confirming eligibility, and submitting accurate information during counseling or application requests. Any misuse of forms, false submissions, or unauthorized activity may result in restricted access.</p><h2>4. External Links</h2><p>Some pages may link to university websites, payment portals, application systems, or third-party services. eDegree+ is not responsible for the content, security, or policies of external websites.</p><h2>5. Limitation of Liability</h2><p>eDegree+ is not responsible for enrollment rejection, academic progress outcomes, fee changes, policy updates, or university decisions. The platform is an information and discovery service, not the awarding body for any degree.</p>',
                'seo_title' => 'Terms of Service | eDegree+',
                'seo_description' => 'Review usage terms, information accuracy limits, external link policies, and liability guidelines for eDegree+.',
                'meta_title' => 'Terms of Service | eDegree+',
                'meta_description' => 'Review the Terms of Service and guidelines for the eDegree+ online university degree marketplace directory.',
                'meta_keywords' => 'terms of service, edegree terms, online degree marketplace terms',
                'keywords' => 'terms of service, edegree terms, online degree marketplace terms',
            ],
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
