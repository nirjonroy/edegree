<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Request;
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
            'columns' => ['id' => 'ID', 'title' => 'Title', 'category.name' => 'Category', 'author_name' => 'Author', 'is_published' => 'Published', 'show_on_home' => 'Home'],
        ]);
    }

    public function create()
    {
        return $this->form(new BlogPost(['is_published' => false, 'show_on_home' => false]), 'Create Blog Post');
    }

    public function store(Request $request)
    {
        BlogPost::create($this->validated($request));

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
        $blogPost->update($this->validated($request, $blogPost));

        return redirect('/admin/blog-posts')->with('success', 'Blog post updated successfully.');
    }

    public function destroy(BlogPost $blogPost)
    {
        $blogPost->delete();

        return redirect('/admin/blog-posts')->with('success', 'Blog post deleted successfully.');
    }

    private function form(BlogPost $record, string $title)
    {
        return view('admin.crud.form-page', ['title' => $title, 'routeBase' => '/admin/blog-posts', 'record' => $record, 'fields' => $this->fields()]);
    }

    private function validated(Request $request, ?BlogPost $blogPost = null): array
    {
        $data = $request->validate([
            'blog_category_id' => ['nullable', 'exists:blog_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('blog_posts')->ignore($blogPost)],
            'author_name' => ['required', 'string', 'max:255'],
            'excerpt' => ['required', 'string'],
            'content' => ['required', 'string'],
            'quote' => ['nullable', 'string'],
            'featured_image_path' => ['nullable', 'string', 'max:255'],
            'featured_image_source' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:255'],
            'tags' => ['nullable', 'string'],
            'comments' => ['nullable', 'string'],
            'published_at' => ['nullable', 'date'],
            'is_published' => ['nullable', 'boolean'],
            'show_on_home' => ['nullable', 'boolean'],
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);
        $data['is_published'] = (bool) ($data['is_published'] ?? false);
        $data['show_on_home'] = (bool) ($data['show_on_home'] ?? false);

        return $data;
    }

    private function fields(): array
    {
        return [
            ['name' => 'blog_category_id', 'label' => 'Category', 'type' => 'select', 'options' => BlogCategory::orderBy('name')->pluck('name', 'id')->toArray(), 'col' => 6],
            ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true, 'col' => 6],
            ['name' => 'slug', 'label' => 'Slug', 'type' => 'text', 'col' => 6],
            ['name' => 'author_name', 'label' => 'Author Name', 'type' => 'text', 'required' => true, 'col' => 6],
            ['name' => 'excerpt', 'label' => 'Excerpt', 'type' => 'textarea', 'required' => true, 'col' => 12],
            ['name' => 'content', 'label' => 'Content', 'type' => 'textarea', 'required' => true, 'col' => 12],
            ['name' => 'quote', 'label' => 'Quote', 'type' => 'textarea', 'col' => 12],
            ['name' => 'featured_image_path', 'label' => 'Featured Image Path', 'type' => 'text', 'col' => 6],
            ['name' => 'featured_image_source', 'label' => 'Featured Image Source', 'type' => 'text', 'col' => 6],
            ['name' => 'meta_description', 'label' => 'Meta Description', 'type' => 'text', 'col' => 12],
            ['name' => 'tags', 'label' => 'Tags', 'type' => 'textarea', 'col' => 6],
            ['name' => 'comments', 'label' => 'Comments', 'type' => 'textarea', 'col' => 6],
            ['name' => 'published_at', 'label' => 'Published At', 'type' => 'datetime-local', 'col' => 4],
            ['name' => 'is_published', 'label' => 'Published', 'type' => 'checkbox', 'col' => 4],
            ['name' => 'show_on_home', 'label' => 'Show On Home', 'type' => 'checkbox', 'col' => 4],
        ];
    }
}
