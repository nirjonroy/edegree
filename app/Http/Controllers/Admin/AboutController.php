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
                'image_1' => 'Image 1',
                'image_2' => 'Image 2',
                'image_3' => 'Image 3',
                'about_us' => 'About Us',
            ],
        ]);
    }

    public function create()
    {
        return $this->form(new About(), 'Create About');
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
        foreach (['image_1', 'image_2', 'image_3'] as $field) {
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
            'about_us' => ['nullable', 'string'],
        ]);
    }

    private function fields(): array
    {
        return [
            ['name' => 'image_1', 'label' => 'Image 1', 'type' => 'file', 'accept' => 'image/*', 'col' => 4],
            ['name' => 'image_2', 'label' => 'Image 2', 'type' => 'file', 'accept' => 'image/*', 'col' => 4],
            ['name' => 'image_3', 'label' => 'Image 3', 'type' => 'file', 'accept' => 'image/*', 'col' => 4],
            ['name' => 'about_us', 'label' => 'About Us', 'type' => 'summernote', 'rows' => 8, 'col' => 12],
        ];
    }

    private function storeUploads(Request $request, array $data, ?About $about = null): array
    {
        foreach (['image_1', 'image_2', 'image_3'] as $field) {
            if (! $request->hasFile($field)) {
                unset($data[$field]);
                continue;
            }

            if ($about) {
                $this->deleteUpload($about->{$field});
            }

            $file = $request->file($field);
            $filename = $field.'-'.time().'-'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/abouts'), $filename);
            $data[$field] = 'uploads/abouts/'.$filename;
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
