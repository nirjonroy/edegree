<?php

namespace App\Http\Controllers;

use App\Models\HomeSection;
use App\Models\SitemapEntry;
use Illuminate\Support\Facades\Schema;
use Nirjon\LaravelSeo\Models\SeoGeneratedPage;

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

    public function pageforge()
    {
        $pages = collect();

        if (Schema::hasTable('nirjon_seo_generated_pages')) {
            $pages = SeoGeneratedPage::query()
                ->select(['url_slug', 'updated_at'])
                ->orderBy('url_slug')
                ->get();
        }

        return response()
            ->view('frontend.pageforge-sitemap', compact('pages'))
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
