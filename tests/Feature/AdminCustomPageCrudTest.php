<?php

namespace Tests\Feature;

use App\Models\CustomPage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AdminCustomPageCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_custom_page(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/custom-pages', [
                'page_name' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'desired_url' => 'privacy-policy',
                'subtitle' => 'Privacy page subtitle',
                'short_description' => 'Short privacy summary',
                'description' => '<p>Policy content</p>',
                'background_image' => UploadedFile::fake()->image('background.jpg'),
                'meta_title' => 'Privacy Policy',
                'meta_description' => 'Privacy page',
                'meta_keywords' => 'privacy, policy',
                'canonical_url' => 'https://example.com/privacy-policy',
                'meta_robots' => 'index,follow',
                'meta_image' => UploadedFile::fake()->image('meta.jpg'),
                'status' => 1,
                'published_at' => now()->format('Y-m-d H:i:s'),
            ])
            ->assertRedirect('/admin/custom-pages');

        $page = CustomPage::first();

        $this->assertSame('Privacy Policy', $page->page_name);
        $this->assertSame('privacy-policy', $page->desired_url);
        $this->assertSame('Privacy page subtitle', $page->subtitle);
        $this->assertSame('<p>Policy content</p>', $page->description);
        $this->assertStringStartsWith('uploads/custom-pages/background-image-', $page->background_image);
        $this->assertStringStartsWith('uploads/custom-pages/meta-image-', $page->meta_image);
    }

    public function test_custom_page_create_form_has_rich_editor_description_and_sidebar_item(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/custom-pages/create')
            ->assertOk()
            ->assertSee('Custom Pages')
            ->assertSee('Page Name')
            ->assertSee('Desired URL')
            ->assertSee('Published At')
            ->assertSee('Background Image')
            ->assertSee('js-rich-editor', false)
            ->assertSee('verify_html: false', false)
            ->assertSee('extended_valid_elements', false)
            ->assertSee('valid_children', false)
            ->assertSee('Meta Image');
    }

    public function test_admin_can_save_custom_page_script_content(): void
    {
        $scriptContent = '<script>console.log("hello");</script><p>hello</p>';

        $this->actingAs($this->admin())
            ->post('/admin/custom-pages', [
                'page_name' => 'Script Page',
                'slug' => 'script-page',
                'desired_url' => 'script-page',
                'description' => $scriptContent,
                'status' => 1,
                'published_at' => now()->format('Y-m-d H:i:s'),
            ])
            ->assertRedirect('/admin/custom-pages');

        $this->assertSame($scriptContent, CustomPage::where('slug', 'script-page')->value('description'));
    }

    public function test_custom_page_index_uses_page_list_layout(): void
    {
        CustomPage::create([
            'page_name' => 'Buy Guide',
            'slug' => 'buy-guide',
            'desired_url' => 'guides/buy-guide',
            'status' => true,
            'published_at' => now(),
        ]);

        $this->actingAs($this->admin())
            ->get('/admin/custom-pages')
            ->assertOk()
            ->assertSee('Page List')
            ->assertSee('Add Custom Page')
            ->assertSee('/guides/buy-guide')
            ->assertSee('Published');
    }

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }
}
