<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BlogPostController extends Controller
{
    public function index()
    {
        return view('admin.crud.index', [
            'title' => 'Blog Posts',
            'routeBase' => '/admin/blog-posts',
            'records' => BlogPost::with('category')->latest()->paginate(10),
            'columns' => ['id' => 'ID', 'title' => 'Title', 'category.name' => 'Category', 'author' => 'Author', 'published_at' => 'Published', 'status' => 'Status'],
        ]);
    }

    public function create()
    {
        return $this->form(new BlogPost(['status' => 'draft', 'published_at' => now()]), 'Create Blog Post');
    }

    public function store(Request $request)
    {
        BlogPost::create($this->prepareData($request));

        return redirect('/admin/blog-posts')->with('success', 'Blog post created successfully.');
    }

    public function show(BlogPost $blogPost)
    {
        $blogPost->load('category');

        return view('admin.crud.show', ['title' => 'Blog Post Details', 'routeBase' => '/admin/blog-posts', 'record' => $blogPost]);
    }

    public function edit(BlogPost $blogPost)
    {
        return $this->form($blogPost, 'Edit Blog Post');
    }

    public function update(Request $request, BlogPost $blogPost)
    {
        $blogPost->update($this->prepareData($request, $blogPost));

        return redirect('/admin/blog-posts')->with('success', 'Blog post updated successfully.');
    }

    public function destroy(BlogPost $blogPost)
    {
        $this->deleteUpload($blogPost->image);
        $this->deleteUpload($blogPost->meta_image);
        $blogPost->delete();

        return redirect('/admin/blog-posts')->with('success', 'Blog post deleted successfully.');
    }

    private function form(BlogPost $record, string $title)
    {
        return view('admin.crud.form-page', ['title' => $title, 'routeBase' => '/admin/blog-posts', 'record' => $record, 'fields' => $this->fields()]);
    }

    private function validated(Request $request, ?BlogPost $blogPost = null): array
    {
        return $request->validate([
            'blog_category_id' => ['nullable', 'exists:blog_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('blog_posts')->ignore($blogPost)],
            'image' => ['nullable', 'image', 'max:2048'],
            'short_description' => ['nullable', 'string'],
            'long_description' => ['required', 'string'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'meta_image' => ['nullable', 'image', 'max:2048'],
            'author' => ['nullable', 'string', 'max:255'],
            'publisher' => ['nullable', 'string', 'max:255'],
            'copyright' => ['nullable', 'string', 'max:255'],
            'site_name' => ['nullable', 'string', 'max:255'],
            'keywords' => ['nullable', 'string'],
            'robots' => ['nullable', 'string', 'max:255'],
            'canonical_url' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['draft', 'published', 'archived'])],
            'published_at' => ['nullable', 'date'],
        ]);
    }

    private function prepareData(Request $request, ?BlogPost $blogPost = null): array
    {
        $data = $this->validated($request, $blogPost);
        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);

        foreach (['image', 'meta_image'] as $field) {
            if ($request->hasFile($field)) {
                if ($blogPost) {
                    $this->deleteUpload($blogPost->{$field});
                }

                $file = $request->file($field);
                $filename = $field.'-'.time().'-'.uniqid().'.'.$file->getClientOriginalExtension();
                File::ensureDirectoryExists(public_path('uploads/blog-posts'));
                $file->move(public_path('uploads/blog-posts'), $filename);
                $data[$field] = 'uploads/blog-posts/'.$filename;
            } elseif ($blogPost) {
                unset($data[$field]);
            }
        }

        $data['author_name'] = $data['author'] ?: 'Admin';
        $data['excerpt'] = $data['short_description'] ?: ($data['description'] ?: Str::limit(strip_tags($data['long_description']), 160, ''));
        $data['content'] = $data['long_description'];
        $data['featured_image_path'] = $data['image'] ?? $blogPost?->image;
        $data['tags'] = $data['keywords'];
        $data['is_published'] = $data['status'] === 'published';
        $data['published_at'] = $data['is_published']
            ? ($data['published_at'] ?: $blogPost?->published_at ?: now())
            : null;
        $data['show_on_home'] = false;

        return $data;
    }

    private function fields(): array
    {
        return [
            ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true, 'col' => 6],
            ['name' => 'slug', 'label' => 'Slug', 'type' => 'text', 'col' => 6],
            ['name' => 'blog_category_id', 'label' => 'Category', 'type' => 'select', 'options' => BlogCategory::orderBy('name')->pluck('name', 'id')->toArray(), 'col' => 6],
            ['name' => 'image', 'label' => 'Image', 'type' => 'file', 'accept' => 'image/*', 'col' => 6],
            ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'required' => true, 'options' => ['draft' => 'Draft', 'published' => 'Published', 'archived' => 'Archived'], 'col' => 6],
            ['name' => 'published_at', 'label' => 'Published At', 'type' => 'datetime-local', 'col' => 6],
            ['name' => 'short_description', 'label' => 'Short Description', 'type' => 'textarea', 'rows' => 3, 'col' => 12],
            ['name' => 'long_description', 'label' => 'Long Description', 'type' => 'summernote', 'required' => true, 'col' => 12],
            ['name' => 'seo_title', 'label' => 'SEO Title', 'type' => 'text', 'col' => 6],
            ['name' => 'seo_description', 'label' => 'SEO Description', 'type' => 'textarea', 'rows' => 3, 'col' => 6],
            ['name' => 'meta_title', 'label' => 'Meta Title', 'type' => 'text', 'col' => 6],
            ['name' => 'meta_image', 'label' => 'Meta Image', 'type' => 'file', 'accept' => 'image/*', 'col' => 6],
            ['name' => 'meta_description', 'label' => 'Meta Description', 'type' => 'textarea', 'rows' => 3, 'col' => 12],
            ['name' => 'author', 'label' => 'Author', 'type' => 'text', 'col' => 6],
            ['name' => 'publisher', 'label' => 'Publisher', 'type' => 'text', 'col' => 6],
            ['name' => 'copyright', 'label' => 'Copyright', 'type' => 'text', 'col' => 6],
            ['name' => 'site_name', 'label' => 'Site Name', 'type' => 'text', 'col' => 6],
            ['name' => 'keywords', 'label' => 'Keywords', 'type' => 'textarea', 'rows' => 3, 'col' => 6],
            ['name' => 'robots', 'label' => 'Robots', 'type' => 'text', 'col' => 6],
            ['name' => 'canonical_url', 'label' => 'Canonical URL', 'type' => 'url', 'col' => 6],
            ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'rows' => 3, 'col' => 6],
        ];
    }

    private function deleteUpload(?string $path): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
