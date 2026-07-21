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

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }
}
