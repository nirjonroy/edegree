<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageVisit;
use Illuminate\Support\Facades\DB;

class PageVisitController extends Controller
{
    public function index()
    {
        $uniqueVisitorExpression = PageVisit::uniqueVisitorExpression();

        return view('admin.page-visits.index', [
            'title' => 'Page Visits',
            'routeBase' => '/admin/page-visits',
            'pageSummaries' => PageVisit::frontend()
                ->select(
                    'path',
                    DB::raw('COUNT(*) as total_visits'),
                    DB::raw('COUNT(DISTINCT '.$uniqueVisitorExpression.') as unique_users'),
                    DB::raw('MAX(visited_at) as last_visited_at')
                )
                ->groupBy('path')
                ->orderByDesc('total_visits')
                ->paginate(15, ['*'], 'pages'),
            'records' => PageVisit::frontend()->with('user')->latest('visited_at')->paginate(25, ['*'], 'visits'),
        ]);
    }

    public function show(PageVisit $pageVisit)
    {
        abort_unless($pageVisit->is_frontend, 404);

        $pageVisit->load('user');

        return view('admin.crud.show', [
            'title' => 'Page Visit Details',
            'routeBase' => '/admin/page-visits',
            'record' => $pageVisit,
            'canEdit' => false,
        ]);
    }
}
