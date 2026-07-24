<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HasSeoFields;
use App\Http\Controllers\Controller;
use App\Models\BlogPage;
use Illuminate\Http\Request;

class BlogPageController extends Controller
{
    use HasSeoFields;

    public function index()
    {
        return view('admin.crud.index', [
            'title' => 'Blog Pages',
            'routeBase' => '/admin/blog-pages',
            'records' => BlogPage::latest()->paginate(10),
            'columns' => ['id' => 'ID', 'hero_title' => 'Hero Title', 'home_section_title' => 'Home Title', 'latest_posts_title' => 'Latest Posts'],
        ]);
    }

    public function create()
    {
        return $this->form(new BlogPage(), 'Create Blog Page');
    }

    public function store(Request $request)
    {
        BlogPage::create($this->validated($request));

        return redirect('/admin/blog-pages')->with('success', 'Blog page created successfully.');
    }

    public function show(BlogPage $blogPage)
    {
        return view('admin.crud.show', ['title' => 'Blog Page Details', 'routeBase' => '/admin/blog-pages', 'record' => $blogPage]);
    }

    public function edit(BlogPage $blogPage)
    {
        return $this->form($blogPage, 'Edit Blog Page');
    }

    public function update(Request $request, BlogPage $blogPage)
    {
        $blogPage->update($this->validated($request, $blogPage));

        return redirect('/admin/blog-pages')->with('success', 'Blog page updated successfully.');
    }

    public function destroy(BlogPage $blogPage)
    {
        $this->deleteSeoUpload($blogPage->meta_image);
        $blogPage->delete();

        return redirect('/admin/blog-pages')->with('success', 'Blog page deleted successfully.');
    }

    private function form(BlogPage $record, string $title)
    {
        return view('admin.crud.form-page', ['title' => $title, 'routeBase' => '/admin/blog-pages', 'record' => $record, 'fields' => $this->fields()]);
    }

    private function validated(Request $request, ?BlogPage $blogPage = null): array
    {
        $data = $request->validate(array_merge([
            'hero_title' => ['required', 'string', 'max:255'],
            'hero_background_path' => ['nullable', 'string', 'max:255'],
            'hero_background_source' => ['nullable', 'string', 'max:255'],
            'home_section_title' => ['nullable', 'string', 'max:255'],
            'categories_title' => ['nullable', 'string', 'max:255'],
            'recommendation_title' => ['nullable', 'string', 'max:255'],
            'latest_posts_title' => ['nullable', 'string', 'max:255'],
            'tags_title' => ['nullable', 'string', 'max:255'],
            'read_button_text' => ['nullable', 'string', 'max:255'],
            'article_tags_title' => ['nullable', 'string', 'max:255'],
            'comments_section_title' => ['nullable', 'string', 'max:255'],
        ], $this->seoValidationRules()));

        return $this->storeSeoUploads($request, $data, $blogPage, 'blog-pages');
    }

    private function fields(): array
    {
        return array_merge([
            ['name' => 'hero_title', 'label' => 'Hero Title', 'type' => 'text', 'required' => true, 'col' => 6],
            ['name' => 'hero_background_path', 'label' => 'Hero Background Path', 'type' => 'text', 'col' => 6],
            ['name' => 'hero_background_source', 'label' => 'Hero Background Source', 'type' => 'text', 'col' => 6],
            ['name' => 'home_section_title', 'label' => 'Home Section Title', 'type' => 'text', 'col' => 6],
            ['name' => 'categories_title', 'label' => 'Categories Title', 'type' => 'text', 'col' => 6],
            ['name' => 'recommendation_title', 'label' => 'Recommendation Title', 'type' => 'text', 'col' => 6],
            ['name' => 'latest_posts_title', 'label' => 'Latest Posts Title', 'type' => 'text', 'col' => 6],
            ['name' => 'tags_title', 'label' => 'Tags Title', 'type' => 'text', 'col' => 6],
            ['name' => 'read_button_text', 'label' => 'Read Button Text', 'type' => 'text', 'col' => 6],
            ['name' => 'article_tags_title', 'label' => 'Article Tags Title', 'type' => 'text', 'col' => 6],
            ['name' => 'comments_section_title', 'label' => 'Comments Section Title', 'type' => 'text', 'col' => 6],
        ], $this->seoFields());
    }
}
