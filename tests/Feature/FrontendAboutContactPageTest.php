<?php

namespace Tests\Feature;

use Database\Seeders\AboutContactPageSeeder;
use Database\Seeders\UniversityDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FrontendAboutContactPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_about_page_is_dynamic_from_admin_data(): void
    {
        $this->seed(UniversityDataSeeder::class);
        $this->seed(AboutContactPageSeeder::class);

        $this->get('/about')
            ->assertOk()
            ->assertSee('About eDegree+')
            ->assertSee('Our Institutional Profile')
            ->assertSee('Accredited Partners')
            ->assertSee('Are these degrees identical to traditional campus awards?');
    }

    public function test_contact_page_is_dynamic_from_admin_data(): void
    {
        $this->seed(UniversityDataSeeder::class);
        $this->seed(AboutContactPageSeeder::class);

        $this->get('/contact')
            ->assertOk()
            ->assertSee('Contact eDegree+')
            ->assertSee('support@edegreeplus.com')
            ->assertSee('Support Hotlines')
            ->assertSee('Submit Message');
    }

    public function test_legacy_static_about_and_contact_urls_redirect(): void
    {
        $this->get('/frontend/about.html')->assertRedirect('/about');
        $this->get('/frontend/contact.html')->assertRedirect('/contact');
    }
}
