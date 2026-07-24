<?php

namespace Tests\Feature;

use App\Models\HomePartner;
use App\Models\HomeSection;
use App\Models\HomeTestimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AdminHomeContentCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_content_menus_are_available_in_admin_sidebar(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/dashboard')
            ->assertOk()
            ->assertSee('Home Content')
            ->assertSee('Testimonials')
            ->assertSee('Partners');
    }

    public function test_admin_can_create_home_section_testimonial_and_partner(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)
            ->post('/admin/home-sections', [
                'key' => 'testimonials',
                'title' => 'Learner Testimonials',
                'subtitle' => 'Dynamic section copy.',
                'status' => 1,
            ])
            ->assertRedirect('/admin/home-sections');

        $this->assertDatabaseHas('home_sections', [
            'key' => 'testimonials',
            'title' => 'Learner Testimonials',
        ]);

        $this->actingAs($admin)
            ->post('/admin/home-testimonials', [
                'name' => 'Test Student',
                'designation' => 'MBA Graduate',
                'quote' => 'This came from the admin panel.',
                'rating' => 5,
                'display_order' => 1,
                'status' => 1,
            ])
            ->assertRedirect('/admin/home-testimonials');

        $this->assertSame('Test Student', HomeTestimonial::first()->name);

        $this->actingAs($admin)
            ->post('/admin/home-partners', [
                'name' => 'Test University',
                'logo' => UploadedFile::fake()->image('partner.png', 200, 200),
                'link' => 'https://example.com',
                'display_order' => 1,
                'status' => 1,
            ])
            ->assertRedirect('/admin/home-partners');

        $partner = HomePartner::first();
        $this->assertSame('Test University', $partner->name);
        $this->assertStringStartsWith('uploads/home-partners/partner-', $partner->logo);
    }

    public function test_home_section_create_form_includes_subscribe_fields(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/home-sections/create')
            ->assertOk()
            ->assertSee('Input Placeholder')
            ->assertSee('Privacy Note')
            ->assertSee('Button Text');
    }

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }
}
