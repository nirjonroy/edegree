<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\CustomPage;
use App\Models\News;
use App\Models\PageVisit;
use App\Models\Program;
use App\Models\Slider;
use App\Models\University;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $pageTitle = 'Dashboard';

        $breadcrumbs = [
            ['label' => 'Home', 'url' => '/admin/dashboard'],
            ['label' => 'Dashboard'],
        ];

        $uniqueVisitorExpression = PageVisit::uniqueVisitorExpression();
        $frontendVisits = PageVisit::frontend();

        $todayVisits = (clone $frontendVisits)->whereDate('visited_at', today())->count();
        $uniqueVisitors = (clone $frontendVisits)
            ->whereRaw($uniqueVisitorExpression.' IS NOT NULL')
            ->selectRaw('COUNT(DISTINCT '.$uniqueVisitorExpression.') as aggregate')
            ->value('aggregate');

        $stats = [
            [
                'value' => University::count(),
                'label' => 'Universities',
                'theme' => 'primary',
                'icon' => 'bi-buildings',
                'link' => '/admin/universities',
                'link_theme' => 'light',
            ],
            [
                'value' => Program::count(),
                'label' => 'Programs',
                'theme' => 'success',
                'icon' => 'bi-mortarboard-fill',
                'link' => '/admin/programs',
                'link_theme' => 'light',
            ],
            [
                'value' => User::where('is_admin', true)->count(),
                'label' => 'Admin Users',
                'theme' => 'warning',
                'icon' => 'bi-person-gear',
                'link' => '/admin/admin-users',
                'link_theme' => 'dark',
            ],
            [
                'value' => $uniqueVisitors,
                'label' => 'Unique Users',
                'theme' => 'danger',
                'icon' => 'bi-people-fill',
                'link' => '/admin/page-visits',
                'link_theme' => 'light',
            ],
        ];

        $visitsByDay = PageVisit::frontend()
            ->selectRaw('DATE(visited_at) as visit_date, COUNT(*) as total')
            ->where('visited_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('visit_date')
            ->orderBy('visit_date')
            ->pluck('total', 'visit_date');

        $categories = collect(range(6, 0))->map(fn ($daysAgo) => now()->subDays($daysAgo)->toDateString());

        $visitChart = [
            'series' => [
                [
                    'name' => 'Page Visits',
                    'data' => $categories->map(fn ($date) => (int) ($visitsByDay[$date] ?? 0))->values()->all(),
                ],
            ],
            'categories' => $categories->values()->all(),
            'colors' => ['#0d6efd'],
        ];

        $topPages = PageVisit::frontend()
            ->select('path', DB::raw('COUNT(*) as total'), DB::raw('COUNT(DISTINCT '.$uniqueVisitorExpression.') as unique_total'))
            ->groupBy('path')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $recentVisits = PageVisit::frontend()->with('user')->latest('visited_at')->limit(10)->get();

        $contentCounts = [
            ['label' => 'Blog Posts', 'value' => BlogPost::count(), 'url' => '/admin/blog-posts'],
            ['label' => 'News', 'value' => News::count(), 'url' => '/admin/news'],
            ['label' => 'Custom Pages', 'value' => CustomPage::count(), 'url' => '/admin/custom-pages'],
            ['label' => 'Sliders', 'value' => Slider::count(), 'url' => '/admin/sliders'],
            ['label' => 'Today Visits', 'value' => $todayVisits, 'url' => '/admin/page-visits'],
        ];

        return view('admin.dashboard', compact(
            'pageTitle',
            'breadcrumbs',
            'stats',
            'visitChart',
            'topPages',
            'recentVisits',
            'contentCounts'
        ));
    }
}
