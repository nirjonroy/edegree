<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class AdminMaintenanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_open_maintenance_page_from_sidebar(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Maintenance');

        $this->actingAs($admin)
            ->get(route('admin.maintenance.index'))
            ->assertOk()
            ->assertSee('Laravel Maintenance Commands')
            ->assertSee('Run Config Clear')
            ->assertSee('Run Cache Clear')
            ->assertSee('Run Route Clear')
            ->assertSee('Run View Clear')
            ->assertSee('Run Event Clear')
            ->assertSee('Run Compiled Clear')
            ->assertSee('Run Optimize Clear')
            ->assertSee('Run Config Cache')
            ->assertSee('Run Route Cache')
            ->assertSee('Run View Cache')
            ->assertSee('Run Optimize')
            ->assertSee('Run Storage Link')
            ->assertSee('Run Queue Restart')
            ->assertSee('Run All Clear Commands');
    }

    public function test_admin_can_run_clear_commands(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        foreach (['config:clear', 'cache:clear', 'route:clear', 'view:clear', 'event:clear', 'clear-compiled', 'optimize:clear'] as $command) {
            Artisan::shouldReceive('call')->once()->with($command)->andReturn(0);
        }

        $this->actingAs($admin)
            ->post(route('admin.maintenance.run'), ['action' => 'all_clear'])
            ->assertRedirect(route('admin.maintenance.index'))
            ->assertSessionHas('success', 'Command completed: config:clear, cache:clear, route:clear, view:clear, event:clear, clear-compiled, optimize:clear');
    }

    public function test_admin_can_run_single_build_command(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        Artisan::shouldReceive('call')->once()->with('route:cache')->andReturn(0);

        $this->actingAs($admin)
            ->post(route('admin.maintenance.run'), ['action' => 'route_cache'])
            ->assertRedirect(route('admin.maintenance.index'))
            ->assertSessionHas('success', 'Command completed: route:cache');
    }
}
