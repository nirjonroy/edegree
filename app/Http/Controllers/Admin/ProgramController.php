<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\ProgramCategory;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProgramController extends Controller
{
    public function index()
    {
        return view('admin.crud.index', [
            'title' => 'Programs',
            'routeBase' => '/admin/programs',
            'records' => Program::with(['degree', 'university'])->latest()->paginate(10),
            'columns' => [
                'id' => 'ID',
                'program' => 'Program',
                'degree.name' => 'Category',
                'university.name' => 'University',
                'status' => 'Status',
                'recommend' => 'Recommend',
            ],
        ]);
    }

    public function create()
    {
        return $this->form(new Program(['status' => true, 'recommend' => false]), 'Create Program');
    }

    public function store(Request $request)
    {
        Program::create($this->prepareData($request));

        return redirect('/admin/programs')->with('success', 'Program created successfully.');
    }

    public function show(Program $program)
    {
        $program->load(['degree', 'university']);

        return view('admin.crud.show', [
            'title' => 'Program Details',
            'routeBase' => '/admin/programs',
            'record' => $program,
        ]);
    }

    public function edit(Program $program)
    {
        return $this->form($program, 'Edit Program');
    }

    public function update(Request $request, Program $program)
    {
        $program->update($this->prepareData($request, $program));

        return redirect('/admin/programs')->with('success', 'Program updated successfully.');
    }

    public function destroy(Program $program)
    {
        $this->deleteUpload($program->syllabus_pdf);
        $this->deleteUpload($program->image);
        $this->deleteUpload($program->meta_image);
        $program->delete();

        return redirect('/admin/programs')->with('success', 'Program deleted successfully.');
    }

    private function form(Program $record, string $title)
    {
        return view('admin.crud.form-page', [
            'title' => $title,
            'routeBase' => '/admin/programs',
            'record' => $record,
            'fields' => $this->fields(),
        ]);
    }

    private function prepareData(Request $request, ?Program $program = null): array
    {
        $data = $request->validate([
            'degree_id' => ['nullable', 'exists:program_categories,id'],
            'university_id' => ['nullable', 'exists:universities,id'],
            'type' => ['nullable', 'string', 'max:255'],
            'program' => ['required', 'string', 'max:255'],
            'short_name' => ['nullable', 'string', 'max:255'],
            'short_description' => ['nullable', 'string'],
            'long_description' => ['nullable', 'string'],
            'overview_title' => ['nullable', 'string', 'max:255'],
            'curriculum_title' => ['nullable', 'string', 'max:255'],
            'curriculum_description' => ['nullable', 'string'],
            'eligibility_title' => ['nullable', 'string', 'max:255'],
            'eligibility_description' => ['nullable', 'string'],
            'documents_required' => ['nullable', 'string'],
            'fees_title' => ['nullable', 'string', 'max:255'],
            'fees_description' => ['nullable', 'string'],
            'scholarship_title' => ['nullable', 'string', 'max:255'],
            'scholarship_description' => ['nullable', 'string'],
            'outcomes_title' => ['nullable', 'string', 'max:255'],
            'outcomes_description' => ['nullable', 'string'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('programs')->ignore($program)],
            'total_fee' => ['nullable', 'string', 'max:255'],
            'yearly' => ['nullable', 'string', 'max:255'],
            'duration' => ['nullable', 'string', 'max:255'],
            'delivery_mode' => ['nullable', 'string', 'max:255'],
            'link' => ['nullable', 'string', 'max:255'],
            'syllabus_pdf' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'],
            'advisor_title' => ['nullable', 'string', 'max:255'],
            'advisor_description' => ['nullable', 'string'],
            'apply_button_text' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'boolean'],
            'recommend' => ['nullable', 'boolean'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'meta_image' => ['nullable', 'image', 'max:2048'],
            'keywords' => ['nullable', 'string'],
            'canonical_url' => ['nullable', 'string', 'max:255'],
            'author' => ['nullable', 'string', 'max:255'],
            'publisher' => ['nullable', 'string', 'max:255'],
            'copyright' => ['nullable', 'string', 'max:255'],
            'site_name' => ['nullable', 'string', 'max:255'],
            'robots' => ['nullable', 'string', 'max:255'],
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['program']);
        $data['status'] = (bool) ($data['status'] ?? false);
        $data['recommend'] = (bool) ($data['recommend'] ?? false);

        if ($request->hasFile('syllabus_pdf')) {
            if ($program) {
                $this->deleteUpload($program->syllabus_pdf);
            }

            $file = $request->file('syllabus_pdf');
            $filename = 'syllabus-'.time().'-'.uniqid().'.'.$file->getClientOriginalExtension();
            File::ensureDirectoryExists(public_path('uploads/programs'));
            $file->move(public_path('uploads/programs'), $filename);
            $data['syllabus_pdf'] = 'uploads/programs/'.$filename;
        } elseif ($program) {
            unset($data['syllabus_pdf']);
        }

        foreach (['image' => 'program', 'meta_image' => 'program-meta'] as $field => $prefix) {
            if ($request->hasFile($field)) {
                if ($program) {
                    $this->deleteUpload($program->{$field});
                }

                $file = $request->file($field);
                $filename = $prefix.'-'.time().'-'.uniqid().'.'.$file->getClientOriginalExtension();
                File::ensureDirectoryExists(public_path('uploads/programs'));
                $file->move(public_path('uploads/programs'), $filename);
                $data[$field] = 'uploads/programs/'.$filename;
            } elseif ($program) {
                unset($data[$field]);
            }
        }

        return $data;
    }

    private function fields(): array
    {
        return [
            ['name' => 'program', 'label' => 'Program', 'type' => 'text', 'required' => true, 'col' => 6],
            ['name' => 'slug', 'label' => 'Slug', 'type' => 'text', 'col' => 6],
            ['name' => 'degree_id', 'label' => 'Program Category', 'type' => 'select', 'options' => ProgramCategory::orderBy('name')->pluck('name', 'id')->toArray(), 'col' => 6],
            ['name' => 'university_id', 'label' => 'University', 'type' => 'select', 'options' => University::orderBy('name')->pluck('name', 'id')->toArray(), 'col' => 6],
            ['name' => 'type', 'label' => 'Type', 'type' => 'text', 'col' => 4],
            ['name' => 'short_name', 'label' => 'Short Name', 'type' => 'text', 'col' => 4],
            ['name' => 'duration', 'label' => 'Duration', 'type' => 'text', 'col' => 4],
            ['name' => 'delivery_mode', 'label' => 'Delivery Mode', 'type' => 'text', 'col' => 4],
            ['name' => 'total_fee', 'label' => 'Total Fee', 'type' => 'text', 'col' => 4],
            ['name' => 'yearly', 'label' => 'Yearly', 'type' => 'text', 'col' => 4],
            ['name' => 'link', 'label' => 'Link', 'type' => 'url', 'col' => 4],
            ['name' => 'syllabus_pdf', 'label' => 'Syllabus PDF', 'type' => 'file', 'accept' => 'application/pdf', 'preview' => 'file', 'col' => 4],
            ['name' => 'image', 'label' => 'Program Image', 'type' => 'file', 'accept' => 'image/*', 'preview' => 'image', 'col' => 4],
            ['name' => 'status', 'label' => 'Status', 'type' => 'checkbox', 'col' => 3],
            ['name' => 'recommend', 'label' => 'Recommend', 'type' => 'checkbox', 'col' => 3],
            ['name' => 'short_description', 'label' => 'Short Description', 'type' => 'textarea', 'rows' => 3, 'col' => 12],
            ['name' => 'overview_title', 'label' => 'Overview Title', 'type' => 'text', 'col' => 12],
            ['name' => 'long_description', 'label' => 'Long Description', 'type' => 'summernote', 'col' => 12],
            ['name' => 'curriculum_title', 'label' => 'Curriculum Title', 'type' => 'text', 'col' => 12],
            ['name' => 'curriculum_description', 'label' => 'Curriculum Description', 'type' => 'summernote', 'col' => 12],
            ['name' => 'eligibility_title', 'label' => 'Eligibility Title', 'type' => 'text', 'col' => 12],
            ['name' => 'eligibility_description', 'label' => 'Eligibility Description', 'type' => 'summernote', 'col' => 12],
            ['name' => 'documents_required', 'label' => 'Documents Required', 'type' => 'summernote', 'col' => 12],
            ['name' => 'fees_title', 'label' => 'Fees Title', 'type' => 'text', 'col' => 12],
            ['name' => 'fees_description', 'label' => 'Fees Description', 'type' => 'summernote', 'col' => 12],
            ['name' => 'scholarship_title', 'label' => 'Scholarship Title', 'type' => 'text', 'col' => 6],
            ['name' => 'scholarship_description', 'label' => 'Scholarship Description', 'type' => 'textarea', 'rows' => 3, 'col' => 6],
            ['name' => 'outcomes_title', 'label' => 'Outcomes Title', 'type' => 'text', 'col' => 12],
            ['name' => 'outcomes_description', 'label' => 'Outcomes Description', 'type' => 'summernote', 'col' => 12],
            ['name' => 'advisor_title', 'label' => 'Inquiry Form Title', 'type' => 'text', 'col' => 6],
            ['name' => 'advisor_description', 'label' => 'Inquiry Form Description', 'type' => 'textarea', 'rows' => 3, 'col' => 6],
            ['name' => 'apply_button_text', 'label' => 'Apply Button Text', 'type' => 'text', 'col' => 6],
            ['name' => 'seo_title', 'label' => 'SEO Title', 'type' => 'text', 'col' => 6],
            ['name' => 'seo_description', 'label' => 'SEO Description', 'type' => 'textarea', 'rows' => 3, 'col' => 6],
            ['name' => 'meta_title', 'label' => 'Meta Title', 'type' => 'text', 'col' => 6],
            ['name' => 'meta_description', 'label' => 'Meta Description', 'type' => 'textarea', 'rows' => 3, 'col' => 6],
            ['name' => 'meta_image', 'label' => 'Meta Image', 'type' => 'file', 'accept' => 'image/*', 'col' => 6],
            ['name' => 'keywords', 'label' => 'Keywords', 'type' => 'textarea', 'rows' => 3, 'col' => 6],
            ['name' => 'canonical_url', 'label' => 'Canonical URL', 'type' => 'url', 'col' => 6],
            ['name' => 'author', 'label' => 'Author', 'type' => 'text', 'col' => 6],
            ['name' => 'publisher', 'label' => 'Publisher', 'type' => 'text', 'col' => 6],
            ['name' => 'copyright', 'label' => 'Copyright', 'type' => 'text', 'col' => 6],
            ['name' => 'site_name', 'label' => 'Site Name', 'type' => 'text', 'col' => 6],
            ['name' => 'robots', 'label' => 'Robots', 'type' => 'text', 'col' => 6],
        ];
    }

    private function deleteUpload(?string $path): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
