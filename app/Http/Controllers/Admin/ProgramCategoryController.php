<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HasSeoFields;
use App\Http\Controllers\Controller;
use App\Models\ProgramCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProgramCategoryController extends Controller
{
    use HasSeoFields;

    public function index()
    {
        return view('admin.crud.index', [
            'title' => 'Program Categories',
            'routeBase' => '/admin/program-categories',
            'records' => ProgramCategory::latest()->paginate(10),
            'columns' => ['id' => 'ID', 'name' => 'Name', 'slug' => 'Slug', 'status' => 'Status', 'created_at' => 'Created'],
        ]);
    }

    public function create()
    {
        return $this->form(new ProgramCategory(['status' => true]), 'Create Program Category');
    }

    public function store(Request $request)
    {
        ProgramCategory::create($this->validated($request));

        return redirect('/admin/program-categories')->with('success', 'Program category created successfully.');
    }

    public function show(ProgramCategory $programCategory)
    {
        return view('admin.crud.show', [
            'title' => 'Program Category Details',
            'routeBase' => '/admin/program-categories',
            'record' => $programCategory,
        ]);
    }

    public function edit(ProgramCategory $programCategory)
    {
        return $this->form($programCategory, 'Edit Program Category');
    }

    public function update(Request $request, ProgramCategory $programCategory)
    {
        $programCategory->update($this->validated($request, $programCategory));

        return redirect('/admin/program-categories')->with('success', 'Program category updated successfully.');
    }

    public function destroy(ProgramCategory $programCategory)
    {
        $this->deleteSeoUpload($programCategory->meta_image);
        $programCategory->delete();

        return redirect('/admin/program-categories')->with('success', 'Program category deleted successfully.');
    }

    private function form(ProgramCategory $record, string $title)
    {
        return view('admin.crud.form-page', [
            'title' => $title,
            'routeBase' => '/admin/program-categories',
            'record' => $record,
            'fields' => $this->fields(),
        ]);
    }

    private function validated(Request $request, ?ProgramCategory $programCategory = null): array
    {
        $data = $request->validate(array_merge([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('program_categories')->ignore($programCategory)],
            'status' => ['nullable', 'boolean'],
        ], $this->seoValidationRules()));

        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['status'] = (bool) ($data['status'] ?? false);

        return $this->storeSeoUploads($request, $data, $programCategory, 'program-categories');
    }

    private function fields(): array
    {
        return array_merge([
            ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'required' => true, 'col' => 6],
            ['name' => 'slug', 'label' => 'Slug', 'type' => 'text', 'col' => 6],
            ['name' => 'status', 'label' => 'Status', 'type' => 'checkbox', 'col' => 6],
        ], $this->seoFields());
    }
}
