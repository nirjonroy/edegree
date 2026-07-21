<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_login_screen_can_be_rendered(): void
    {
        $this->get('/admin/login')->assertStatus(200);
    }

    public function test_admin_can_login_to_admin_dashboard(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin24@gmail.com',
            'password' => bcrypt('12345678'),
            'is_admin' => true,
        ]);

        $response = $this->post('/admin/login', [
            'email' => $admin->email,
            'password' => '12345678',
        ]);

        $this->assertAuthenticatedAs($admin);
        $response->assertRedirect(route('admin.dashboard'));

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('eDegree+')
            ->assertSee('small-box text-bg-primary', false)
            ->assertSee('Sales Value');
    }

    public function test_non_admin_cannot_login_through_admin_login(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('12345678'),
            'is_admin' => false,
        ]);

        $this->post('/admin/login', [
            'email' => $user->email,
            'password' => '12345678',
        ]);

        $this->assertGuest();
    }

    public function test_admin_can_logout_from_admin_panel(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->post(route('logout'));

        $this->assertGuest();
        $response->assertRedirect('/');
    }

    public function test_admin_sidebar_only_shows_project_menus(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Dashboard')
            ->assertSee('About')
            ->assertSee('Site Info')
            ->assertSee('Universities')
            ->assertSee('Programs')
            ->assertSee('Blog')
            ->assertDontSee('Theme Generate')
            ->assertDontSee('Widgets')
            ->assertDontSee('AdminLTE 4')
            ->assertDontSee('AdminLTE.io')
            ->assertDontSee('DOCUMENTATIONS');
    }
}
