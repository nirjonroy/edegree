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
}
