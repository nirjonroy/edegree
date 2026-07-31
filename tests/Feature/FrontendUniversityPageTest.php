<?php

namespace Tests\Feature;

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
}
