<?php

namespace Tests\Feature;

use App\Models\Program;
use App\Models\ProgramCategory;
use App\Models\University;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AdminUniversityProgramCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_university(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/universities', [
                'name' => 'Demo University',
                'slug' => 'demo-university',
                'link' => 'https://example.com',
                'location' => 'London, United Kingdom',
                'founded_year' => '1848',
                'ranking_badge' => 'Top 100 UK Ranking',
                'accreditation_badge' => 'QAA Approved',
                'degree_badge' => 'UK Accredited Degrees',
                'status' => 1,
                'is_done' => 1,
                'priority' => 2,
                'image_1' => UploadedFile::fake()->image('university.jpg'),
                'short_description' => 'Short university description',
                'long_description' => '<p>Long university description</p>',
                'profile_title' => 'University Profile',
                'profile_description' => '<p>Profile content</p>',
                'accomplishment_title' => 'Key Accomplishments',
                'accomplishment_text' => 'Top 100 UK University',
                'accreditation_title' => 'Recognized Status',
                'accreditation_description' => '<p>Accreditation content</p>',
                'accrediting_commission_title' => 'Accrediting Commission',
                'accrediting_commission_text' => 'QAA',
                'admissions_title' => 'Admissions Guidelines',
                'admissions_description' => '<p>Admission content</p>',
                'reviews_title' => 'Graduate Testimonials',
                'review_1_name' => 'David K.',
                'review_1_text' => 'Great portal.',
                'review_1_rating' => 5,
                'advisor_title' => 'Talk to an Advisor',
                'advisor_description' => 'Connect directly with advisors.',
                'rated' => '4.8',
                'global_network' => '50 countries',
                'award' => 'Top Ranked',
                'rank' => '#12',
                'faq_question_1' => 'What is required?',
                'faq_answer_1' => 'Documents are required.',
                'meta_title' => 'Demo University',
                'meta_description' => 'Demo meta description',
                'keywords' => 'university, education',
            ])
            ->assertRedirect('/admin/universities');

        $this->assertDatabaseHas('universities', [
            'name' => 'Demo University',
            'slug' => 'demo-university',
            'location' => 'London, United Kingdom',
            'profile_title' => 'University Profile',
            'status' => 1,
            'is_done' => 1,
        ]);
    }

    public function test_university_create_form_uses_single_image_and_hides_profile_content_fields(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/universities/create')
            ->assertOk()
            ->assertSee('Main Image')
            ->assertDontSee('Profile Title')
            ->assertDontSee('Profile Description')
            ->assertSee('Accreditation Title')
            ->assertSee('Admissions Title')
            ->assertSee('Reviews Title')
            ->assertSee('Advisor Box Title')
            ->assertDontSee('Slider1')
            ->assertDontSee('Image 2');
    }

    public function test_admin_can_create_program_category(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/program-categories', [
                'name' => 'Online Bachelor',
                'slug' => 'online-bachelor',
                'status' => 1,
            ])
            ->assertRedirect('/admin/program-categories');

        $this->assertDatabaseHas('program_categories', [
            'name' => 'Online Bachelor',
            'slug' => 'online-bachelor',
            'status' => 1,
        ]);
    }

    public function test_admin_can_create_program(): void
    {
        $university = University::create([
            'name' => 'Demo University',
            'slug' => 'demo-university',
            'status' => true,
        ]);

        $category = ProgramCategory::create([
            'name' => 'Online Bachelor',
            'slug' => 'online-bachelor',
            'status' => true,
        ]);

        $this->actingAs($this->admin())
            ->post('/admin/programs', [
                'degree_id' => $category->id,
                'university_id' => $university->id,
                'type' => 'Online',
                'program' => 'Bachelor of Business',
                'short_name' => 'BBA',
                'short_description' => 'Short program description',
                'long_description' => '<p>Long program description</p>',
                'overview_title' => 'Program Overview',
                'curriculum_title' => 'Curriculum Structure',
                'curriculum_description' => '<p>Curriculum admin content</p>',
                'eligibility_title' => 'Admissions Guidelines',
                'eligibility_description' => '<p>Eligibility admin content</p>',
                'documents_required' => '<ul><li>Transcript</li></ul>',
                'fees_title' => 'Tuition Details',
                'fees_description' => '<p>Fees admin content</p>',
                'scholarship_title' => 'Scholarship Options',
                'scholarship_description' => 'Installments available.',
                'outcomes_title' => 'Career Outcomes',
                'outcomes_description' => '<p>Outcomes admin content</p>',
                'slug' => 'bachelor-of-business',
                'total_fee' => '12000',
                'yearly' => '4000',
                'duration' => '3 Years',
                'delivery_mode' => '100% Online',
                'link' => 'https://example.com/program',
                'advisor_title' => 'Request Counseling',
                'advisor_description' => 'Advisor admin content.',
                'apply_button_text' => 'Apply Now',
                'status' => 1,
                'recommend' => 1,
                'meta_title' => 'Bachelor of Business',
                'meta_description' => 'Program meta description',
                'keywords' => 'business, bachelor',
                'canonical_url' => 'https://example.com/program',
                'author' => 'Admin',
                'publisher' => 'eDegree',
            ])
            ->assertRedirect('/admin/programs');

        $this->assertDatabaseHas('programs', [
            'program' => 'Bachelor of Business',
            'slug' => 'bachelor-of-business',
            'degree_id' => $category->id,
            'university_id' => $university->id,
            'overview_title' => 'Program Overview',
            'curriculum_title' => 'Curriculum Structure',
            'advisor_title' => 'Request Counseling',
            'status' => 1,
            'recommend' => 1,
        ]);
    }

    public function test_program_form_has_frontend_content_fields(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/programs/create')
            ->assertOk()
            ->assertSee('Program Image')
            ->assertSee('Overview Title')
            ->assertSee('Curriculum Description')
            ->assertSee('Eligibility Description')
            ->assertSee('Documents Required')
            ->assertSee('Fees Description')
            ->assertSee('Outcomes Description')
            ->assertSee('Inquiry Form Title')
            ->assertSee('Apply Button Text');
    }

    public function test_admin_sidebar_shows_university_and_program_menus(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/programs')
            ->assertOk()
            ->assertSee('Universities')
            ->assertSee('Programs')
            ->assertSee('Categories');
    }

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }
}
