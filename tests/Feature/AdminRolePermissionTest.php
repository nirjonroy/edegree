<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminRolePermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_permission(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/permissions', [
                'name' => 'manage admissions',
                'guard_name' => 'web',
            ])
            ->assertRedirect('/admin/permissions');

        $this->assertDatabaseHas('permissions', [
            'name' => 'manage admissions',
            'guard_name' => 'web',
        ]);
    }

    public function test_admin_can_create_role_with_permissions(): void
    {
        $permission = Permission::create([
            'name' => 'manage reports',
            'guard_name' => 'web',
        ]);

        $this->actingAs($this->admin())
            ->post('/admin/roles', [
                'name' => 'Editor',
                'guard_name' => 'web',
                'permissions' => [$permission->id],
            ])
            ->assertRedirect('/admin/roles');

        $role = Role::where('name', 'Editor')->first();

        $this->assertTrue($role->hasPermissionTo('manage reports'));
    }

    public function test_admin_seed_assigns_super_admin_role(): void
    {
        $this->seed(AdminUserSeeder::class);

        $admin = User::where('email', 'admin24@gmail.com')->first();

        $this->assertTrue($admin->hasRole('Super Admin'));
        $this->assertTrue($admin->can('manage roles'));
    }

    public function test_access_control_menu_is_visible(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/roles')
            ->assertOk()
            ->assertSee('Access Control')
            ->assertSee('Roles')
            ->assertSee('Permissions');
    }

    public function test_admin_can_create_admin_user_with_role_and_direct_permission(): void
    {
        $role = Role::create(['name' => 'Manager', 'guard_name' => 'web']);
        $permission = Permission::create(['name' => 'manage analytics', 'guard_name' => 'web']);

        $this->actingAs($this->admin())
            ->post('/admin/admin-users', [
                'name' => 'Manager User',
                'email' => 'manager@example.com',
                'password' => '12345678',
                'roles' => [$role->id],
                'permissions' => [$permission->id],
            ])
            ->assertRedirect('/admin/admin-users');

        $user = User::where('email', 'manager@example.com')->first();

        $this->assertTrue($user->is_admin);
        $this->assertTrue($user->hasRole('Manager'));
        $this->assertTrue($user->hasDirectPermission('manage analytics'));
    }

    public function test_page_visits_are_tracked_and_visible_to_admin(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->get('/admin/dashboard')->assertOk();

        $this->assertDatabaseHas('page_visits', [
            'path' => '/admin/dashboard',
            'user_id' => $admin->id,
        ]);

        $this->actingAs($admin)
            ->get('/admin/page-visits')
            ->assertOk()
            ->assertSee('/admin/dashboard');
    }

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }
}
