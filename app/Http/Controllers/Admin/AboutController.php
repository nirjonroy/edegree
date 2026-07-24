<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AboutController extends Controller
{
    public function index()
    {
        return view('admin.crud.index', [
            'title' => 'About',
            'routeBase' => '/admin/abouts',
            'records' => About::latest()->paginate(10),
            'columns' => [
                'id' => 'ID',
                'page_title' => 'Page Title',
                'profile_title' => 'Profile Title',
                'about_us' => 'About Us',
                'status' => 'Status',
            ],
        ]);
    }

    public function create()
    {
        return $this->form(new About(['status' => true]), 'Create About');
    }

    public function store(Request $request)
    {
        About::create($this->storeUploads($request, $this->validated($request)));

        return redirect('/admin/abouts')->with('success', 'About created successfully.');
    }

    public function show(About $about)
    {
        return view('admin.crud.show', [
            'title' => 'About Details',
            'routeBase' => '/admin/abouts',
            'record' => $about,
        ]);
    }

    public function edit(About $about)
    {
        return $this->form($about, 'Edit About');
    }

    public function update(Request $request, About $about)
    {
        $about->update($this->storeUploads($request, $this->validated($request), $about));

        return redirect('/admin/abouts')->with('success', 'About updated successfully.');
    }

    public function destroy(About $about)
    {
        foreach (['image_1', 'image_2', 'image_3', 'meta_image'] as $field) {
            $this->deleteUpload($about->{$field});
        }

        $about->delete();

        return redirect('/admin/abouts')->with('success', 'About deleted successfully.');
    }

    private function form(About $record, string $title)
    {
        return view('admin.crud.form-page', [
            'title' => $title,
            'routeBase' => '/admin/abouts',
            'record' => $record,
            'fields' => $this->fields(),
        ]);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'image_1' => ['nullable', 'image', 'max:2048'],
            'image_2' => ['nullable', 'image', 'max:2048'],
            'image_3' => ['nullable', 'image', 'max:2048'],
            'page_title' => ['nullable', 'string', 'max:255'],
            'profile_title' => ['nullable', 'string', 'max:255'],
            'about_us' => ['nullable', 'string'],
            'stat_1_value' => ['nullable', 'string', 'max:255'],
            'stat_1_label' => ['nullable', 'string', 'max:255'],
            'stat_2_value' => ['nullable', 'string', 'max:255'],
            'stat_2_label' => ['nullable', 'string', 'max:255'],
            'stat_3_value' => ['nullable', 'string', 'max:255'],
            'stat_3_label' => ['nullable', 'string', 'max:255'],
            'faq_title' => ['nullable', 'string', 'max:255'],
            'faq_question_1' => ['nullable', 'string', 'max:255'],
            'faq_answer_1' => ['nullable', 'string'],
            'faq_question_2' => ['nullable', 'string', 'max:255'],
            'faq_answer_2' => ['nullable', 'string'],
            'faq_question_3' => ['nullable', 'string', 'max:255'],
            'faq_answer_3' => ['nullable', 'string'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'meta_image' => ['nullable', 'image', 'max:2048'],
            'author' => ['nullable', 'string', 'max:255'],
            'publisher' => ['nullable', 'string', 'max:255'],
            'copyright' => ['nullable', 'string', 'max:255'],
            'site_name' => ['nullable', 'string', 'max:255'],
            'keywords' => ['nullable', 'string'],
            'robots' => ['nullable', 'string', 'max:255'],
            'canonical_url' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'boolean'],
        ]);
    }

    private function fields(): array
    {
        return [
            ['name' => 'page_title', 'label' => 'Page Title', 'type' => 'text', 'col' => 5],
            ['name' => 'profile_title', 'label' => 'Profile Title', 'type' => 'text', 'col' => 5],
            ['name' => 'status', 'label' => 'Status', 'type' => 'checkbox', 'col' => 2],
            ['name' => 'image_1', 'label' => 'Image 1', 'type' => 'file', 'accept' => 'image/*', 'col' => 4],
            ['name' => 'image_2', 'label' => 'Image 2', 'type' => 'file', 'accept' => 'image/*', 'col' => 4],
            ['name' => 'image_3', 'label' => 'Image 3', 'type' => 'file', 'accept' => 'image/*', 'col' => 4],
            ['name' => 'about_us', 'label' => 'About Us', 'type' => 'summernote', 'rows' => 8, 'col' => 12],
            ['name' => 'stat_1_value', 'label' => 'Stat 1 Value', 'type' => 'text', 'col' => 2],
            ['name' => 'stat_1_label', 'label' => 'Stat 1 Label', 'type' => 'text', 'col' => 2],
            ['name' => 'stat_2_value', 'label' => 'Stat 2 Value', 'type' => 'text', 'col' => 2],
            ['name' => 'stat_2_label', 'label' => 'Stat 2 Label', 'type' => 'text', 'col' => 2],
            ['name' => 'stat_3_value', 'label' => 'Stat 3 Value', 'type' => 'text', 'col' => 2],
            ['name' => 'stat_3_label', 'label' => 'Stat 3 Label', 'type' => 'text', 'col' => 2],
            ['name' => 'faq_title', 'label' => 'FAQ Title', 'type' => 'text', 'col' => 12],
            ['name' => 'faq_question_1', 'label' => 'FAQ Question 1', 'type' => 'text', 'col' => 6],
            ['name' => 'faq_answer_1', 'label' => 'FAQ Answer 1', 'type' => 'textarea', 'rows' => 3, 'col' => 6],
            ['name' => 'faq_question_2', 'label' => 'FAQ Question 2', 'type' => 'text', 'col' => 6],
            ['name' => 'faq_answer_2', 'label' => 'FAQ Answer 2', 'type' => 'textarea', 'rows' => 3, 'col' => 6],
            ['name' => 'faq_question_3', 'label' => 'FAQ Question 3', 'type' => 'text', 'col' => 6],
            ['name' => 'faq_answer_3', 'label' => 'FAQ Answer 3', 'type' => 'textarea', 'rows' => 3, 'col' => 6],
            ['name' => 'seo_title', 'label' => 'SEO Title', 'type' => 'text', 'col' => 6],
            ['name' => 'seo_description', 'label' => 'SEO Description', 'type' => 'textarea', 'rows' => 3, 'col' => 6],
            ['name' => 'meta_title', 'label' => 'Meta Title', 'type' => 'text', 'col' => 6],
            ['name' => 'meta_description', 'label' => 'Meta Description', 'type' => 'textarea', 'rows' => 3, 'col' => 6],
            ['name' => 'meta_image', 'label' => 'Meta Image', 'type' => 'file', 'accept' => 'image/*', 'col' => 6],
            ['name' => 'author', 'label' => 'Author', 'type' => 'text', 'col' => 6],
            ['name' => 'publisher', 'label' => 'Publisher', 'type' => 'text', 'col' => 6],
            ['name' => 'copyright', 'label' => 'Copyright', 'type' => 'text', 'col' => 6],
            ['name' => 'site_name', 'label' => 'Site Name', 'type' => 'text', 'col' => 6],
            ['name' => 'keywords', 'label' => 'Keywords', 'type' => 'textarea', 'rows' => 3, 'col' => 6],
            ['name' => 'robots', 'label' => 'Robots', 'type' => 'text', 'col' => 6],
            ['name' => 'canonical_url', 'label' => 'Canonical URL', 'type' => 'url', 'col' => 6],
        ];
    }

    private function storeUploads(Request $request, array $data, ?About $about = null): array
    {
        foreach (['image_1', 'image_2', 'image_3', 'meta_image'] as $field) {
            if (! $request->hasFile($field)) {
                unset($data[$field]);
                continue;
            }

            if ($about) {
                $this->deleteUpload($about->{$field});
            }

            $file = $request->file($field);
            $filename = $field.'-'.time().'-'.uniqid().'.'.$file->getClientOriginalExtension();
            File::ensureDirectoryExists(public_path('uploads/abouts'));
            $file->move(public_path('uploads/abouts'), $filename);
            $data[$field] = 'uploads/abouts/'.$filename;
        }

        $data['status'] = (bool) ($data['status'] ?? false);

        return $data;
    }

    private function deleteUpload(?string $path): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
