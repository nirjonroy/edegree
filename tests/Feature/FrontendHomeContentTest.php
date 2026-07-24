<?php

namespace Tests\Feature;

use Database\Seeders\HomeContentSeeder;
use Database\Seeders\UniversityDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FrontendHomeContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_uses_dynamic_testimonials_partners_and_subscribe_content(): void
    {
        $this->seed(UniversityDataSeeder::class);
        $this->seed(HomeContentSeeder::class);

        $this->get('/')
            ->assertOk()
            ->assertSee('Learner Testimonials')
            ->assertSee('Dr. Sarah Chen')
            ->assertSee('Doctor of Business Administration Alum, GGU USA')
            ->assertSee('Our Partner Universities &amp; Accreditation Standards', false)
            ->assertSee('Stay Ahead in Your Career')
            ->assertSee('Subscribe Alerts');
    }
}
