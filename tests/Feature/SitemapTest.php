<?php

namespace Tests\Feature;

use App\Models\SitemapEntry;
use App\Models\User;
use Database\Seeders\SitemapEntrySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SitemapTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_sitemap_xml_contains_active_entries_only(): void
    {
        SitemapEntry::create([
            'title' => 'Home',
            'url' => '/',
            'changefreq' => 'daily',
            'priority' => 1.0,
            'lastmod' => now(),
            'is_active' => true,
        ]);

        SitemapEntry::create([
            'title' => 'Hidden Page',
            'url' => '/hidden',
            'changefreq' => 'monthly',
            'priority' => 0.3,
            'lastmod' => now(),
            'is_active' => false,
        ]);

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee('<urlset', false)
            ->assertSee('<loc>'.url('/').'</loc>', false)
            ->assertDontSee('/hidden');
    }

    public function test_generated_sitemap_filename_uses_admin_sitemap_entries(): void
    {
        SitemapEntry::create([
            'title' => 'Programs',
            'url' => '/programs',
            'changefreq' => 'daily',
            'priority' => 0.9,
            'lastmod' => now(),
            'is_active' => true,
        ]);

        SitemapEntry::create([
            'title' => 'Hidden Program',
            'url' => '/programs/hidden-program',
            'changefreq' => 'weekly',
            'priority' => 0.5,
            'lastmod' => now(),
            'is_active' => false,
        ]);

        $this->get('/program-sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee('<loc>'.url('/programs').'</loc>', false)
            ->assertDontSee('/programs/hidden-program')
            ->assertDontSee('master-london');
    }

    public function test_admin_can_create_and_sync_sitemap_entries(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->post('/admin/sitemap-entries', [
                'title' => 'Manual Page',
                'url' => '/manual-page',
                'changefreq' => 'weekly',
                'priority' => 0.5,
                'is_active' => true,
            ])
            ->assertRedirect('/admin/sitemap-entries');

        $this->assertDatabaseHas('sitemap_entries', [
            'title' => 'Manual Page',
            'url' => '/manual-page',
            'is_active' => true,
        ]);

        $this->actingAs($admin)
            ->post('/admin/sitemap-entries/sync')
            ->assertRedirect('/admin/sitemap-entries');

        $this->assertDatabaseHas('sitemap_entries', [
            'title' => 'Home',
            'url' => '/',
        ]);
    }

    public function test_sitemap_seeder_creates_base_frontend_entries(): void
    {
        $this->seed(SitemapEntrySeeder::class);

        $this->assertDatabaseHas('sitemap_entries', ['url' => '/']);
        $this->assertDatabaseHas('sitemap_entries', ['url' => '/programs']);
        $this->assertDatabaseHas('sitemap_entries', ['url' => '/universities']);
        $this->assertDatabaseHas('sitemap_entries', ['url' => '/sitemap']);
    }

    public function test_public_html_sitemap_renders_entries_from_admin_table(): void
    {
        SitemapEntry::create([
            'title' => 'Manual Page',
            'url' => '/manual-page',
            'source_type' => 'custom_page',
            'changefreq' => 'weekly',
            'priority' => 0.5,
            'lastmod' => now(),
            'is_active' => true,
        ]);

        SitemapEntry::create([
            'title' => 'Hidden Page',
            'url' => '/hidden-page',
            'source_type' => 'custom_page',
            'changefreq' => 'weekly',
            'priority' => 0.5,
            'lastmod' => now(),
            'is_active' => false,
        ]);

        $this->get('/sitemap')
            ->assertOk()
            ->assertSee('eDegree+ Site Index')
            ->assertSee('Manual Page')
            ->assertDontSee('Hidden Page');
    }

    public function test_legacy_sitemap_html_url_redirects_to_dynamic_page(): void
    {
        $this->get('/frontend/sitemap.html')->assertRedirect('/sitemap');
    }
}
