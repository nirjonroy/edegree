<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HasSeoFields;
use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BlogCategoryController extends Controller
{
    use HasSeoFields;

    public function index()
    {
        return view('admin.crud.index', [
            'title' => 'Blog Categories',
            'routeBase' => '/admin/blog-categories',
            'records' => BlogCategory::orderBy('display_order')->latest()->paginate(10),
            'columns' => ['id' => 'ID', 'name' => 'Name', 'slug' => 'Slug', 'display_order' => 'Order', 'is_active' => 'Active'],
        ]);
    }

    public function create()
    {
        return $this->form(new BlogCategory(), 'Create Blog Category');
    }

    public function store(Request $request)
    {
        BlogCategory::create($this->validated($request));

        return redirect('/admin/blog-categories')->with('success', 'Blog category created successfully.');
    }

    public function show(BlogCategory $blogCategory)
    {
        return view('admin.crud.show', [
            'title' => 'Blog Category Details',
            'routeBase' => '/admin/blog-categories',
            'record' => $blogCategory,
        ]);
    }

    public function edit(BlogCategory $blogCategory)
    {
        return $this->form($blogCategory, 'Edit Blog Category');
    }

    public function update(Request $request, BlogCategory $blogCategory)
    {
        $blogCategory->update($this->validated($request, $blogCategory));

        return redirect('/admin/blog-categories')->with('success', 'Blog category updated successfully.');
    }

    public function destroy(BlogCategory $blogCategory)
    {
        $this->deleteSeoUpload($blogCategory->meta_image);
        $blogCategory->delete();

        return redirect('/admin/blog-categories')->with('success', 'Blog category deleted successfully.');
    }

    private function form(BlogCategory $record, string $title)
    {
        return view('admin.crud.form-page', [
            'title' => $title,
            'routeBase' => '/admin/blog-categories',
            'record' => $record,
            'fields' => $this->fields(),
        ]);
    }

    private function validated(Request $request, ?BlogCategory $blogCategory = null): array
    {
        $data = $request->validate(array_merge([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('blog_categories')->ignore($blogCategory)],
            'description' => ['nullable', 'string'],
            'display_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ], $this->seoValidationRules()));

        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['display_order'] = $data['display_order'] ?? 0;
        $data['is_active'] = (bool) ($data['is_active'] ?? false);

        return $this->storeSeoUploads($request, $data, $blogCategory, 'blog-categories');
    }

    private function fields(): array
    {
        return array_merge([
            ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'required' => true, 'col' => 6],
            ['name' => 'slug', 'label' => 'Slug', 'type' => 'text', 'col' => 6],
            ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'col' => 12],
            ['name' => 'display_order', 'label' => 'Display Order', 'type' => 'number', 'col' => 6],
            ['name' => 'is_active', 'label' => 'Active', 'type' => 'checkbox', 'col' => 6],
        ], $this->seoFields());
    }
}
