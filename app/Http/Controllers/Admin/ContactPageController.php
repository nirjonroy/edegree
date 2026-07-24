<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactPage;
use Illuminate\Http\Request;

class ContactPageController extends Controller
{
    public function index()
    {
        return view('admin.crud.index', [
            'title' => 'Contact Page',
            'routeBase' => '/admin/contact-pages',
            'records' => ContactPage::latest()->paginate(10),
            'columns' => [
                'id' => 'ID',
                'page_title' => 'Page Title',
                'email' => 'Email',
                'phone_1' => 'Phone',
                'status' => 'Status',
            ],
        ]);
    }

    public function create()
    {
        return $this->form(new ContactPage(['status' => true]), 'Create Contact Page');
    }

    public function store(Request $request)
    {
        ContactPage::create($this->validated($request));

        return redirect('/admin/contact-pages')->with('success', 'Contact page created successfully.');
    }

    public function show(ContactPage $contactPage)
    {
        return view('admin.crud.show', [
            'title' => 'Contact Page Details',
            'routeBase' => '/admin/contact-pages',
            'record' => $contactPage,
        ]);
    }

    public function edit(ContactPage $contactPage)
    {
        return $this->form($contactPage, 'Edit Contact Page');
    }

    public function update(Request $request, ContactPage $contactPage)
    {
        $contactPage->update($this->validated($request));

        return redirect('/admin/contact-pages')->with('success', 'Contact page updated successfully.');
    }

    public function destroy(ContactPage $contactPage)
    {
        $contactPage->delete();

        return redirect('/admin/contact-pages')->with('success', 'Contact page deleted successfully.');
    }

    private function form(ContactPage $record, string $title)
    {
        return view('admin.crud.form-page', [
            'title' => $title,
            'routeBase' => '/admin/contact-pages',
            'record' => $record,
            'fields' => $this->fields(),
        ]);
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'page_title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string'],
            'details_title' => ['nullable', 'string', 'max:255'],
            'email_label' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone_label' => ['nullable', 'string', 'max:255'],
            'phone_1' => ['nullable', 'string', 'max:255'],
            'phone_2' => ['nullable', 'string', 'max:255'],
            'office_label' => ['nullable', 'string', 'max:255'],
            'office_1' => ['nullable', 'string', 'max:255'],
            'office_2' => ['nullable', 'string', 'max:255'],
            'form_title' => ['nullable', 'string', 'max:255'],
            'name_placeholder' => ['nullable', 'string', 'max:255'],
            'email_placeholder' => ['nullable', 'string', 'max:255'],
            'subject_placeholder' => ['nullable', 'string', 'max:255'],
            'message_placeholder' => ['nullable', 'string', 'max:255'],
            'button_text' => ['nullable', 'string', 'max:255'],
            'success_title' => ['nullable', 'string', 'max:255'],
            'success_message' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'boolean'],
        ]);

        $data['status'] = (bool) ($data['status'] ?? false);

        return $data;
    }

    private function fields(): array
    {
        return [
            ['name' => 'page_title', 'label' => 'Page Title', 'type' => 'text', 'required' => true, 'col' => 8],
            ['name' => 'status', 'label' => 'Status', 'type' => 'checkbox', 'col' => 4],
            ['name' => 'subtitle', 'label' => 'Subtitle', 'type' => 'textarea', 'rows' => 3, 'col' => 12],
            ['name' => 'details_title', 'label' => 'Details Title', 'type' => 'text', 'col' => 12],
            ['name' => 'email_label', 'label' => 'Email Label', 'type' => 'text', 'col' => 4],
            ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'col' => 8],
            ['name' => 'phone_label', 'label' => 'Phone Label', 'type' => 'text', 'col' => 4],
            ['name' => 'phone_1', 'label' => 'Phone 1', 'type' => 'text', 'col' => 4],
            ['name' => 'phone_2', 'label' => 'Phone 2', 'type' => 'text', 'col' => 4],
            ['name' => 'office_label', 'label' => 'Office Label', 'type' => 'text', 'col' => 4],
            ['name' => 'office_1', 'label' => 'Office 1', 'type' => 'text', 'col' => 4],
            ['name' => 'office_2', 'label' => 'Office 2', 'type' => 'text', 'col' => 4],
            ['name' => 'form_title', 'label' => 'Form Title', 'type' => 'text', 'col' => 12],
            ['name' => 'name_placeholder', 'label' => 'Name Placeholder', 'type' => 'text', 'col' => 6],
            ['name' => 'email_placeholder', 'label' => 'Email Placeholder', 'type' => 'text', 'col' => 6],
            ['name' => 'subject_placeholder', 'label' => 'Subject Placeholder', 'type' => 'text', 'col' => 6],
            ['name' => 'message_placeholder', 'label' => 'Message Placeholder', 'type' => 'text', 'col' => 6],
            ['name' => 'button_text', 'label' => 'Button Text', 'type' => 'text', 'col' => 4],
            ['name' => 'success_title', 'label' => 'Success Title', 'type' => 'text', 'col' => 4],
            ['name' => 'success_message', 'label' => 'Success Message', 'type' => 'textarea', 'rows' => 3, 'col' => 4],
            ['name' => 'meta_title', 'label' => 'Meta Title', 'type' => 'text', 'col' => 6],
            ['name' => 'meta_description', 'label' => 'Meta Description', 'type' => 'textarea', 'rows' => 3, 'col' => 6],
        ];
    }
}
