<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogComment;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Http\Request;

class BlogCommentController extends Controller
{
    public function index()
    {
        return view('admin.crud.index', [
            'title' => 'Blog Comments',
            'routeBase' => '/admin/blog-comments',
            'records' => BlogComment::with('post')->latest()->paginate(10),
            'columns' => ['id' => 'ID', 'post.title' => 'Post', 'name' => 'Name', 'email' => 'Email', 'is_approved' => 'Approved'],
        ]);
    }

    public function create()
    {
        return $this->form(new BlogComment(['is_approved' => false]), 'Create Blog Comment');
    }

    public function store(Request $request)
    {
        BlogComment::create($this->validated($request));

        return redirect('/admin/blog-comments')->with('success', 'Blog comment created successfully.');
    }

    public function show(BlogComment $blogComment)
    {
        $blogComment->load('post', 'user');

        return view('admin.crud.show', ['title' => 'Blog Comment Details', 'routeBase' => '/admin/blog-comments', 'record' => $blogComment]);
    }

    public function edit(BlogComment $blogComment)
    {
        return $this->form($blogComment, 'Edit Blog Comment');
    }

    public function update(Request $request, BlogComment $blogComment)
    {
        $blogComment->update($this->validated($request));

        return redirect('/admin/blog-comments')->with('success', 'Blog comment updated successfully.');
    }

    public function destroy(BlogComment $blogComment)
    {
        $blogComment->delete();

        return redirect('/admin/blog-comments')->with('success', 'Blog comment deleted successfully.');
    }

    private function form(BlogComment $record, string $title)
    {
        return view('admin.crud.form-page', ['title' => $title, 'routeBase' => '/admin/blog-comments', 'record' => $record, 'fields' => $this->fields()]);
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'blog_post_id' => ['nullable', 'exists:blog_posts,id'],
            'user_id' => ['nullable', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'comment' => ['required', 'string'],
            'is_approved' => ['nullable', 'boolean'],
        ]);

        $data['is_approved'] = (bool) ($data['is_approved'] ?? false);

        return $data;
    }

    private function fields(): array
    {
        return [
            ['name' => 'blog_post_id', 'label' => 'Post', 'type' => 'select', 'options' => BlogPost::orderBy('title')->pluck('title', 'id')->toArray(), 'col' => 6],
            ['name' => 'user_id', 'label' => 'User', 'type' => 'select', 'options' => User::orderBy('name')->pluck('name', 'id')->toArray(), 'col' => 6],
            ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'required' => true, 'col' => 6],
            ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'required' => true, 'col' => 6],
            ['name' => 'comment', 'label' => 'Comment', 'type' => 'textarea', 'required' => true, 'col' => 12],
            ['name' => 'is_approved', 'label' => 'Approved', 'type' => 'checkbox', 'col' => 6],
        ];
    }
}
