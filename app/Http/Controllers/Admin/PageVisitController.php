<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageVisit;

class PageVisitController extends Controller
{
    public function index()
    {
        return view('admin.crud.index', [
            'title' => 'Page Visits',
            'routeBase' => '/admin/page-visits',
            'records' => PageVisit::with('user')->latest('visited_at')->paginate(25),
            'columns' => [
                'id' => 'ID',
                'path' => 'Page',
                'ip_address' => 'IP Address',
                'mac_address' => 'MAC Address',
                'user.email' => 'User',
                'visited_at' => 'Visited At',
            ],
            'canCreate' => false,
            'canEdit' => false,
            'canDelete' => false,
        ]);
    }

    public function show(PageVisit $pageVisit)
    {
        $pageVisit->load('user');

        return view('admin.crud.show', [
            'title' => 'Page Visit Details',
            'routeBase' => '/admin/page-visits',
            'record' => $pageVisit,
            'canEdit' => false,
        ]);
    }
}
