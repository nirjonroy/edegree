<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;

class MaintenanceController extends Controller
{
    private const COMMANDS = [
        'config_clear' => [
            'command' => 'config:clear',
            'label' => 'Config Clear',
            'description' => 'Clear cached configuration files.',
            'icon' => 'bi-gear',
            'group' => 'clear',
        ],
        'cache_clear' => [
            'command' => 'cache:clear',
            'label' => 'Cache Clear',
            'description' => 'Flush the application cache store.',
            'icon' => 'bi-trash3',
            'group' => 'clear',
        ],
        'route_clear' => [
            'command' => 'route:clear',
            'label' => 'Route Clear',
            'description' => 'Remove the cached route file.',
            'icon' => 'bi-signpost-split',
            'group' => 'clear',
        ],
        'view_clear' => [
            'command' => 'view:clear',
            'label' => 'View Clear',
            'description' => 'Clear compiled Blade view files.',
            'icon' => 'bi-window',
            'group' => 'clear',
        ],
        'event_clear' => [
            'command' => 'event:clear',
            'label' => 'Event Clear',
            'description' => 'Clear cached events and listeners.',
            'icon' => 'bi-broadcast',
            'group' => 'clear',
        ],
        'compiled_clear' => [
            'command' => 'clear-compiled',
            'label' => 'Compiled Clear',
            'description' => 'Remove compiled framework classes.',
            'icon' => 'bi-file-earmark-x',
            'group' => 'clear',
        ],
        'optimize_clear' => [
            'command' => 'optimize:clear',
            'label' => 'Optimize Clear',
            'description' => 'Clear Laravel bootstrap cache files.',
            'icon' => 'bi-lightning-charge',
            'group' => 'clear',
        ],
        'config_cache' => [
            'command' => 'config:cache',
            'label' => 'Config Cache',
            'description' => 'Rebuild the configuration cache.',
            'icon' => 'bi-gear-wide-connected',
            'group' => 'build',
        ],
        'route_cache' => [
            'command' => 'route:cache',
            'label' => 'Route Cache',
            'description' => 'Rebuild the route cache.',
            'icon' => 'bi-diagram-3',
            'group' => 'build',
        ],
        'view_cache' => [
            'command' => 'view:cache',
            'label' => 'View Cache',
            'description' => 'Compile all Blade views.',
            'icon' => 'bi-window-stack',
            'group' => 'build',
        ],
        'optimize' => [
            'command' => 'optimize',
            'label' => 'Optimize',
            'description' => 'Cache framework bootstrap files.',
            'icon' => 'bi-speedometer2',
            'group' => 'build',
        ],
        'storage_link' => [
            'command' => 'storage:link',
            'label' => 'Storage Link',
            'description' => 'Create the public storage symlink.',
            'icon' => 'bi-link-45deg',
            'group' => 'utility',
        ],
        'queue_restart' => [
            'command' => 'queue:restart',
            'label' => 'Queue Restart',
            'description' => 'Restart queue workers after current jobs.',
            'icon' => 'bi-arrow-clockwise',
            'group' => 'utility',
        ],
    ];

    public function index(): View
    {
        return view('admin.maintenance.index', [
            'commands' => self::COMMANDS,
        ]);
    }

    public function run(Request $request): RedirectResponse
    {
        $actions = implode(',', array_merge(array_keys(self::COMMANDS), ['all_clear']));

        $action = $request->validate([
            'action' => ['required', 'string', 'in:'.$actions],
        ])['action'];

        $commands = $action === 'all_clear'
            ? array_filter(self::COMMANDS, fn (array $command) => $command['group'] === 'clear')
            : [$action => self::COMMANDS[$action]];

        $results = [];

        foreach ($commands as $command) {
            Artisan::call($command['command']);
            $results[] = $command['command'];
        }

        return redirect()
            ->route('admin.maintenance.index')
            ->with('success', 'Command completed: '.implode(', ', $results));
    }
}
