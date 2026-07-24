<?php

namespace Tests\Feature;

use Database\Seeders\CustomPageDataSeeder;
use Database\Seeders\UniversityDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FrontendCustomPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeded_custom_page_renders_on_desired_url(): void
    {
        $this->seed(UniversityDataSeeder::class);
        $this->seed(CustomPageDataSeeder::class);

        $this->get('/guides/buy-guide')
            ->assertOk()
            ->assertSee('Buy Guide')
            ->assertSee('How to Choose an Online Degree')
            ->assertSee('Compare online degree programs');
    }

    public function test_seeded_privacy_and_terms_pages_render_from_custom_pages(): void
    {
        $this->seed(CustomPageDataSeeder::class);

        $this->get('/privacy-policy')
            ->assertOk()
            ->assertSee('Privacy Policy')
            ->assertSee('Data Gathering Disclosures')
            ->assertSee('Read the privacy rules');

        $this->get('/terms')
            ->assertOk()
            ->assertSee('Terms of Service')
            ->assertSee('Marketplace Usage Guidelines')
            ->assertSee('online university degree marketplace');
    }

    public function test_legacy_policy_urls_redirect_to_dynamic_pages(): void
    {
        $this->get('/frontend/privacy-policy.html')->assertRedirect('/privacy-policy');
        $this->get('/frontend/terms.html')->assertRedirect('/terms');
    }

    public function test_draft_custom_page_is_not_public(): void
    {
        $this->seed(CustomPageDataSeeder::class);

        \App\Models\CustomPage::where('slug', 'buy-guide')->update(['status' => false]);

        $this->get('/guides/buy-guide')->assertNotFound();
    }
}
