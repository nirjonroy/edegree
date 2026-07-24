<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class BlogDataSeeder extends Seeder
{
    public function run(): void
    {
        $categories = collect([
            ['name' => 'Education Trends', 'slug' => 'education-trends', 'display_order' => 1],
            ['name' => 'Career Guide', 'slug' => 'career-guide', 'display_order' => 2],
            ['name' => 'Executive Growth', 'slug' => 'executive-growth', 'display_order' => 3],
            ['name' => 'Learning Tips', 'slug' => 'learning-tips', 'display_order' => 4],
            ['name' => 'Admissions Info', 'slug' => 'admissions-info', 'display_order' => 5],
        ])->mapWithKeys(function (array $category) {
            return [
                $category['slug'] => BlogCategory::updateOrCreate(
                    ['slug' => $category['slug']],
                    [
                        'name' => $category['name'],
                        'display_order' => $category['display_order'],
                        'is_active' => true,
                    ]
                ),
            ];
        });

        $posts = [
            [
                'category' => 'education-trends',
                'title' => 'The Growing Value of Online Degrees in the 2026 Job Market',
                'slug' => 'value-of-online-degrees-2026',
                'author' => 'Dr. Alistair Vance',
                'date' => '2026-07-12',
                'image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=900&h=520&fit=crop&q=80',
                'short' => 'Employers increasingly value accredited online credentials as proof of discipline, agility, and applied digital collaboration.',
                'quote' => 'An online degree shows that an employee can manage complex tasks autonomously, organize schedules, and master digital collaboration tools.',
                'content' => '<p>As remote operations stabilize and professional systems transition into hybrid formats, global corporations are assessing applicants differently. Historically, traditional brick-and-mortar degrees were the gold standard. Today, recruiters also value agility, self-discipline, and digital proficiency, qualities demonstrated by successful online university graduates.</p><p>Major technology, consulting, finance, healthcare, and operations employers now evaluate accredited credentials, practical capstones, and evidence of lifelong learning. A strong online degree can help working professionals improve their profile without pausing career momentum.</p>',
                'keywords' => 'online degrees, career growth, accredited education',
            ],
            [
                'category' => 'career-guide',
                'title' => 'How to Choose the Right Online MBA Program for Your Goals',
                'slug' => 'how-to-choose-mba-program',
                'author' => 'Maya Rahman',
                'date' => '2026-07-08',
                'image' => 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?w=900&h=520&fit=crop&q=80',
                'short' => 'Compare accreditation, curriculum fit, delivery model, support, and total cost before selecting an online MBA pathway.',
                'quote' => null,
                'content' => '<p>The right MBA depends on your career target. A future operations leader may need analytics, supply chain, and strategy modules, while a finance professional may prioritize corporate finance, risk, and leadership electives.</p><p>Before applying, compare accreditation, recognition, university support, alumni outcomes, fee structure, and flexibility. The strongest program is the one that fits your professional schedule while still requiring meaningful academic work.</p>',
                'keywords' => 'MBA, online MBA, business degree',
            ],
            [
                'category' => 'executive-growth',
                'title' => 'The Rise of the DBA: Why Executives are Choosing Doctoral Study',
                'slug' => 'rise-of-the-dba-executive-study',
                'author' => 'Nadia Karim',
                'date' => '2026-07-02',
                'image' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=900&h=520&fit=crop&q=80',
                'short' => 'The DBA has become a practical doctorate for senior professionals who want research depth without leaving leadership roles.',
                'quote' => 'A DBA is strongest when it turns executive experience into structured, evidence-based leadership practice.',
                'content' => '<p>Executives are choosing DBA programs because they connect applied research with boardroom realities. Unlike purely theoretical pathways, many DBA formats focus on solving complex organizational problems through rigorous research methods.</p><p>For senior managers, entrepreneurs, consultants, and educators, doctoral study can strengthen authority, sharpen strategic thinking, and open academic or advisory opportunities.</p>',
                'keywords' => 'DBA, doctorate, executive education',
            ],
            [
                'category' => 'learning-tips',
                'title' => 'Building a Weekly Study Routine for Online Degree Success',
                'slug' => 'weekly-study-routine-online-degree',
                'author' => 'Farhan Ahmed',
                'date' => '2026-06-25',
                'image' => 'https://images.unsplash.com/photo-1484480974693-6ca0a78fb36b?w=900&h=520&fit=crop&q=80',
                'short' => 'A simple weekly routine can help working learners stay consistent through lectures, reading, assignments, and exams.',
                'quote' => null,
                'content' => '<p>Online learning rewards consistency. Successful students usually reserve fixed study blocks, review module goals early, and leave buffer time before submission deadlines.</p><p>Use one weekly planning session to map lectures, reading, discussion posts, and assignments. Keep a separate review window for difficult concepts so exam preparation does not become last-minute work.</p>',
                'keywords' => 'online learning, study routine, distance learning',
            ],
            [
                'category' => 'admissions-info',
                'title' => 'Documents You Should Prepare Before Applying Online',
                'slug' => 'documents-before-online-application',
                'author' => 'Admissions Desk',
                'date' => '2026-06-18',
                'image' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?w=900&h=520&fit=crop&q=80',
                'short' => 'Most universities require transcripts, ID proof, a resume, and supporting statements before admission review.',
                'quote' => null,
                'content' => '<p>Preparing documents early makes application review faster. Most universities ask for academic transcripts, certificates, a passport or national ID, updated CV, and a statement of purpose.</p><p>Graduate programs may also request recommendation letters, English proficiency proof, or work experience documents. Requirements vary by university, so students should confirm the latest checklist before submission.</p>',
                'keywords' => 'admissions, application documents, university admission',
            ],
        ];

        foreach ($posts as $post) {
            BlogPost::updateOrCreate(
                ['slug' => $post['slug']],
                [
                    'blog_category_id' => $categories[$post['category']]->id,
                    'title' => $post['title'],
                    'author_name' => $post['author'],
                    'excerpt' => $post['short'],
                    'content' => $post['content'],
                    'quote' => $post['quote'],
                    'image' => $post['image'],
                    'short_description' => $post['short'],
                    'long_description' => $post['content'],
                    'featured_image_path' => $post['image'],
                    'meta_title' => $post['title'].' | eDegree+',
                    'meta_description' => $post['short'],
                    'author' => $post['author'],
                    'publisher' => 'eDegree+',
                    'copyright' => 'eDegree+',
                    'site_name' => 'eDegree+',
                    'keywords' => $post['keywords'],
                    'description' => $post['short'],
                    'status' => 'published',
                    'tags' => $post['keywords'],
                    'published_at' => Carbon::parse($post['date']),
                    'is_published' => true,
                    'show_on_home' => in_array($post['slug'], ['value-of-online-degrees-2026', 'how-to-choose-mba-program'], true),
                ]
            );
        }
    }
}
