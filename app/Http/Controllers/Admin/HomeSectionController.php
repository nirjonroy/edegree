<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HasSeoFields;
use App\Http\Controllers\Controller;
use App\Models\HomeSection;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HomeSectionController extends Controller
{
    use HasSeoFields;

    public function index()
    {
        return view('admin.crud.index', [
            'title' => 'Home Sections',
            'routeBase' => '/admin/home-sections',
            'records' => HomeSection::orderBy('key')->paginate(10),
            'columns' => [
                'id' => 'ID',
                'key' => 'Key',
                'title' => 'Title',
                'status' => 'Status',
                'updated_at' => 'Updated',
            ],
        ]);
    }

    public function create()
    {
        return $this->form(new HomeSection(['status' => true]), 'Create Home Section');
    }

    public function store(Request $request)
    {
        HomeSection::create($this->prepareData($request));

        return redirect('/admin/home-sections')->with('success', 'Home section created successfully.');
    }

    public function show(HomeSection $homeSection)
    {
        return view('admin.crud.show', [
            'title' => 'Home Section Details',
            'routeBase' => '/admin/home-sections',
            'record' => $homeSection,
        ]);
    }

    public function edit(HomeSection $homeSection)
    {
        return $this->form($homeSection, 'Edit Home Section');
    }

    public function update(Request $request, HomeSection $homeSection)
    {
        $homeSection->update($this->prepareData($request, $homeSection));

        return redirect('/admin/home-sections')->with('success', 'Home section updated successfully.');
    }

    public function destroy(HomeSection $homeSection)
    {
        $this->deleteSeoUpload($homeSection->meta_image);
        $homeSection->delete();

        return redirect('/admin/home-sections')->with('success', 'Home section deleted successfully.');
    }

    private function form(HomeSection $record, string $title)
    {
        return view('admin.crud.form-page', [
            'title' => $title,
            'routeBase' => '/admin/home-sections',
            'record' => $record,
            'fields' => $this->fields(),
        ]);
    }

    private function prepareData(Request $request, ?HomeSection $homeSection = null): array
    {
        $data = $request->validate(array_merge([
            'key' => ['required', 'string', 'max:255', Rule::unique('home_sections')->ignore($homeSection)],
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string'],
            'button_text' => ['nullable', 'string', 'max:255'],
            'input_placeholder' => ['nullable', 'string', 'max:255'],
            'privacy_note' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'boolean'],
        ], $this->seoValidationRules()));

        $data['status'] = (bool) ($data['status'] ?? false);

        return $this->storeSeoUploads($request, $data, $homeSection, 'home-sections');
    }

    private function fields(): array
    {
        return array_merge([
            ['name' => 'key', 'label' => 'Key', 'type' => 'text', 'required' => true, 'col' => 4],
            ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true, 'col' => 6],
            ['name' => 'status', 'label' => 'Status', 'type' => 'checkbox', 'col' => 2],
            ['name' => 'subtitle', 'label' => 'Subtitle', 'type' => 'textarea', 'rows' => 3, 'col' => 12],
            ['name' => 'button_text', 'label' => 'Button Text', 'type' => 'text', 'col' => 4],
            ['name' => 'input_placeholder', 'label' => 'Input Placeholder', 'type' => 'text', 'col' => 4],
            ['name' => 'privacy_note', 'label' => 'Privacy Note', 'type' => 'text', 'col' => 4],
        ], $this->seoFields());
    }
}
