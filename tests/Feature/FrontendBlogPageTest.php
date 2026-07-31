<?php

namespace Tests\Feature;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Database\Seeders\BlogDataSeeder;
use Database\Seeders\UniversityDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FrontendBlogPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_blog_listing_is_dynamic(): void
    {
        $this->seed(UniversityDataSeeder::class);
        $this->seed(BlogDataSeeder::class);

        $this->get('/blog')
            ->assertOk()
            ->assertSee('Insights Blog')
            ->assertSee('The Growing Value of Online Degrees in the 2026 Job Market')
            ->assertSee('/blog/value-of-online-degrees-2026')
            ->assertDontSee('h-56 bg-altBg overflow-hidden', false);
    }

    public function test_blog_post_image_is_optional_on_listing_and_details(): void
    {
        $category = BlogCategory::create([
            'name' => 'Admissions Info',
            'slug' => 'admissions-info',
            'is_active' => true,
        ]);

        BlogPost::create([
            'blog_category_id' => $category->id,
            'title' => 'Image Free Blog Post',
            'slug' => 'image-free-blog-post',
            'author_name' => 'Admin',
            'excerpt' => 'This post has no uploaded image.',
            'content' => '<p>Details should render without a main image.</p>',
            'long_description' => '<p>Details should render without a main image.</p>',
            'status' => 'published',
            'is_published' => true,
            'published_at' => now(),
        ]);

        $this->get('/blog')
            ->assertOk()
            ->assertSee('Image Free Blog Post')
            ->assertDontSee('h-56 bg-altBg overflow-hidden', false);

        $this->get('/blog/image-free-blog-post')
            ->assertOk()
            ->assertSee('Details should render without a main image.', false)
            ->assertSee('Recent Insights')
            ->assertDontSee('h-64 md:h-96 bg-altBg overflow-hidden rounded-lg', false);
    }

    public function test_blog_category_filter_and_single_page_render(): void
    {
        $this->seed(UniversityDataSeeder::class);
        $this->seed(BlogDataSeeder::class);

        $this->get('/blog?category=executive-growth')
            ->assertOk()
            ->assertSee('The Rise of the DBA')
            ->assertSee('Executive Growth');

        $this->get('/blog/value-of-online-degrees-2026')
            ->assertOk()
            ->assertSee('Dr. Alistair Vance')
            ->assertSee('Employers increasingly value accredited online credentials')
            ->assertSee('Recent Insights');
    }

    public function test_legacy_blog_static_urls_render_or_redirect_to_dynamic_pages(): void
    {
        $this->seed(UniversityDataSeeder::class);
        $this->seed(BlogDataSeeder::class);

        $this->get('/frontend/blog.html')
            ->assertOk()
            ->assertSee('Insights Blog')
            ->assertSee('How to Choose the Right Online MBA Program');

        $this->get('/frontend/blog-single.html?id=value-of-online-degrees-2026')
            ->assertRedirect('/blog/value-of-online-degrees-2026');
    }
}
