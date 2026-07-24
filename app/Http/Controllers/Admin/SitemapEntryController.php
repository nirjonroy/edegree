<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SitemapEntry;
use App\Support\SitemapSync;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SitemapEntryController extends Controller
{
    public function index()
    {
        return view('admin.sitemap-entries.index', [
            'title' => 'Sitemap',
            'routeBase' => '/admin/sitemap-entries',
            'records' => SitemapEntry::orderByDesc('is_active')->orderByDesc('priority')->orderBy('url')->paginate(25),
        ]);
    }

    public function create()
    {
        return $this->form(new SitemapEntry(['is_active' => true, 'changefreq' => 'weekly', 'priority' => 0.5]), 'Add Sitemap Entry');
    }

    public function store(Request $request)
    {
        SitemapEntry::create($this->validated($request));

        return redirect('/admin/sitemap-entries')->with('success', 'Sitemap entry created successfully.');
    }

    public function show(SitemapEntry $sitemapEntry)
    {
        return view('admin.crud.show', [
            'title' => 'Sitemap Entry Details',
            'routeBase' => '/admin/sitemap-entries',
            'record' => $sitemapEntry,
        ]);
    }

    public function edit(SitemapEntry $sitemapEntry)
    {
        return $this->form($sitemapEntry, 'Edit Sitemap Entry');
    }

    public function update(Request $request, SitemapEntry $sitemapEntry)
    {
        $sitemapEntry->update($this->validated($request, $sitemapEntry));

        return redirect('/admin/sitemap-entries')->with('success', 'Sitemap entry updated successfully.');
    }

    public function destroy(SitemapEntry $sitemapEntry)
    {
        $sitemapEntry->delete();

        return redirect('/admin/sitemap-entries')->with('success', 'Sitemap entry deleted successfully.');
    }

    public function sync()
    {
        $count = SitemapSync::sync();

        return redirect('/admin/sitemap-entries')->with('success', $count.' sitemap entries synced successfully.');
    }

    private function form(SitemapEntry $record, string $title)
    {
        return view('admin.crud.form-page', [
            'title' => $title,
            'routeBase' => '/admin/sitemap-entries',
            'record' => $record,
            'fields' => $this->fields(),
        ]);
    }

    private function validated(Request $request, ?SitemapEntry $sitemapEntry = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'url' => ['required', 'string', 'max:255', Rule::unique('sitemap_entries')->ignore($sitemapEntry)],
            'changefreq' => ['required', Rule::in(array_keys(SitemapEntry::CHANGEFREQ_OPTIONS))],
            'priority' => ['required', 'numeric', 'min:0', 'max:1'],
            'lastmod' => ['nullable', 'date'],
            'is_active' => ['boolean'],
        ]);
    }

    private function fields(): array
    {
        return [
            ['name' => 'title', 'label' => 'Page Title', 'type' => 'text', 'required' => true, 'col' => 6],
            ['name' => 'url', 'label' => 'URL Path', 'type' => 'text', 'required' => true, 'col' => 6],
            ['name' => 'changefreq', 'label' => 'Change Frequency', 'type' => 'select', 'options' => SitemapEntry::CHANGEFREQ_OPTIONS, 'required' => true, 'col' => 4],
            ['name' => 'priority', 'label' => 'Priority', 'type' => 'text', 'required' => true, 'col' => 4],
            ['name' => 'lastmod', 'label' => 'Last Modified', 'type' => 'datetime-local', 'col' => 4],
            ['name' => 'is_active', 'label' => 'Include in sitemap.xml', 'type' => 'checkbox', 'col' => 12],
        ];
    }
}
