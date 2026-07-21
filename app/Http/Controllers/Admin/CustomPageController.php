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
    public function index()
    {
        return view('admin.crud.index', [
            'title' => 'Custom Pages',
            'routeBase' => '/admin/custom-pages',
            'records' => CustomPage::latest()->paginate(10),
            'columns' => [
                'id' => 'ID',
                'page_name' => 'Page Name',
                'slug' => 'Slug',
                'status' => 'Status',
                'created_at' => 'Created',
            ],
        ]);
    }

    public function create()
    {
        return $this->form(new CustomPage(['status' => true]), 'Create Custom Page');
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
        $this->deleteUpload($customPage->meta_image);
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
            'description' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:255'],
            'meta_keywords' => ['nullable', 'string'],
            'canonical_url' => ['nullable', 'string', 'max:255'],
            'meta_robots' => ['nullable', 'string', 'max:255'],
            'meta_image' => ['nullable', 'image', 'max:2048'],
            'status' => ['nullable', 'boolean'],
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['page_name']);
        $data['status'] = (bool) ($data['status'] ?? false);

        if ($request->hasFile('meta_image')) {
            if ($customPage) {
                $this->deleteUpload($customPage->meta_image);
            }

            $file = $request->file('meta_image');
            $filename = 'meta-image-'.time().'-'.uniqid().'.'.$file->getClientOriginalExtension();
            File::ensureDirectoryExists(public_path('uploads/custom-pages'));
            $file->move(public_path('uploads/custom-pages'), $filename);
            $data['meta_image'] = 'uploads/custom-pages/'.$filename;
        } elseif ($customPage) {
            unset($data['meta_image']);
        }

        return $data;
    }

    private function fields(): array
    {
        return [
            ['name' => 'page_name', 'label' => 'Page Name', 'type' => 'text', 'required' => true, 'col' => 6],
            ['name' => 'slug', 'label' => 'Slug', 'type' => 'text', 'col' => 6],
            ['name' => 'description', 'label' => 'Description', 'type' => 'summernote', 'col' => 12],
            ['name' => 'meta_title', 'label' => 'Meta Title', 'type' => 'text', 'col' => 6],
            ['name' => 'meta_image', 'label' => 'Meta Image', 'type' => 'file', 'accept' => 'image/*', 'col' => 6],
            ['name' => 'meta_description', 'label' => 'Meta Description', 'type' => 'textarea', 'rows' => 3, 'col' => 6],
            ['name' => 'meta_keywords', 'label' => 'Meta Keywords', 'type' => 'textarea', 'rows' => 3, 'col' => 6],
            ['name' => 'canonical_url', 'label' => 'Canonical URL', 'type' => 'url', 'col' => 6],
            ['name' => 'meta_robots', 'label' => 'Meta Robots', 'type' => 'text', 'col' => 4],
            ['name' => 'status', 'label' => 'Status', 'type' => 'checkbox', 'col' => 2],
        ];
    }

    private function deleteUpload(?string $path): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
