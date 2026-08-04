<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siteinfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SiteinfoController extends Controller
{
    public function index()
    {
        $siteinfos = Siteinfo::latest()->paginate(10);

        return view('admin.siteinfo.index', compact('siteinfos'));
    }

    public function create()
    {
        return view('admin.siteinfo.create', [
            'siteinfo' => new Siteinfo($this->defaults()),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data = $this->normalizeBooleans($data);
        $data = $this->storeUploads($request, $data);

        Siteinfo::create($data);

        return redirect('/admin/siteinfo')->with('success', 'Site info created successfully.');
    }

    public function show(Siteinfo $siteinfo)
    {
        return view('admin.siteinfo.show', compact('siteinfo'));
    }

    public function edit(Siteinfo $siteinfo)
    {
        return view('admin.siteinfo.edit', compact('siteinfo'));
    }

    public function update(Request $request, Siteinfo $siteinfo)
    {
        $data = $this->validatedData($request);
        $data = $this->normalizeBooleans($data);
        $data = $this->storeUploads($request, $data, $siteinfo);

        $siteinfo->update($data);

        return redirect('/admin/siteinfo')->with('success', 'Site info updated successfully.');
    }

    public function destroy(Siteinfo $siteinfo)
    {
        $this->deleteUpload($siteinfo->logo);
        $this->deleteUpload($siteinfo->favicon);
        $this->deleteUpload($siteinfo->default_meta_image);
        $siteinfo->delete();

        return redirect('/admin/siteinfo')->with('success', 'Site info deleted successfully.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'google_location' => ['nullable', 'string'],
            'footer_google_location' => ['nullable', 'string'],
            'footer_contact_note' => ['nullable', 'string'],
            'google_site_verification' => ['nullable', 'string', 'max:255'],
            'head_scripts' => ['nullable', 'string'],
            'maintenance_mode' => ['nullable', 'boolean'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'logo_width' => ['nullable', 'integer', 'min:0'],
            'favicon' => ['nullable', 'image', 'max:1024'],
            'default_meta_image' => ['nullable', 'image', 'max:2048'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'enable_user_register' => ['nullable', 'boolean'],
            'phone_number_required' => ['nullable', 'boolean'],
            'enable_save_contact_message' => ['nullable', 'boolean'],
            'text_direction' => ['required', 'in:ltr,rtl'],
            'default_theme' => ['required', 'in:light,dark,auto'],
            'timezone' => ['required', 'string', 'max:255'],
            'sidebar_lg_header' => ['nullable', 'string', 'max:255'],
            'sidebar_sm_header' => ['nullable', 'string', 'max:255'],
            'topbar_phone' => ['nullable', 'string', 'max:255'],
            'topbar_email' => ['nullable', 'email', 'max:255'],
            'default_phone_code' => ['nullable', 'string', 'max:255'],
            'frontend_url' => ['nullable', 'url', 'max:255'],
            'homepage_section_title' => ['nullable', 'string', 'max:255'],
        ]);
    }

    private function normalizeBooleans(array $data): array
    {
        foreach ([
            'maintenance_mode',
            'enable_user_register',
            'phone_number_required',
            'enable_save_contact_message',
        ] as $field) {
            $data[$field] = (bool) ($data[$field] ?? false);
        }

        return $data;
    }

    private function storeUploads(Request $request, array $data, ?Siteinfo $siteinfo = null): array
    {
        foreach (['logo', 'favicon', 'default_meta_image'] as $field) {
            if (! $request->hasFile($field)) {
                unset($data[$field]);
                continue;
            }

            if ($siteinfo) {
                $this->deleteUpload($siteinfo->{$field});
            }

            $file = $request->file($field);
            $filename = $field.'-'.time().'-'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/siteinfo'), $filename);
            $data[$field] = 'uploads/siteinfo/'.$filename;
        }

        return $data;
    }

    private function deleteUpload(?string $path): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }

    private function defaults(): array
    {
        return [
            'maintenance_mode' => false,
            'enable_user_register' => true,
            'phone_number_required' => false,
            'enable_save_contact_message' => true,
            'text_direction' => 'ltr',
            'default_theme' => 'light',
            'timezone' => 'UTC',
            'sidebar_lg_header' => 'eDegree+',
            'sidebar_sm_header' => 'eD+',
        ];
    }
}
