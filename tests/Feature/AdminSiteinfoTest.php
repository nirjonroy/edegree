<?php

namespace Tests\Feature;

use App\Models\Siteinfo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AdminSiteinfoTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_siteinfo_index(): void
    {
        $admin = $this->admin();
        Siteinfo::create($this->payload(['sidebar_lg_header' => 'eDegree+']));

        $response = $this->actingAs($admin)
            ->get('/admin/siteinfo')
            ->assertOk()
            ->assertSee('Site Info Records');

        $content = $response->getContent();

        $this->assertStringNotContainsString('Add Site Info', $content);
        $this->assertStringContainsString('bi-eye', $content);
        $this->assertStringContainsString('bi-pencil-square', $content);
        $this->assertStringNotContainsString('bi-trash', $content);
    }

    public function test_admin_can_create_update_and_delete_siteinfo(): void
    {
        $admin = $this->admin();

        $payload = $this->payload([
            'sidebar_lg_header' => 'eDegree',
            'contact_email' => 'admin@example.com',
            'google_site_verification' => 'verify-token',
            'head_scripts' => '<script>window.analyticsLoaded = true;</script>',
        ]);

        $this->actingAs($admin)
            ->post('/admin/siteinfo', $payload)
            ->assertRedirect('/admin/siteinfo');

        $siteinfo = Siteinfo::first();
        $this->assertSame('eDegree', $siteinfo->sidebar_lg_header);
        $this->assertSame('admin@example.com', $siteinfo->contact_email);
        $this->assertSame('verify-token', $siteinfo->google_site_verification);

        $this->actingAs($admin)
            ->put('/admin/siteinfo/'.$siteinfo->id, $this->payload([
                'sidebar_lg_header' => 'Updated eDegree',
                'contact_email' => 'updated@example.com',
            ]))
            ->assertRedirect('/admin/siteinfo');

        $this->assertDatabaseHas('siteinfo', [
            'id' => $siteinfo->id,
            'sidebar_lg_header' => 'Updated eDegree',
            'contact_email' => 'updated@example.com',
        ]);

        $this->actingAs($admin)
            ->delete('/admin/siteinfo/'.$siteinfo->id)
            ->assertRedirect('/admin/siteinfo');

        $this->assertDatabaseMissing('siteinfo', ['id' => $siteinfo->id]);
    }

    public function test_siteinfo_form_only_shows_relevant_project_options(): void
    {
        $response = $this->actingAs($this->admin())
            ->get('/admin/siteinfo/create')
            ->assertOk();

        $content = $response->getContent();

        $this->assertStringContainsString('Tracking & Verification Scripts', $content);
        $this->assertStringContainsString('Google Search Console Verification', $content);
        $this->assertStringContainsString('Head Scripts', $content);
        $this->assertStringContainsString('Default Meta Image', $content);
        $this->assertStringNotContainsString('Body Start Scripts', $content);
        $this->assertStringNotContainsString('Footer Scripts', $content);
        $this->assertStringNotContainsString('Currency Rate', $content);
        $this->assertStringNotContainsString('Property Image Width', $content);
        $this->assertStringNotContainsString('Agency Logo Width', $content);
    }

    public function test_siteinfo_scripts_and_contact_data_render_on_frontend(): void
    {
        Siteinfo::create($this->payload([
            'contact_email' => 'support@example.com',
            'topbar_phone' => '+1 555 123 4567',
            'google_site_verification' => 'google-token',
            'head_scripts' => '<script>window.headScriptOk = true;</script>',
        ]));

        $this->get('/')
            ->assertOk()
            ->assertSee('<meta name="google-site-verification" content="google-token">', false)
            ->assertSee('<script>window.headScriptOk = true;</script>', false)
            ->assertSee('support@example.com')
            ->assertSee('+1 555 123 4567');
    }

    public function test_admin_can_upload_default_meta_image_for_siteinfo(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/siteinfo', $this->payload([
                'default_meta_image' => UploadedFile::fake()->createWithContent(
                    'default-meta.png',
                    base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+/p9sAAAAASUVORK5CYII=')
                ),
            ]))
            ->assertRedirect('/admin/siteinfo');

        $this->assertStringStartsWith('uploads/siteinfo/default_meta_image-', Siteinfo::first()->default_meta_image);
    }

    public function test_frontend_uses_siteinfo_default_meta_image_when_page_has_none(): void
    {
        Siteinfo::create($this->payload([
            'default_meta_image' => 'uploads/siteinfo/default-meta.jpg',
        ]));

        $this->get('/blog')
            ->assertOk()
            ->assertSee('<meta property="og:image" content="'.url('uploads/siteinfo/default-meta.jpg').'">', false)
            ->assertSee('<meta name="twitter:image" content="'.url('uploads/siteinfo/default-meta.jpg').'">', false);
    }

    private function admin(): User
    {
        return User::factory()->create([
            'is_admin' => true,
        ]);
    }

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'maintenance_mode' => 0,
            'enable_user_register' => 1,
            'phone_number_required' => 0,
            'enable_save_contact_message' => 1,
            'text_direction' => 'ltr',
            'default_theme' => 'light',
            'timezone' => 'UTC',
            'frontend_url' => 'https://example.com',
        ], $overrides);
    }
}
