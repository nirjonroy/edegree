<?php

namespace App\Http\Controllers;

use App\Models\HomeSection;
use App\Models\SitemapEntry;

class SitemapController extends Controller
{
    public function page()
    {
        $entries = SitemapEntry::where('is_active', true)
            ->orderByDesc('priority')
            ->orderBy('url')
            ->get()
            ->groupBy(fn (SitemapEntry $entry) => $entry->source_type ?: 'static');

        return view('frontend.sitemap-page', [
            'entries' => $entries,
            'subscribeSection' => HomeSection::where('key', 'subscribe')->where('status', true)->first(),
        ]);
    }

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
