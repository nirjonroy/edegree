<?php

namespace Tests\Feature;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AdminBlogCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_blog_menu_is_visible_in_admin_sidebar(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/blog-categories')
            ->assertOk()
            ->assertSee('Blog')
            ->assertSee('Categories')
            ->assertSee('Posts')
            ->assertSee('Comments')
            ->assertSee('Pages');
    }

    public function test_admin_can_create_blog_category(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/blog-categories', [
                'name' => 'News',
                'slug' => 'news',
                'description' => 'Latest news',
                'display_order' => 1,
                'is_active' => 1,
            ])
            ->assertRedirect('/admin/blog-categories');

        $this->assertDatabaseHas('blog_categories', ['name' => 'News', 'slug' => 'news']);
    }

    public function test_admin_can_create_blog_page(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/blog-pages', [
                'hero_title' => 'Blog',
                'home_section_title' => 'Latest Articles',
            ])
            ->assertRedirect('/admin/blog-pages');

        $this->assertDatabaseHas('blog_pages', ['hero_title' => 'Blog']);
    }

    public function test_admin_can_create_blog_post(): void
    {
        $category = BlogCategory::create([
            'name' => 'News',
            'slug' => 'news',
            'is_active' => true,
        ]);

        $this->actingAs($this->admin())
            ->post('/admin/blog-posts', [
                'blog_category_id' => $category->id,
                'title' => 'First Post',
                'slug' => 'first-post',
                'image' => UploadedFile::fake()->image('post.jpg'),
                'short_description' => 'Short excerpt',
                'long_description' => '<p>Full content</p>',
                'meta_title' => 'First Post Meta',
                'meta_description' => 'Meta description',
                'meta_image' => UploadedFile::fake()->image('meta.jpg'),
                'author' => 'Admin',
                'publisher' => 'eDegree',
                'copyright' => 'eDegree',
                'site_name' => 'eDegree+',
                'keywords' => 'education, blog',
                'description' => 'Search description',
                'status' => 'published',
            ])
            ->assertRedirect('/admin/blog-posts');

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'First Post',
            'slug' => 'first-post',
            'author' => 'Admin',
            'status' => 'published',
            'is_published' => 1,
        ]);
    }

    public function test_admin_can_create_blog_comment(): void
    {
        $category = BlogCategory::create(['name' => 'News', 'slug' => 'news']);
        $post = BlogPost::create([
            'blog_category_id' => $category->id,
            'title' => 'First Post',
            'slug' => 'first-post',
            'author_name' => 'Admin',
            'excerpt' => 'Short excerpt',
            'content' => 'Full content',
        ]);

        $this->actingAs($this->admin())
            ->post('/admin/blog-comments', [
                'blog_post_id' => $post->id,
                'name' => 'Reader',
                'email' => 'reader@example.com',
                'comment' => 'Nice article',
                'is_approved' => 1,
            ])
            ->assertRedirect('/admin/blog-comments');

        $this->assertDatabaseHas('blog_comments', ['name' => 'Reader', 'is_approved' => 1]);
    }

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }
}
