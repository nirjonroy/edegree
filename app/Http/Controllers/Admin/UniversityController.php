<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UniversityController extends Controller
{
    private array $uploadFields = [
        'image_1',
        'meta_image',
    ];

    public function index()
    {
        return view('admin.crud.index', [
            'title' => 'Universities',
            'routeBase' => '/admin/universities',
            'records' => University::latest()->paginate(10),
            'columns' => [
                'id' => 'ID',
                'name' => 'Name',
                'slug' => 'Slug',
                'status' => 'Status',
                'priority' => 'Priority',
                'created_at' => 'Created',
            ],
        ]);
    }

    public function create()
    {
        return $this->form(new University(['status' => true, 'is_done' => false]), 'Create University');
    }

    public function store(Request $request)
    {
        University::create($this->prepareData($request));

        return redirect('/admin/universities')->with('success', 'University created successfully.');
    }

    public function show(University $university)
    {
        return view('admin.crud.show', [
            'title' => 'University Details',
            'routeBase' => '/admin/universities',
            'record' => $university,
        ]);
    }

    public function edit(University $university)
    {
        return $this->form($university, 'Edit University');
    }

    public function update(Request $request, University $university)
    {
        $university->update($this->prepareData($request, $university));

        return redirect('/admin/universities')->with('success', 'University updated successfully.');
    }

    public function destroy(University $university)
    {
        foreach ($this->uploadFields as $field) {
            $this->deleteUpload($university->{$field});
        }

        $university->delete();

        return redirect('/admin/universities')->with('success', 'University deleted successfully.');
    }

    private function form(University $record, string $title)
    {
        return view('admin.crud.form-page', [
            'title' => $title,
            'routeBase' => '/admin/universities',
            'record' => $record,
            'fields' => $this->fields(),
        ]);
    }

    private function prepareData(Request $request, ?University $university = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('universities')->ignore($university)],
            'link' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'founded_year' => ['nullable', 'string', 'max:255'],
            'ranking_badge' => ['nullable', 'string', 'max:255'],
            'accreditation_badge' => ['nullable', 'string', 'max:255'],
            'degree_badge' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'boolean'],
            'is_done' => ['nullable', 'boolean'],
            'priority' => ['nullable', 'integer', 'min:0'],
            'image_1' => ['nullable', 'image', 'max:2048'],
            'short_description' => ['nullable', 'string'],
            'long_description' => ['nullable', 'string'],
            'profile_title' => ['nullable', 'string', 'max:255'],
            'profile_description' => ['nullable', 'string'],
            'accomplishment_title' => ['nullable', 'string', 'max:255'],
            'accomplishment_text' => ['nullable', 'string', 'max:255'],
            'accreditation_title' => ['nullable', 'string', 'max:255'],
            'accreditation_description' => ['nullable', 'string'],
            'accrediting_commission_title' => ['nullable', 'string', 'max:255'],
            'accrediting_commission_text' => ['nullable', 'string'],
            'admissions_title' => ['nullable', 'string', 'max:255'],
            'admissions_description' => ['nullable', 'string'],
            'reviews_title' => ['nullable', 'string', 'max:255'],
            'review_1_name' => ['nullable', 'string', 'max:255'],
            'review_1_text' => ['nullable', 'string'],
            'review_1_rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'review_2_name' => ['nullable', 'string', 'max:255'],
            'review_2_text' => ['nullable', 'string'],
            'review_2_rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'advisor_title' => ['nullable', 'string', 'max:255'],
            'advisor_description' => ['nullable', 'string'],
            'rated' => ['nullable', 'string', 'max:255'],
            'global_network' => ['nullable', 'string', 'max:255'],
            'award' => ['nullable', 'string', 'max:255'],
            'rank' => ['nullable', 'string', 'max:255'],
            'faq_question_1' => ['nullable', 'string', 'max:255'],
            'faq_question_2' => ['nullable', 'string', 'max:255'],
            'faq_question_3' => ['nullable', 'string', 'max:255'],
            'faq_question_4' => ['nullable', 'string', 'max:255'],
            'faq_question_5' => ['nullable', 'string', 'max:255'],
            'faq_answer_1' => ['nullable', 'string'],
            'faq_answer_2' => ['nullable', 'string'],
            'faq_answer_3' => ['nullable', 'string'],
            'faq_answer_4' => ['nullable', 'string'],
            'faq_answer_5' => ['nullable', 'string'],
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
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['status'] = (bool) ($data['status'] ?? false);
        $data['is_done'] = (bool) ($data['is_done'] ?? false);

        return $this->storeUploads($request, $data, $university);
    }

    private function fields(): array
    {
        $fields = [
            ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'required' => true, 'col' => 6],
            ['name' => 'slug', 'label' => 'Slug', 'type' => 'text', 'col' => 6],
            ['name' => 'link', 'label' => 'Link', 'type' => 'url', 'col' => 6],
            ['name' => 'location', 'label' => 'Location', 'type' => 'text', 'col' => 6],
            ['name' => 'founded_year', 'label' => 'Founded Year', 'type' => 'text', 'col' => 3],
            ['name' => 'priority', 'label' => 'Priority', 'type' => 'number', 'col' => 3],
            ['name' => 'status', 'label' => 'Status', 'type' => 'checkbox', 'col' => 3],
            ['name' => 'is_done', 'label' => 'Done', 'type' => 'checkbox', 'col' => 3],
            ['name' => 'image_1', 'label' => 'Main Image', 'type' => 'file', 'accept' => 'image/*', 'col' => 6],
            ['name' => 'ranking_badge', 'label' => 'Ranking Badge', 'type' => 'text', 'col' => 4],
            ['name' => 'accreditation_badge', 'label' => 'Accreditation Badge', 'type' => 'text', 'col' => 4],
            ['name' => 'degree_badge', 'label' => 'Degree Badge', 'type' => 'text', 'col' => 4],
        ];

        $fields = array_merge($fields, [
            ['name' => 'short_description', 'label' => 'Short Description', 'type' => 'textarea', 'rows' => 3, 'col' => 12],
            ['name' => 'long_description', 'label' => 'Long Description', 'type' => 'summernote', 'col' => 12],
            ['name' => 'profile_title', 'label' => 'Profile Title', 'type' => 'text', 'col' => 6],
            ['name' => 'profile_description', 'label' => 'Profile Description', 'type' => 'summernote', 'col' => 12],
            ['name' => 'accomplishment_title', 'label' => 'Accomplishment Title', 'type' => 'text', 'col' => 6],
            ['name' => 'accomplishment_text', 'label' => 'Accomplishment Text', 'type' => 'text', 'col' => 6],
            ['name' => 'accreditation_title', 'label' => 'Accreditation Title', 'type' => 'text', 'col' => 6],
            ['name' => 'accreditation_description', 'label' => 'Accreditation Description', 'type' => 'summernote', 'col' => 12],
            ['name' => 'accrediting_commission_title', 'label' => 'Accrediting Commission Title', 'type' => 'text', 'col' => 6],
            ['name' => 'accrediting_commission_text', 'label' => 'Accrediting Commission Text', 'type' => 'textarea', 'rows' => 3, 'col' => 6],
            ['name' => 'admissions_title', 'label' => 'Admissions Title', 'type' => 'text', 'col' => 6],
            ['name' => 'admissions_description', 'label' => 'Admissions Description', 'type' => 'summernote', 'col' => 12],
            ['name' => 'reviews_title', 'label' => 'Reviews Title', 'type' => 'text', 'col' => 6],
            ['name' => 'review_1_name', 'label' => 'Review 1 Name', 'type' => 'text', 'col' => 4],
            ['name' => 'review_1_rating', 'label' => 'Review 1 Rating', 'type' => 'number', 'col' => 2],
            ['name' => 'review_1_text', 'label' => 'Review 1 Text', 'type' => 'textarea', 'rows' => 3, 'col' => 6],
            ['name' => 'review_2_name', 'label' => 'Review 2 Name', 'type' => 'text', 'col' => 4],
            ['name' => 'review_2_rating', 'label' => 'Review 2 Rating', 'type' => 'number', 'col' => 2],
            ['name' => 'review_2_text', 'label' => 'Review 2 Text', 'type' => 'textarea', 'rows' => 3, 'col' => 6],
            ['name' => 'advisor_title', 'label' => 'Advisor Box Title', 'type' => 'text', 'col' => 6],
            ['name' => 'advisor_description', 'label' => 'Advisor Box Description', 'type' => 'textarea', 'rows' => 3, 'col' => 6],
            ['name' => 'rated', 'label' => 'Rated', 'type' => 'text', 'col' => 3],
            ['name' => 'global_network', 'label' => 'Global Network', 'type' => 'text', 'col' => 3],
            ['name' => 'award', 'label' => 'Award', 'type' => 'text', 'col' => 3],
            ['name' => 'rank', 'label' => 'Rank', 'type' => 'text', 'col' => 3],
        ]);

        for ($i = 1; $i <= 5; $i++) {
            $fields[] = ['name' => 'faq_question_'.$i, 'label' => 'FAQ Question '.$i, 'type' => 'text', 'col' => 6];
            $fields[] = ['name' => 'faq_answer_'.$i, 'label' => 'FAQ Answer '.$i, 'type' => 'textarea', 'rows' => 3, 'col' => 6];
        }

        return array_merge($fields, [
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
        ]);
    }

    private function storeUploads(Request $request, array $data, ?University $university = null): array
    {
        foreach ($this->uploadFields as $field) {
            if (! $request->hasFile($field)) {
                unset($data[$field]);
                continue;
            }

            if ($university) {
                $this->deleteUpload($university->{$field});
            }

            $file = $request->file($field);
            $filename = $field.'-'.time().'-'.uniqid().'.'.$file->getClientOriginalExtension();
            File::ensureDirectoryExists(public_path('uploads/universities'));
            $file->move(public_path('uploads/universities'), $filename);
            $data[$field] = 'uploads/universities/'.$filename;
        }

        return $data;
    }

    private function deleteUpload(?string $path): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
