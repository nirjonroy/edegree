<?php

namespace Tests\Feature;

use App\Models\ContactPage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminContactPageCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_contact_page(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/contact-pages', [
                'page_title' => 'Contact eDegree+',
                'subtitle' => 'Contact subtitle',
                'details_title' => 'Connect Directly',
                'email_label' => 'Email Inquiry',
                'email' => 'support@example.com',
                'phone_label' => 'Support Hotlines',
                'phone_1' => '+1 555 1000',
                'office_label' => 'Corporate Offices',
                'office_1' => 'Dhaka Office',
                'form_title' => 'Send a Message',
                'button_text' => 'Submit Message',
                'status' => 1,
            ])
            ->assertRedirect('/admin/contact-pages');

        $page = ContactPage::first();

        $this->assertSame('Contact eDegree+', $page->page_title);
        $this->assertSame('support@example.com', $page->email);
    }

    public function test_contact_page_menu_and_form_are_available(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/contact-pages/create')
            ->assertOk()
            ->assertSee('Contact Page')
            ->assertSee('Email Label')
            ->assertSee('Success Message');

        $this->actingAs($this->admin())
            ->get('/admin/dashboard')
            ->assertOk()
            ->assertSee('Contact Page');
    }

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }
}
