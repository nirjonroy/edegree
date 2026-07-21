<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AdminNewsCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_news_with_optional_images_and_meta_data(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/news', [
                'category' => 'Education Trends',
                'title' => 'The Growing Value of Online Degrees',
                'slug' => 'growing-value-online-degrees',
                'image' => UploadedFile::fake()->image('news.jpg'),
                'short_description' => 'Online degrees are gaining value.',
                'description' => '<p>Full news content</p>',
                'quote' => 'An online degree shows digital discipline.',
                'author' => 'Dr. Alistair Vance',
                'published_at' => '2026-07-12 10:00:00',
                'meta_title' => 'Online Degree Value',
                'meta_description' => 'News meta description',
                'meta_keywords' => 'online degree, admissions news',
                'canonical_url' => 'https://example.com/news/growing-value-online-degrees',
                'meta_robots' => 'index,follow',
                'meta_image' => UploadedFile::fake()->image('meta.jpg'),
                'status' => 1,
            ])
            ->assertRedirect('/admin/news');

        $news = News::first();

        $this->assertSame('The Growing Value of Online Degrees', $news->title);
        $this->assertSame('growing-value-online-degrees', $news->slug);
        $this->assertStringStartsWith('uploads/news/image-', $news->image);
        $this->assertStringStartsWith('uploads/news/meta_image-', $news->meta_image);
    }

    public function test_news_create_form_has_rich_editor_and_sidebar_item(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/news/create')
            ->assertOk()
            ->assertSee('News')
            ->assertSee('Meta Image')
            ->assertSee('js-rich-editor', false);
    }

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }
}
