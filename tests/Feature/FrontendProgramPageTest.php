<?php

namespace Tests\Feature;

use Database\Seeders\UniversityDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FrontendProgramPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_program_listing_is_dynamic(): void
    {
        $this->seed(UniversityDataSeeder::class);

        $this->get('/programs')
            ->assertOk()
            ->assertSee('Explore Degree Programs')
            ->assertSee('Global Master of Business Administration')
            ->assertSee('/programs/global-master-of-business-administration');
    }

    public function test_program_filters_and_profile_page_render(): void
    {
        $this->seed(UniversityDataSeeder::class);

        $this->get('/programs?degree=DBA')
            ->assertOk()
            ->assertSee('Doctor of Business Administration (DBA)');

        $this->get('/programs/global-master-of-business-administration')
            ->assertOk()
            ->assertSee('Global Master of Business Administration')
            ->assertSee('Program Overview')
            ->assertSee('Curriculum Structure')
            ->assertSee('Tuition Details')
            ->assertSee('Request Free Counseling');
    }

    public function test_legacy_program_static_urls_render_or_redirect_to_dynamic_pages(): void
    {
        $this->seed(UniversityDataSeeder::class);

        $this->get('/frontend/programs.html?degree=MBA')
            ->assertOk()
            ->assertSee('Explore Degree Programs')
            ->assertSee('Global Master of Business Administration');

        $this->get('/frontend/program-single.html?id=global-master-of-business-administration')
            ->assertRedirect('/programs/global-master-of-business-administration');
    }
}
