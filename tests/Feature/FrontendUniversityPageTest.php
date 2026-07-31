<?php

namespace Tests\Feature;

use App\Models\University;
use Database\Seeders\UniversityDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FrontendUniversityPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_university_listing_is_dynamic(): void
    {
        $this->seed(UniversityDataSeeder::class);

        $response = $this->get('/universities');

        $response->assertOk();
        $response->assertSee('Partner Universities');
        $response->assertSee('London Metropolitan University');
        $response->assertSee('/universities/london-met');
    }

    public function test_university_search_and_profile_page_render(): void
    {
        $this->seed(UniversityDataSeeder::class);

        $this->get('/universities?query=London')
            ->assertOk()
            ->assertSee('London Metropolitan University')
            ->assertSee('London, United Kingdom');

        $this->get('/universities/london-met')
            ->assertOk()
            ->assertSee('London Metropolitan University')
            ->assertSee('Accredited Online Programs')
            ->assertSee('Global Master of Business Administration')
            ->assertSee('Admissions Guidelines')
            ->assertDontSee('University Profile');
    }

    public function test_legacy_university_static_url_redirects_to_dynamic_profile(): void
    {
        $this->seed(UniversityDataSeeder::class);

        $this->get('/frontend/university-single.html?id=london-met')
            ->assertRedirect('/universities/london-met');
    }

    public function test_university_accreditation_description_renders_html(): void
    {
        University::create([
            'name' => 'HTML Accreditation University',
            'slug' => 'html-accreditation-university',
            'status' => true,
            'long_description' => '<p>Long details should show on the program tab.</p>',
            'accreditation_title' => 'Internationally Recognized Accreditation',
            'accreditation_description' => '<p>All programs are officially accredited.</p>',
        ]);

        $this->get('/universities/html-accreditation-university')
            ->assertOk()
            ->assertSee('<p>Long details should show on the program tab.</p>', false)
            ->assertSee('<p>All programs are officially accredited.</p>', false)
            ->assertDontSee('&lt;p&gt;All programs are officially accredited.&lt;/p&gt;', false);
    }
}
