<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HasSeoFields;
use App\Http\Controllers\Controller;
use App\Models\HomePartner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class HomePartnerController extends Controller
{
    use HasSeoFields;

    public function index()
    {
        return view('admin.crud.index', [
            'title' => 'Home Partners',
            'routeBase' => '/admin/home-partners',
            'records' => HomePartner::orderBy('display_order')->latest()->paginate(10),
            'columns' => [
                'id' => 'ID',
                'name' => 'Name',
                'link' => 'Link',
                'display_order' => 'Order',
                'status' => 'Status',
            ],
        ]);
    }

    public function create()
    {
        return $this->form(new HomePartner(['status' => true]), 'Create Partner');
    }

    public function store(Request $request)
    {
        HomePartner::create($this->prepareData($request));

        return redirect('/admin/home-partners')->with('success', 'Partner created successfully.');
    }

    public function show(HomePartner $homePartner)
    {
        return view('admin.crud.show', [
            'title' => 'Partner Details',
            'routeBase' => '/admin/home-partners',
            'record' => $homePartner,
        ]);
    }

    public function edit(HomePartner $homePartner)
    {
        return $this->form($homePartner, 'Edit Partner');
    }

    public function update(Request $request, HomePartner $homePartner)
    {
        $homePartner->update($this->prepareData($request, $homePartner));

        return redirect('/admin/home-partners')->with('success', 'Partner updated successfully.');
    }

    public function destroy(HomePartner $homePartner)
    {
        $this->deleteUpload($homePartner->logo);
        $this->deleteSeoUpload($homePartner->meta_image);
        $homePartner->delete();

        return redirect('/admin/home-partners')->with('success', 'Partner deleted successfully.');
    }

    private function form(HomePartner $record, string $title)
    {
        return view('admin.crud.form-page', [
            'title' => $title,
            'routeBase' => '/admin/home-partners',
            'record' => $record,
            'fields' => $this->fields(),
        ]);
    }

    private function prepareData(Request $request, ?HomePartner $homePartner = null): array
    {
        $data = $request->validate(array_merge([
            'name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'link' => ['nullable', 'string', 'max:255'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'status' => ['nullable', 'boolean'],
        ], $this->seoValidationRules()));

        $data['status'] = (bool) ($data['status'] ?? false);
        $data['display_order'] = (int) ($data['display_order'] ?? 0);

        if ($request->hasFile('logo')) {
            if ($homePartner) {
                $this->deleteUpload($homePartner->logo);
            }

            $file = $request->file('logo');
            $filename = 'partner-'.time().'-'.uniqid().'.'.$file->getClientOriginalExtension();
            File::ensureDirectoryExists(public_path('uploads/home-partners'));
            $file->move(public_path('uploads/home-partners'), $filename);
            $data['logo'] = 'uploads/home-partners/'.$filename;
        } elseif ($homePartner) {
            unset($data['logo']);
        }

        return $this->storeSeoUploads($request, $data, $homePartner, 'home-partners');
    }

    private function fields(): array
    {
        return array_merge([
            ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'required' => true, 'col' => 6],
            ['name' => 'link', 'label' => 'Link', 'type' => 'url', 'col' => 6],
            ['name' => 'logo', 'label' => 'Logo', 'type' => 'file', 'accept' => 'image/*', 'col' => 6],
            ['name' => 'display_order', 'label' => 'Display Order', 'type' => 'number', 'col' => 3],
            ['name' => 'status', 'label' => 'Status', 'type' => 'checkbox', 'col' => 3],
        ], $this->seoFields());
    }

    private function deleteUpload(?string $path): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
