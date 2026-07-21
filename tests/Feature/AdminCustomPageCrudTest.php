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
                'description' => '<p>Policy content</p>',
                'meta_title' => 'Privacy Policy',
                'meta_description' => 'Privacy page',
                'meta_keywords' => 'privacy, policy',
                'canonical_url' => 'https://example.com/privacy-policy',
                'meta_robots' => 'index,follow',
                'meta_image' => UploadedFile::fake()->image('meta.jpg'),
                'status' => 1,
            ])
            ->assertRedirect('/admin/custom-pages');

        $page = CustomPage::first();

        $this->assertSame('Privacy Policy', $page->page_name);
        $this->assertSame('<p>Policy content</p>', $page->description);
        $this->assertStringStartsWith('uploads/custom-pages/meta-image-', $page->meta_image);
    }

    public function test_custom_page_create_form_has_rich_editor_description_and_sidebar_item(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/custom-pages/create')
            ->assertOk()
            ->assertSee('Custom Pages')
            ->assertSee('Page Name')
            ->assertSee('js-rich-editor', false)
            ->assertSee('Meta Image');
    }

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }
}
