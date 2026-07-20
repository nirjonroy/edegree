<?php

namespace Tests\Feature;

use App\Models\Siteinfo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSiteinfoTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_siteinfo_index(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)
            ->get('/admin/siteinfo')
            ->assertOk()
            ->assertSee('Site Info Records');
    }

    public function test_admin_can_create_update_and_delete_siteinfo(): void
    {
        $admin = $this->admin();

        $payload = $this->payload([
            'sidebar_lg_header' => 'eDegree',
            'contact_email' => 'admin@example.com',
        ]);

        $this->actingAs($admin)
            ->post('/admin/siteinfo', $payload)
            ->assertRedirect('/admin/siteinfo');

        $siteinfo = Siteinfo::first();
        $this->assertSame('eDegree', $siteinfo->sidebar_lg_header);
        $this->assertSame('admin@example.com', $siteinfo->contact_email);

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
            'image_output_format' => 'webp',
            'enable_user_register' => 1,
            'phone_number_required' => 0,
            'enable_subscription_notify' => 0,
            'enable_save_contact_message' => 1,
            'text_direction' => 'ltr',
            'default_theme' => 'light',
            'timezone' => 'UTC',
            'currency_rate' => 1,
            'frontend_url' => 'https://example.com',
        ], $overrides);
    }
}
