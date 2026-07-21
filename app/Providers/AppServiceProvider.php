<?php

namespace App\Providers;

use App\Models\Siteinfo;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('admin.*', function ($view) {
            $siteinfo = Siteinfo::latest()->first();

            $view->with([
                'sidebarMenu' => $view->getData()['sidebarMenu'] ?? $this->adminSidebarMenu(),
                'adminBrand' => $view->getData()['adminBrand'] ?? [
                    'logo' => $siteinfo?->logo,
                    'large' => $siteinfo?->sidebar_lg_header ?: 'eDegree+',
                    'small' => $siteinfo?->sidebar_sm_header ?: 'eD+',
                ],
                'messages' => $view->getData()['messages'] ?? $this->adminMessages(),
                'notifications' => $view->getData()['notifications'] ?? $this->adminNotifications(),
                'notificationCount' => $view->getData()['notificationCount'] ?? 15,
            ]);
        });
    }

    private function adminSidebarMenu(): array
    {
        return [
            [
                'label' => 'Dashboard',
                'url' => '/admin/dashboard',
                'icon' => 'bi-speedometer',
                'active' => request()->is('admin/dashboard'),
            ],
            ['label' => 'About', 'url' => '/admin/abouts', 'icon' => 'bi-info-circle-fill', 'active' => request()->is('admin/abouts*')],
            ['label' => 'Site Info', 'url' => '/admin/siteinfo', 'icon' => 'bi-gear-fill', 'active' => request()->is('admin/siteinfo*')],
            ['label' => 'Custom Pages', 'url' => '/admin/custom-pages', 'icon' => 'bi-file-earmark-richtext', 'active' => request()->is('admin/custom-pages*')],
            ['label' => 'News', 'url' => '/admin/news', 'icon' => 'bi-newspaper', 'active' => request()->is('admin/news*')],
            ['label' => 'Universities', 'url' => '/admin/universities', 'icon' => 'bi-buildings', 'active' => request()->is('admin/universities*')],
            [
                'label' => 'Programs',
                'url' => '#',
                'icon' => 'bi-mortarboard',
                'open' => request()->is('admin/program*'),
                'children' => [
                    ['label' => 'Categories', 'url' => '/admin/program-categories', 'active' => request()->is('admin/program-categories*')],
                    ['label' => 'Programs', 'url' => '/admin/programs', 'active' => request()->is('admin/programs*')],
                ],
            ],
            [
                'label' => 'Blog',
                'url' => '#',
                'icon' => 'bi-journal-text',
                'open' => request()->is('admin/blog-*'),
                'children' => [
                    ['label' => 'Categories', 'url' => '/admin/blog-categories', 'active' => request()->is('admin/blog-categories*')],
                    ['label' => 'Posts', 'url' => '/admin/blog-posts', 'active' => request()->is('admin/blog-posts*')],
                    ['label' => 'Comments', 'url' => '/admin/blog-comments', 'active' => request()->is('admin/blog-comments*')],
                    ['label' => 'Pages', 'url' => '/admin/blog-pages', 'active' => request()->is('admin/blog-pages*')],
                ],
            ],
        ];
    }

    private function adminMessages(): array
    {
        return [
            [
                'name' => 'Brad Diesel',
                'message' => 'Call me whenever you can...',
                'time' => '4 Hours Ago',
                'avatar' => '/adminlte/assets/img/user1-128x128.jpg',
                'star' => 'text-danger',
                'url' => '#',
            ],
            [
                'name' => 'John Pierce',
                'message' => 'I got your message bro',
                'time' => '4 Hours Ago',
                'avatar' => '/adminlte/assets/img/user8-128x128.jpg',
                'star' => 'text-secondary',
                'url' => '#',
            ],
            [
                'name' => 'Nora Silvester',
                'message' => 'The subject goes here',
                'time' => '4 Hours Ago',
                'avatar' => '/adminlte/assets/img/user3-128x128.jpg',
                'star' => 'text-warning',
                'url' => '#',
            ],
        ];
    }

    private function adminNotifications(): array
    {
        return [
            ['icon' => 'bi-envelope', 'label' => '4 new messages', 'time' => '3 mins'],
            ['icon' => 'bi-people-fill', 'label' => '8 friend requests', 'time' => '12 hours'],
            ['icon' => 'bi-file-earmark-fill', 'label' => '3 new reports', 'time' => '2 days'],
        ];
    }
}
