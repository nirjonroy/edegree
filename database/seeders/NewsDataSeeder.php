<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class NewsDataSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'category' => 'Education Policy',
                'title' => 'US Department of Education Standardizes Higher Distance Education Assessments',
                'slug' => 'us-dept-of-education-approves-online-standards',
                'date' => '2026-07-18',
                'author' => 'Policy Desk',
                'short' => 'New federal guidelines demand standardized assessment systems for online degree programs, boosting the global credibility of distance learning.',
                'quote' => 'Standardized assessment is becoming a major signal of quality for online university programs.',
                'content' => '<p>New federal guidance encourages higher education institutions to maintain stronger assessment controls for distance learning programs. The update highlights identity verification, consistent grading policies, and transparent academic progress tracking.</p><p>For international learners, the policy movement supports greater trust in accredited online degrees. Universities offering remote programs are expected to strengthen examination systems, documentation, and student support standards.</p>',
                'keywords' => 'distance education, online degree policy, higher education',
            ],
            [
                'category' => 'University Updates',
                'title' => 'Golden Gate University Expands Online Doctoral Research Cohorts for Fall 2026',
                'slug' => 'ggu-announces-expansion-of-online-doctoral-cohorts',
                'date' => '2026-07-15',
                'author' => 'University Desk',
                'short' => 'To address high application demand, GGU expands its DBA program capacities with new research mentors specializing in AI governance.',
                'quote' => null,
                'content' => '<p>Golden Gate University has announced expanded online doctoral research capacity for Fall 2026. The additional cohorts are intended to serve senior professionals pursuing applied research in business strategy, digital transformation, and AI governance.</p><p>The expansion includes more faculty mentorship windows, structured research seminars, and additional project review capacity for working executives.</p>',
                'keywords' => 'Golden Gate University, DBA, doctoral research',
            ],
            [
                'category' => 'Admissions Alert',
                'title' => 'Online MBA Scholarship Windows Open for Working Professionals',
                'slug' => 'online-mba-scholarship-windows-open-working-professionals',
                'date' => '2026-07-10',
                'author' => 'Admissions Desk',
                'short' => 'Several partner universities have opened scholarship windows for online MBA applicants with professional experience.',
                'quote' => null,
                'content' => '<p>Scholarship windows are now open for selected online MBA intakes. Applicants with strong academic records, leadership experience, and clear career goals may be eligible for tuition reductions or flexible installment plans.</p><p>Students should prepare transcripts, resume, identity documents, and statement of purpose before counseling review to avoid missing intake deadlines.</p>',
                'keywords' => 'MBA scholarship, online MBA admissions, working professionals',
            ],
            [
                'category' => 'Accreditation',
                'title' => 'UK Online Degree Providers Publish Updated Quality Assurance Guidelines',
                'slug' => 'uk-online-degree-providers-update-quality-assurance-guidelines',
                'date' => '2026-07-04',
                'author' => 'Accreditation Desk',
                'short' => 'Updated quality guidelines place renewed focus on academic support, assessment integrity, and transparent learner outcomes.',
                'quote' => 'Quality assurance is moving from platform access toward measurable learner support and assessment integrity.',
                'content' => '<p>UK online degree providers have published updated guidance covering student support, assessment integrity, academic feedback, and public reporting of learner outcomes.</p><p>The guidance is relevant for international students comparing online programs because it clarifies what responsible providers should publish before enrollment.</p>',
                'keywords' => 'UK degree, quality assurance, accreditation',
            ],
        ];

        foreach ($items as $item) {
            News::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'category' => $item['category'],
                    'title' => $item['title'],
                    'short_description' => $item['short'],
                    'description' => $item['content'],
                    'quote' => $item['quote'],
                    'author' => $item['author'],
                    'published_at' => Carbon::parse($item['date']),
                    'meta_title' => $item['title'].' | eDegree+',
                    'meta_description' => $item['short'],
                    'meta_keywords' => $item['keywords'],
                    'canonical_url' => url('/news/'.$item['slug']),
                    'meta_robots' => 'index,follow',
                    'status' => true,
                ]
            );
        }
    }
}
