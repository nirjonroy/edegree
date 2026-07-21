<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class NewsController extends Controller
{
    private array $uploadFields = ['image', 'meta_image'];

    public function index()
    {
        return view('admin.crud.index', [
            'title' => 'News',
            'routeBase' => '/admin/news',
            'records' => News::latest()->paginate(10),
            'columns' => [
                'id' => 'ID',
                'title' => 'Title',
                'category' => 'Category',
                'author' => 'Author',
                'published_at' => 'Published',
                'status' => 'Status',
            ],
        ]);
    }

    public function create()
    {
        return $this->form(new News(['status' => true, 'published_at' => now()]), 'Create News');
    }

    public function store(Request $request)
    {
        News::create($this->prepareData($request));

        return redirect('/admin/news')->with('success', 'News created successfully.');
    }

    public function show(News $news)
    {
        return view('admin.crud.show', [
            'title' => 'News Details',
            'routeBase' => '/admin/news',
            'record' => $news,
        ]);
    }

    public function edit(News $news)
    {
        return $this->form($news, 'Edit News');
    }

    public function update(Request $request, News $news)
    {
        $news->update($this->prepareData($request, $news));

        return redirect('/admin/news')->with('success', 'News updated successfully.');
    }

    public function destroy(News $news)
    {
        foreach ($this->uploadFields as $field) {
            $this->deleteUpload($news->{$field});
        }

        $news->delete();

        return redirect('/admin/news')->with('success', 'News deleted successfully.');
    }

    private function form(News $record, string $title)
    {
        return view('admin.crud.form-page', [
            'title' => $title,
            'routeBase' => '/admin/news',
            'record' => $record,
            'fields' => $this->fields(),
        ]);
    }

    private function prepareData(Request $request, ?News $news = null): array
    {
        $data = $request->validate([
            'category' => ['nullable', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('news')->ignore($news)],
            'image' => ['nullable', 'image', 'max:2048'],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'quote' => ['nullable', 'string'],
            'author' => ['nullable', 'string', 'max:255'],
            'published_at' => ['nullable', 'date'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:255'],
            'meta_keywords' => ['nullable', 'string'],
            'canonical_url' => ['nullable', 'string', 'max:255'],
            'meta_robots' => ['nullable', 'string', 'max:255'],
            'meta_image' => ['nullable', 'image', 'max:2048'],
            'status' => ['nullable', 'boolean'],
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);
        $data['status'] = (bool) ($data['status'] ?? false);

        foreach ($this->uploadFields as $field) {
            if (! $request->hasFile($field)) {
                if ($news) {
                    unset($data[$field]);
                }

                continue;
            }

            if ($news) {
                $this->deleteUpload($news->{$field});
            }

            $file = $request->file($field);
            $filename = $field.'-'.time().'-'.uniqid().'.'.$file->getClientOriginalExtension();
            File::ensureDirectoryExists(public_path('uploads/news'));
            $file->move(public_path('uploads/news'), $filename);
            $data[$field] = 'uploads/news/'.$filename;
        }

        return $data;
    }

    private function fields(): array
    {
        return [
            ['name' => 'category', 'label' => 'Category', 'type' => 'text', 'col' => 4],
            ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true, 'col' => 8],
            ['name' => 'slug', 'label' => 'Slug', 'type' => 'text', 'col' => 6],
            ['name' => 'published_at', 'label' => 'Published At', 'type' => 'datetime-local', 'col' => 4],
            ['name' => 'status', 'label' => 'Status', 'type' => 'checkbox', 'col' => 2],
            ['name' => 'image', 'label' => 'Image', 'type' => 'file', 'accept' => 'image/*', 'col' => 6],
            ['name' => 'author', 'label' => 'Author', 'type' => 'text', 'col' => 6],
            ['name' => 'short_description', 'label' => 'Short Description', 'type' => 'textarea', 'rows' => 3, 'col' => 12],
            ['name' => 'description', 'label' => 'Description', 'type' => 'summernote', 'col' => 12],
            ['name' => 'quote', 'label' => 'Quote', 'type' => 'textarea', 'rows' => 3, 'col' => 12],
            ['name' => 'meta_title', 'label' => 'Meta Title', 'type' => 'text', 'col' => 6],
            ['name' => 'meta_image', 'label' => 'Meta Image', 'type' => 'file', 'accept' => 'image/*', 'col' => 6],
            ['name' => 'meta_description', 'label' => 'Meta Description', 'type' => 'textarea', 'rows' => 3, 'col' => 6],
            ['name' => 'meta_keywords', 'label' => 'Meta Keywords', 'type' => 'textarea', 'rows' => 3, 'col' => 6],
            ['name' => 'canonical_url', 'label' => 'Canonical URL', 'type' => 'url', 'col' => 6],
            ['name' => 'meta_robots', 'label' => 'Meta Robots', 'type' => 'text', 'col' => 6],
        ];
    }

    private function deleteUpload(?string $path): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
