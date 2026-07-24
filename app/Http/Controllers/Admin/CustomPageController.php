<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CustomPageController extends Controller
{
    private array $uploadFields = ['background_image', 'meta_image'];

    public function index()
    {
        return view('admin.custom-pages.index', [
            'title' => 'Custom Pages',
            'routeBase' => '/admin/custom-pages',
            'records' => CustomPage::latest()->paginate(10),
        ]);
    }

    public function create()
    {
        return $this->form(new CustomPage(['status' => false, 'published_at' => now()]), 'Add Custom Page');
    }

    public function store(Request $request)
    {
        CustomPage::create($this->prepareData($request));

        return redirect('/admin/custom-pages')->with('success', 'Custom page created successfully.');
    }

    public function show(CustomPage $customPage)
    {
        return view('admin.crud.show', [
            'title' => 'Custom Page Details',
            'routeBase' => '/admin/custom-pages',
            'record' => $customPage,
        ]);
    }

    public function edit(CustomPage $customPage)
    {
        return $this->form($customPage, 'Edit Custom Page');
    }

    public function update(Request $request, CustomPage $customPage)
    {
        $customPage->update($this->prepareData($request, $customPage));

        return redirect('/admin/custom-pages')->with('success', 'Custom page updated successfully.');
    }

    public function destroy(CustomPage $customPage)
    {
        foreach ($this->uploadFields as $field) {
            $this->deleteUpload($customPage->{$field});
        }

        $customPage->delete();

        return redirect('/admin/custom-pages')->with('success', 'Custom page deleted successfully.');
    }

    private function form(CustomPage $record, string $title)
    {
        return view('admin.crud.form-page', [
            'title' => $title,
            'routeBase' => '/admin/custom-pages',
            'record' => $record,
            'fields' => $this->fields(),
        ]);
    }

    private function prepareData(Request $request, ?CustomPage $customPage = null): array
    {
        $data = $request->validate([
            'page_name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('custom_pages')->ignore($customPage)],
            'desired_url' => ['nullable', 'string', 'max:255', Rule::unique('custom_pages')->ignore($customPage)],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'background_image' => ['nullable', 'image', 'max:4096'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string'],
            'canonical_url' => ['nullable', 'string', 'max:255'],
            'meta_robots' => ['nullable', 'string', 'max:255'],
            'meta_image' => ['nullable', 'image', 'max:2048'],
            'author' => ['nullable', 'string', 'max:255'],
            'publisher' => ['nullable', 'string', 'max:255'],
            'copyright' => ['nullable', 'string', 'max:255'],
            'site_name' => ['nullable', 'string', 'max:255'],
            'keywords' => ['nullable', 'string'],
            'robots' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['page_name']);
        $data['slug'] = trim($data['slug'], '/');
        $data['desired_url'] = $this->normalizeDesiredUrl($data['desired_url'] ?? null);
        $data['status'] = (bool) ($data['status'] ?? false);

        foreach ($this->uploadFields as $field) {
            if (! $request->hasFile($field)) {
                if ($customPage) {
                    unset($data[$field]);
                }

                continue;
            }

            if ($customPage) {
                $this->deleteUpload($customPage->{$field});
            }

            $file = $request->file($field);
            $filename = str_replace('_', '-', $field).'-'.time().'-'.uniqid().'.'.$file->getClientOriginalExtension();
            File::ensureDirectoryExists(public_path('uploads/custom-pages'));
            $file->move(public_path('uploads/custom-pages'), $filename);
            $data[$field] = 'uploads/custom-pages/'.$filename;
        }

        return $data;
    }

    private function fields(): array
    {
        return [
            ['name' => 'page_name', 'label' => 'Page Name', 'type' => 'text', 'required' => true, 'col' => 6],
            ['name' => 'slug', 'label' => 'Slug', 'type' => 'text', 'col' => 6],
            ['name' => 'desired_url', 'label' => 'Desired URL', 'type' => 'text', 'col' => 12],
            ['name' => 'subtitle', 'label' => 'Subtitle', 'type' => 'text', 'col' => 6],
            ['name' => 'published_at', 'label' => 'Published At', 'type' => 'datetime-local', 'col' => 4],
            ['name' => 'status', 'label' => 'Published', 'type' => 'checkbox', 'col' => 2],
            ['name' => 'short_description', 'label' => 'Short Description', 'type' => 'textarea', 'rows' => 4, 'col' => 12],
            ['name' => 'description', 'label' => 'Page Content', 'type' => 'summernote', 'col' => 12],
            ['name' => 'background_image', 'label' => 'Background Image', 'type' => 'file', 'accept' => 'image/*', 'col' => 6],
            ['name' => 'seo_title', 'label' => 'SEO Title', 'type' => 'text', 'col' => 6],
            ['name' => 'seo_description', 'label' => 'SEO Description', 'type' => 'textarea', 'rows' => 3, 'col' => 6],
            ['name' => 'meta_title', 'label' => 'Meta Title', 'type' => 'text', 'col' => 6],
            ['name' => 'meta_image', 'label' => 'Meta Image', 'type' => 'file', 'accept' => 'image/*', 'col' => 6],
            ['name' => 'meta_description', 'label' => 'Meta Description', 'type' => 'textarea', 'rows' => 3, 'col' => 6],
            ['name' => 'meta_keywords', 'label' => 'Meta Keywords', 'type' => 'textarea', 'rows' => 3, 'col' => 6],
            ['name' => 'canonical_url', 'label' => 'Canonical URL', 'type' => 'url', 'col' => 6],
            ['name' => 'meta_robots', 'label' => 'Meta Robots', 'type' => 'text', 'col' => 4],
            ['name' => 'author', 'label' => 'Author', 'type' => 'text', 'col' => 6],
            ['name' => 'publisher', 'label' => 'Publisher', 'type' => 'text', 'col' => 6],
            ['name' => 'copyright', 'label' => 'Copyright', 'type' => 'text', 'col' => 6],
            ['name' => 'site_name', 'label' => 'Site Name', 'type' => 'text', 'col' => 6],
            ['name' => 'keywords', 'label' => 'Keywords', 'type' => 'textarea', 'rows' => 3, 'col' => 6],
            ['name' => 'robots', 'label' => 'Robots', 'type' => 'text', 'col' => 6],
        ];
    }

    private function normalizeDesiredUrl(?string $url): ?string
    {
        $url = trim((string) $url);

        if ($url === '') {
            return null;
        }

        return trim($url, '/');
    }

    private function deleteUpload(?string $path): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
