<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HasSeoFields;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SliderController extends Controller
{
    use HasSeoFields;

    public function index()
    {
        return view('admin.crud.index', [
            'title' => 'Sliders',
            'routeBase' => '/admin/sliders',
            'records' => Slider::orderBy('sort_order')->latest()->paginate(10),
            'columns' => [
                'id' => 'ID',
                'title' => 'Title',
                'badge_text' => 'Badge',
                'sort_order' => 'Order',
                'status' => 'Status',
                'created_at' => 'Created',
            ],
        ]);
    }

    public function create()
    {
        return $this->form(new Slider([
            'status' => true,
            'primary_tab_text' => 'Find a Program',
            'secondary_tab_text' => 'Find a University',
            'search_placeholder' => 'Search course names, domains or keywords...',
            'button_text' => 'Search',
        ]), 'Create Slider');
    }

    public function store(Request $request)
    {
        Slider::create($this->prepareData($request));

        return redirect('/admin/sliders')->with('success', 'Slider created successfully.');
    }

    public function show(Slider $slider)
    {
        return view('admin.crud.show', [
            'title' => 'Slider Details',
            'routeBase' => '/admin/sliders',
            'record' => $slider,
        ]);
    }

    public function edit(Slider $slider)
    {
        return $this->form($slider, 'Edit Slider');
    }

    public function update(Request $request, Slider $slider)
    {
        $slider->update($this->prepareData($request, $slider));

        return redirect('/admin/sliders')->with('success', 'Slider updated successfully.');
    }

    public function destroy(Slider $slider)
    {
        $this->deleteUpload($slider->image);
        $this->deleteSeoUpload($slider->meta_image);
        $slider->delete();

        return redirect('/admin/sliders')->with('success', 'Slider deleted successfully.');
    }

    private function form(Slider $record, string $title)
    {
        return view('admin.crud.form-page', [
            'title' => $title,
            'routeBase' => '/admin/sliders',
            'record' => $record,
            'fields' => $this->fields(),
        ]);
    }

    private function prepareData(Request $request, ?Slider $slider = null): array
    {
        $data = $request->validate(array_merge([
            'badge_text' => ['nullable', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:4096'],
            'primary_tab_text' => ['required', 'string', 'max:255'],
            'secondary_tab_text' => ['required', 'string', 'max:255'],
            'search_placeholder' => ['nullable', 'string', 'max:255'],
            'button_text' => ['required', 'string', 'max:255'],
            'button_link' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'status' => ['nullable', 'boolean'],
        ], $this->seoValidationRules()));

        $data['status'] = (bool) ($data['status'] ?? false);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        if ($request->hasFile('image')) {
            if ($slider) {
                $this->deleteUpload($slider->image);
            }

            $file = $request->file('image');
            $filename = 'slider-'.time().'-'.uniqid().'.'.$file->getClientOriginalExtension();
            File::ensureDirectoryExists(public_path('uploads/sliders'));
            $file->move(public_path('uploads/sliders'), $filename);
            $data['image'] = 'uploads/sliders/'.$filename;
        } elseif ($slider) {
            unset($data['image']);
        }

        return $this->storeSeoUploads($request, $data, $slider, 'sliders');
    }

    private function fields(): array
    {
        return array_merge([
            ['name' => 'badge_text', 'label' => 'Badge Text', 'type' => 'text', 'col' => 6],
            ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true, 'col' => 6],
            ['name' => 'subtitle', 'label' => 'Subtitle', 'type' => 'textarea', 'rows' => 3, 'col' => 12],
            ['name' => 'image', 'label' => 'Background Image', 'type' => 'file', 'accept' => 'image/*', 'col' => 6],
            ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number', 'col' => 3],
            ['name' => 'status', 'label' => 'Status', 'type' => 'checkbox', 'col' => 3],
            ['name' => 'primary_tab_text', 'label' => 'Primary Tab Text', 'type' => 'text', 'required' => true, 'col' => 6],
            ['name' => 'secondary_tab_text', 'label' => 'Secondary Tab Text', 'type' => 'text', 'required' => true, 'col' => 6],
            ['name' => 'search_placeholder', 'label' => 'Search Placeholder', 'type' => 'text', 'col' => 8],
            ['name' => 'button_text', 'label' => 'Button Text', 'type' => 'text', 'required' => true, 'col' => 4],
            ['name' => 'button_link', 'label' => 'Button Link', 'type' => 'text', 'col' => 12],
        ], $this->seoFields());
    }

    private function deleteUpload(?string $path): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
