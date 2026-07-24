<?php

namespace Tests\Feature;

use Database\Seeders\BlogDataSeeder;
use Database\Seeders\NewsDataSeeder;
use Database\Seeders\UniversityDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FrontendNewsPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_news_listing_is_dynamic(): void
    {
        $this->seed(UniversityDataSeeder::class);
        $this->seed(BlogDataSeeder::class);
        $this->seed(NewsDataSeeder::class);

        $this->get('/news')
            ->assertOk()
            ->assertSee('Admissions News')
            ->assertSee('US Department of Education Standardizes Higher Distance Education Assessments')
            ->assertSee('/news/us-dept-of-education-approves-online-standards');
    }

    public function test_news_single_page_renders_dynamic_content(): void
    {
        $this->seed(UniversityDataSeeder::class);
        $this->seed(BlogDataSeeder::class);
        $this->seed(NewsDataSeeder::class);

        $this->get('/news/us-dept-of-education-approves-online-standards')
            ->assertOk()
            ->assertSee('Policy Desk')
            ->assertSee('Standardized assessment is becoming')
            ->assertSee('Recent News');
    }

    public function test_legacy_news_static_urls_render_or_redirect_to_dynamic_pages(): void
    {
        $this->seed(UniversityDataSeeder::class);
        $this->seed(BlogDataSeeder::class);
        $this->seed(NewsDataSeeder::class);

        $this->get('/frontend/news.html')
            ->assertOk()
            ->assertSee('Admissions News')
            ->assertSee('Golden Gate University Expands Online Doctoral Research Cohorts');

        $this->get('/frontend/news-single.html?id=us-dept-of-education-approves-online-standards')
            ->assertRedirect('/news/us-dept-of-education-approves-online-standards');
    }
}
