<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HasSeoFields;
use App\Http\Controllers\Controller;
use App\Models\HomeTestimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class HomeTestimonialController extends Controller
{
    use HasSeoFields;

    public function index()
    {
        return view('admin.crud.index', [
            'title' => 'Home Testimonials',
            'routeBase' => '/admin/home-testimonials',
            'records' => HomeTestimonial::orderBy('display_order')->latest()->paginate(10),
            'columns' => [
                'id' => 'ID',
                'name' => 'Name',
                'designation' => 'Designation',
                'rating' => 'Rating',
                'display_order' => 'Order',
                'status' => 'Status',
            ],
        ]);
    }

    public function create()
    {
        return $this->form(new HomeTestimonial(['status' => true, 'rating' => 5]), 'Create Testimonial');
    }

    public function store(Request $request)
    {
        HomeTestimonial::create($this->prepareData($request));

        return redirect('/admin/home-testimonials')->with('success', 'Testimonial created successfully.');
    }

    public function show(HomeTestimonial $homeTestimonial)
    {
        return view('admin.crud.show', [
            'title' => 'Testimonial Details',
            'routeBase' => '/admin/home-testimonials',
            'record' => $homeTestimonial,
        ]);
    }

    public function edit(HomeTestimonial $homeTestimonial)
    {
        return $this->form($homeTestimonial, 'Edit Testimonial');
    }

    public function update(Request $request, HomeTestimonial $homeTestimonial)
    {
        $homeTestimonial->update($this->prepareData($request, $homeTestimonial));

        return redirect('/admin/home-testimonials')->with('success', 'Testimonial updated successfully.');
    }

    public function destroy(HomeTestimonial $homeTestimonial)
    {
        $this->deleteUpload($homeTestimonial->image);
        $this->deleteSeoUpload($homeTestimonial->meta_image);
        $homeTestimonial->delete();

        return redirect('/admin/home-testimonials')->with('success', 'Testimonial deleted successfully.');
    }

    private function form(HomeTestimonial $record, string $title)
    {
        return view('admin.crud.form-page', [
            'title' => $title,
            'routeBase' => '/admin/home-testimonials',
            'record' => $record,
            'fields' => $this->fields(),
        ]);
    }

    private function prepareData(Request $request, ?HomeTestimonial $homeTestimonial = null): array
    {
        $data = $request->validate(array_merge([
            'name' => ['required', 'string', 'max:255'],
            'designation' => ['nullable', 'string', 'max:255'],
            'quote' => ['required', 'string'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'image' => ['nullable', 'image', 'max:2048'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'status' => ['nullable', 'boolean'],
        ], $this->seoValidationRules()));

        $data['status'] = (bool) ($data['status'] ?? false);
        $data['rating'] = (int) ($data['rating'] ?? 5);
        $data['display_order'] = (int) ($data['display_order'] ?? 0);

        if ($request->hasFile('image')) {
            if ($homeTestimonial) {
                $this->deleteUpload($homeTestimonial->image);
            }

            $file = $request->file('image');
            $filename = 'testimonial-'.time().'-'.uniqid().'.'.$file->getClientOriginalExtension();
            File::ensureDirectoryExists(public_path('uploads/home-testimonials'));
            $file->move(public_path('uploads/home-testimonials'), $filename);
            $data['image'] = 'uploads/home-testimonials/'.$filename;
        } elseif ($homeTestimonial) {
            unset($data['image']);
        }

        return $this->storeSeoUploads($request, $data, $homeTestimonial, 'home-testimonials');
    }

    private function fields(): array
    {
        return array_merge([
            ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'required' => true, 'col' => 4],
            ['name' => 'designation', 'label' => 'Designation', 'type' => 'text', 'col' => 4],
            ['name' => 'rating', 'label' => 'Rating', 'type' => 'number', 'col' => 2],
            ['name' => 'status', 'label' => 'Status', 'type' => 'checkbox', 'col' => 2],
            ['name' => 'image', 'label' => 'Image', 'type' => 'file', 'accept' => 'image/*', 'col' => 6],
            ['name' => 'display_order', 'label' => 'Display Order', 'type' => 'number', 'col' => 6],
            ['name' => 'quote', 'label' => 'Quote', 'type' => 'textarea', 'rows' => 4, 'required' => true, 'col' => 12],
        ], $this->seoFields());
    }

    private function deleteUpload(?string $path): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
