<?php

namespace Tests\Feature;

use App\Models\Slider;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AdminSliderCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_slider(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/sliders', [
                'badge_text' => 'Accredited Global Partners',
                'title' => 'Advance Your Career with Accredited Online University Degrees',
                'subtitle' => 'Secure recognized MBA, DBA, Master\'s, and Bachelor\'s programs without career disruption.',
                'image' => UploadedFile::fake()->image('hero.jpg', 1600, 900),
                'primary_tab_text' => 'Find a Program',
                'secondary_tab_text' => 'Find a University',
                'search_placeholder' => 'Search course names, domains or keywords...',
                'button_text' => 'Search',
                'button_link' => '/programs',
                'sort_order' => 1,
                'status' => 1,
            ])
            ->assertRedirect('/admin/sliders');

        $slider = Slider::first();

        $this->assertSame('Accredited Global Partners', $slider->badge_text);
        $this->assertSame(1, $slider->sort_order);
        $this->assertStringStartsWith('uploads/sliders/slider-', $slider->image);
    }

    public function test_slider_create_form_matches_home_hero_controls(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/sliders/create')
            ->assertOk()
            ->assertSee('Sliders')
            ->assertSee('Badge Text')
            ->assertSee('Background Image')
            ->assertSee('Primary Tab Text')
            ->assertSee('Secondary Tab Text')
            ->assertSee('Search Placeholder');
    }

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }
}
