<?php

namespace App\Http\Controllers;

use App\Models\SitemapEntry;

class SitemapController extends Controller
{
    public function index()
    {
        $entries = SitemapEntry::where('is_active', true)
            ->orderByDesc('priority')
            ->orderBy('url')
            ->get();

        return response()
            ->view('frontend.sitemap', compact('entries'))
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
