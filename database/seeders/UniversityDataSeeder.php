<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\ProgramCategory;
use App\Models\University;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UniversityDataSeeder extends Seeder
{
    public function run(): void
    {
        $categories = collect(['MBA', 'DBA', "Master's", "Bachelor's"])->mapWithKeys(function (string $name) {
            return [$name => ProgramCategory::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'status' => true]
            )];
        });

        $universities = [
            [
                'name' => 'Golden Gate University',
                'slug' => 'ggu-usa',
                'location' => 'San Francisco, USA',
                'founded_year' => '1901',
                'ranking_badge' => '#38 Regional Universities West',
                'accreditation_badge' => 'WSCUC',
                'degree_badge' => 'US Accredited',
                'priority' => 1,
                'short_description' => 'A private, non-profit university in San Francisco focused on working professionals, business, law, taxation and accounting.',
                'profile_description' => "Golden Gate University is a private, non-profit university in San Francisco, California. Founded in 1901, GGU specializes in educating professionals through its schools of law, business, taxation, and accounting. GGU online programs are designed for working adults with rigorous academic standards, flexible pacing, and access to a global alumni network.",
                'accomplishment_text' => '68,000+ alumni network across Silicon Valley and global business hubs.',
                'accreditation_description' => 'Golden Gate University maintains regional accreditation for recognized US degree pathways.',
                'accrediting_commission_text' => 'WASC Senior College and University Commission (WSCUC)',
                'admissions_description' => "Admissions are open to professionals holding a valid bachelor's degree for postgraduate courses or a high school diploma for undergraduate programs. Standardized scores may be optional. Applicants submit transcripts, resume, statement of purpose, and English language proof where required.",
                'review_1_name' => 'Marcus Vance, MBA Graduate',
                'review_1_text' => 'GGU online MBA was practical. Every project could be applied directly to my tech consulting career.',
                'review_1_rating' => 5,
                'review_2_name' => 'Dr. Sarah Chen, DBA Alum',
                'review_2_text' => 'The DBA program balanced structured doctoral research with flexible online coursework.',
                'review_2_rating' => 5,
                'rank' => '#38 in Best Regional Universities West',
                'image_1' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=1600&h=600&fit=crop&q=80',
            ],
            [
                'name' => 'London Metropolitan University',
                'slug' => 'london-met',
                'location' => 'London, United Kingdom',
                'founded_year' => '1848',
                'ranking_badge' => 'Top 100 UK',
                'accreditation_badge' => 'QAA Approved',
                'degree_badge' => 'UK Accredited',
                'priority' => 2,
                'short_description' => 'An established public university in London offering practical, career-focused UK education pathways.',
                'profile_description' => 'London Metropolitan University is an established public university in London, England. With roots dating back to 1848, it is known for a diverse student body and practical, career-focused education. Its online pathways help learners worldwide upgrade credentials without relocating to the UK.',
                'accomplishment_text' => 'Top 100 UK University according to major UK university guide positioning.',
                'accreditation_description' => 'London Metropolitan University operates under UK higher education quality assurance standards.',
                'accrediting_commission_text' => 'QAA (Quality Assurance Agency for Higher Education, UK)',
                'admissions_description' => "Applicants usually need a UK bachelor's degree or equivalent international qualification. Professional experience may be considered for mature candidates. Standard requirements include recommendations, transcripts, and English proficiency evidence.",
                'review_1_name' => 'David K., Global MBA Student',
                'review_1_text' => 'Having a UK degree on my profile opened doors in Europe. The online portal is clean and easy to navigate.',
                'review_1_rating' => 5,
                'review_2_name' => 'Elena R., MSc Data Science Student',
                'review_2_text' => 'The curriculum matches the on-campus program and group work is highly collaborative.',
                'review_2_rating' => 5,
                'rank' => 'Top 100 UK University',
                'image_1' => 'https://images.unsplash.com/photo-1513694203232-719a280e022f?w=1600&h=600&fit=crop&q=80',
            ],
            [
                'name' => 'IU International University of Applied Sciences',
                'slug' => 'iu-germany',
                'location' => 'Erfurt, Germany',
                'founded_year' => '1998',
                'ranking_badge' => '5 Stars Online',
                'accreditation_badge' => 'FIBAA',
                'degree_badge' => 'EU Accredited',
                'priority' => 3,
                'short_description' => 'Germany largest private, state-accredited university with flexible 100% digital study paths.',
                'profile_description' => 'IU International University of Applied Sciences is Germany largest private, state-accredited university. IU offers online study paths with digital textbooks, flexible exams, and learning support for students worldwide seeking European qualifications.',
                'accomplishment_text' => 'Over 100,000 active students across online and blended study formats.',
                'accrediting_commission_text' => 'FIBAA and German Accreditation Council',
                'admissions_description' => "Bachelor degrees require secondary school completion. Master's and MBA programs require an undergraduate degree, professional experience where applicable, and English proficiency proof.",
                'review_1_name' => 'Liam S., B.Sc. Computer Science',
                'review_1_text' => 'The freedom to take exams whenever I am ready is ideal for combining studies with full-time work.',
                'review_1_rating' => 5,
                'rank' => '5 Stars for Online Learning',
                'image_1' => 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?w=1600&h=600&fit=crop&q=80',
            ],
            [
                'name' => 'Chicago State University',
                'slug' => 'chicago-state',
                'location' => 'Chicago, USA',
                'founded_year' => '1867',
                'ranking_badge' => 'Public University',
                'accreditation_badge' => 'HLC Accredited',
                'degree_badge' => 'US Accredited',
                'priority' => 4,
                'short_description' => 'A public university offering diverse undergraduate and graduate pathways with online access.',
                'profile_description' => 'Chicago State University is a public university founded in 1867. Through online program structures, CSU makes regionally accredited American university education accessible to global students and working professionals.',
                'accrediting_commission_text' => 'Higher Learning Commission (HLC)',
                'admissions_description' => 'Admissions require an application, academic transcripts, and a professional resume. Graduate programs may request recommendations, personal statement, and minimum GPA requirements.',
                'review_1_name' => 'Angela H., MBA Graduate',
                'review_1_text' => 'The professors were interactive and the program helped me transition to a senior administration role.',
                'review_1_rating' => 5,
                'rank' => 'Regionally Accredited Public University',
                'image_1' => 'https://images.unsplash.com/photo-1562774053-701939374585?w=1600&h=600&fit=crop&q=80',
            ],
            [
                'name' => 'Shiv Nadar University',
                'slug' => 'shiv-nadar',
                'location' => 'NCR, India',
                'founded_year' => '2011',
                'ranking_badge' => 'Institution of Eminence',
                'accreditation_badge' => 'UGC',
                'degree_badge' => 'NAAC Grade A',
                'priority' => 5,
                'short_description' => 'A multidisciplinary, research-focused private university with premium digital specializations.',
                'profile_description' => 'Shiv Nadar University is a comprehensive, multidisciplinary, research-focused private university in India. Its online degree portfolio brings high-standard Indian higher education to global professionals seeking specialization in digital transformation, finance, and business systems.',
                'accrediting_commission_text' => 'UGC and NAAC Grade A',
                'admissions_description' => "Postgraduate admissions require a recognized bachelor's degree with minimum score requirements. Selection may include academic screening, professional accomplishments, statement of purpose, and an online evaluation interview.",
                'review_1_name' => 'Rajesh P., MBA in Digital Finance',
                'review_1_text' => 'A cutting-edge curriculum focusing on fintech, blockchain and analytics.',
                'review_1_rating' => 5,
                'rank' => '#1 New Private University in India',
                'image_1' => 'https://images.unsplash.com/photo-1607237138185-eedd996c5c0c?w=1600&h=600&fit=crop&q=80',
            ],
            [
                'name' => 'Liverpool John Moores University',
                'slug' => 'ljmu-uk',
                'location' => 'Liverpool, United Kingdom',
                'founded_year' => '1823',
                'ranking_badge' => 'Top 50 UK',
                'accreditation_badge' => 'QAA Approved',
                'degree_badge' => 'UK Accredited',
                'priority' => 6,
                'short_description' => 'A distinctive public research university extending postgraduate pathways online.',
                'profile_description' => 'Liverpool John Moores University is a public research university in Liverpool, England. Its online postgraduate pathways make advanced degrees in data science, computing, and global business accessible to international students.',
                'accrediting_commission_text' => 'QAA (Quality Assurance Agency for Higher Education, UK)',
                'admissions_description' => "MSc applicants usually need a completed bachelor's degree in a quantitative field or equivalent experience. Applications require transcripts, curriculum vitae, and English proficiency details.",
                'review_1_name' => 'Ksenia M., MSc Data Science Graduate',
                'review_1_text' => 'Excellent mentors and structured modules. My thesis addressed a real-world predictive modeling problem.',
                'review_1_rating' => 5,
                'rank' => 'Top 50 UK University',
                'image_1' => 'https://images.unsplash.com/photo-1541829019-2592e6274bc2?w=1600&h=600&fit=crop&q=80',
            ],
        ];

        foreach ($universities as $data) {
            University::updateOrCreate(
                ['slug' => $data['slug']],
                array_merge([
                    'status' => true,
                    'is_done' => true,
                    'profile_title' => 'University Profile',
                    'accomplishment_title' => 'Key Accomplishments',
                    'accreditation_title' => 'Recognized Status',
                    'admissions_title' => 'Admissions Guidelines',
                    'reviews_title' => 'Graduate Testimonials',
                    'advisor_title' => 'Talk to an Advisor',
                    'advisor_description' => 'Connect directly with admissions advisors concerning registration guidelines.',
                    'meta_title' => $data['name'].' | eDegree+',
                    'meta_description' => $data['short_description'],
                ], $data)
            );
        }

        $programs = [
            ['london-met', 'MBA', 'Global Master of Business Administration', 'global-master-of-business-administration', '$10,500', '18 Months', true],
            ['london-met', "Master's", 'Master of Arts in Education and Leadership', 'master-of-arts-education-leadership', '$9,800', '12 Months', false],
            ['ggu-usa', 'DBA', 'Doctor of Business Administration (DBA)', 'doctor-of-business-administration-dba', '$24,000', '36 Months', true],
            ['ggu-usa', "Master's", 'Master of Science in Business Analytics', 'master-science-business-analytics', '$14,800', '12 Months', true],
            ['iu-germany', "Bachelor's", 'Bachelor of Science in Computer Science', 'bachelor-science-computer-science', '$8,900', '36 Months', false],
            ['iu-germany', 'MBA', 'MBA in Engineering Management', 'mba-engineering-management', '$11,200', '18 Months', false],
            ['chicago-state', 'MBA', 'Online MBA in Healthcare Administration', 'online-mba-healthcare-administration', '$12,500', '18 Months', false],
            ['shiv-nadar', 'MBA', 'MBA in Digital Finance', 'mba-digital-finance', '$7,900', '18 Months', false],
            ['ljmu-uk', "Master's", 'MSc Data Science', 'msc-data-science', '$10,900', '18 Months', false],
        ];

        foreach ($programs as [$universitySlug, $categoryName, $programName, $slug, $fee, $duration, $recommend]) {
            $university = University::where('slug', $universitySlug)->first();
            $category = $categories[$categoryName] ?? null;

            Program::updateOrCreate(
                ['slug' => $slug],
                [
                    'degree_id' => $category?->id,
                    'university_id' => $university?->id,
                    'type' => $categoryName,
                    'program' => $programName,
                    'short_name' => Str::limit($programName, 80),
                    'short_description' => 'Accredited online '.$categoryName.' program delivered for working professionals.',
                    'long_description' => '<p>This '.$categoryName.' program is designed for working professionals seeking recognized online university credentials with flexible study delivery, applied learning, and career-focused academic support.</p>',
                    'overview_title' => 'Program Overview',
                    'curriculum_title' => 'Curriculum Structure',
                    'curriculum_description' => '<ul><li>Foundation and core subject modules</li><li>Applied industry projects</li><li>Research, strategy, and leadership work</li><li>Final capstone or dissertation pathway</li></ul>',
                    'eligibility_title' => 'Admissions Guidelines',
                    'eligibility_description' => '<p>Applicants should meet the academic entry requirements for this level and submit required documents during counseling or application review.</p>',
                    'documents_required' => '<ul><li>Academic transcripts or certificates</li><li>Updated resume or CV where applicable</li><li>Passport or national identity document</li><li>English proficiency proof when required</li></ul>',
                    'fees_title' => 'Tuition Details',
                    'fees_description' => '<p>Tuition can vary by intake, university policy, and available partner discounts. Contact the admission team for the latest payment plan.</p>',
                    'scholarship_title' => 'Scholarships & Financing Options',
                    'scholarship_description' => 'Scholarships, installment plans, and partner discounts may be available depending on intake and student eligibility.',
                    'outcomes_title' => 'Career Outcomes',
                    'outcomes_description' => '<p>Graduates can use this pathway to strengthen credentials for management, specialist, research, academic, and executive roles depending on the subject area.</p>',
                    'delivery_mode' => '100% Online',
                    'advisor_title' => 'Request Free Counseling',
                    'advisor_description' => 'Leave details below and academic advisors will call back with program guidance.',
                    'apply_button_text' => 'Apply Online Now',
                    'total_fee' => $fee,
                    'duration' => $duration,
                    'status' => true,
                    'recommend' => $recommend,
                    'meta_title' => $programName.' | eDegree+',
                    'meta_description' => 'Explore '.$programName.' through eDegree+.',
                ]
            );
        }
    }
}
