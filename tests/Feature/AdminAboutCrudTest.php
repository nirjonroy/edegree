<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AdminAboutCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_about_index_and_sidebar_item(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/abouts')
            ->assertOk()
            ->assertSee('About')
            ->assertSee('About Us');
    }

    public function test_admin_can_create_update_and_delete_about(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)
            ->post('/admin/abouts', [
                'image_1' => UploadedFile::fake()->image('one.jpg'),
                'image_2' => UploadedFile::fake()->image('two.jpg'),
                'image_3' => UploadedFile::fake()->image('three.jpg'),
                'about_us' => 'About content',
            ])
            ->assertRedirect('/admin/abouts');

        $about = \App\Models\About::first();
        $this->assertSame('About content', $about->about_us);
        $this->assertStringStartsWith('uploads/abouts/image_1-', $about->image_1);

        $this->actingAs($admin)
            ->put('/admin/abouts/'.$about->id, [
                'image_1' => UploadedFile::fake()->image('updated.jpg'),
                'about_us' => 'Updated about content',
            ])
            ->assertRedirect('/admin/abouts');

        $about->refresh();
        $this->assertSame('Updated about content', $about->about_us);
        $this->assertStringStartsWith('uploads/abouts/image_1-', $about->image_1);

        $this->actingAs($admin)
            ->delete('/admin/abouts/'.$about->id)
            ->assertRedirect('/admin/abouts');

        $this->assertDatabaseMissing('abouts', ['id' => $about->id]);
    }

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }
}
