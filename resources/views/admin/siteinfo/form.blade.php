@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card mb-4">
    <div class="card-header"><h3 class="card-title">Brand Settings</h3></div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Site / Admin Name</label>
                <input type="text" name="sidebar_lg_header" value="{{ old('sidebar_lg_header', $siteinfo->sidebar_lg_header) }}" class="form-control" placeholder="eDegree+">
            </div>
            <div class="col-md-3">
                <label class="form-label">Short Name</label>
                <input type="text" name="sidebar_sm_header" value="{{ old('sidebar_sm_header', $siteinfo->sidebar_sm_header) }}" class="form-control" placeholder="eD+">
            </div>
            <div class="col-md-3">
                <label class="form-label">Logo Width</label>
                <input type="number" name="logo_width" value="{{ old('logo_width', $siteinfo->logo_width) }}" class="form-control" min="0" placeholder="Optional">
            </div>
            <div class="col-md-6">
                <label class="form-label">Logo</label>
                <input type="file" name="logo" class="form-control" accept="image/*">
                @if ($siteinfo->logo)
                    <img src="/{{ $siteinfo->logo }}" alt="Logo" class="mt-2 bg-light p-2 rounded" style="max-height: 60px">
                @endif
            </div>
            <div class="col-md-6">
                <label class="form-label">Favicon</label>
                <input type="file" name="favicon" class="form-control" accept="image/*">
                @if ($siteinfo->favicon)
                    <img src="/{{ $siteinfo->favicon }}" alt="Favicon" class="mt-2" style="max-height: 40px">
                @endif
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header"><h3 class="card-title">Contact & Footer</h3></div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Contact Email</label>
                <input type="email" name="contact_email" value="{{ old('contact_email', $siteinfo->contact_email) }}" class="form-control" placeholder="support@example.com">
            </div>
            <div class="col-md-4">
                <label class="form-label">Topbar Email</label>
                <input type="email" name="topbar_email" value="{{ old('topbar_email', $siteinfo->topbar_email) }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">Topbar Phone</label>
                <input type="text" name="topbar_phone" value="{{ old('topbar_phone', $siteinfo->topbar_phone) }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">Default Phone Code</label>
                <input type="text" name="default_phone_code" value="{{ old('default_phone_code', $siteinfo->default_phone_code) }}" class="form-control" placeholder="+1">
            </div>
            <div class="col-md-8">
                <label class="form-label">Frontend URL</label>
                <input type="url" name="frontend_url" value="{{ old('frontend_url', $siteinfo->frontend_url) }}" class="form-control" placeholder="{{ url('/') }}">
            </div>
            <div class="col-12">
                <label class="form-label">Footer Contact Note</label>
                <textarea name="footer_contact_note" rows="3" class="form-control">{{ old('footer_contact_note', $siteinfo->footer_contact_note) }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Google Map Embed</label>
                <textarea name="google_location" rows="4" class="form-control" placeholder="Optional iframe embed code">{{ old('google_location', $siteinfo->google_location) }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Footer Google Map Embed</label>
                <textarea name="footer_google_location" rows="4" class="form-control" placeholder="Optional footer iframe embed code">{{ old('footer_google_location', $siteinfo->footer_google_location) }}</textarea>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header"><h3 class="card-title">Frontend Settings</h3></div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Homepage SEO Title</label>
                <input type="text" name="homepage_section_title" value="{{ old('homepage_section_title', $siteinfo->homepage_section_title) }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">Text Direction</label>
                <select name="text_direction" class="form-select">
                    @foreach (['ltr' => 'LTR', 'rtl' => 'RTL'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('text_direction', $siteinfo->text_direction) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Default Theme</label>
                <select name="default_theme" class="form-select">
                    @foreach (['light' => 'Light', 'dark' => 'Dark', 'auto' => 'Auto'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('default_theme', $siteinfo->default_theme) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Timezone</label>
                <input type="text" name="timezone" value="{{ old('timezone', $siteinfo->timezone) }}" class="form-control">
            </div>
            @foreach ([
                'maintenance_mode' => 'Maintenance Mode',
                'enable_user_register' => 'Enable User Register',
                'phone_number_required' => 'Phone Number Required',
                'enable_save_contact_message' => 'Save Contact Messages',
            ] as $field => $label)
                <div class="col-md-2">
                    <div class="form-check form-switch mt-4">
                        <input type="hidden" name="{{ $field }}" value="0">
                        <input class="form-check-input" type="checkbox" name="{{ $field }}" value="1" id="{{ $field }}" @checked(old($field, $siteinfo->{$field}))>
                        <label class="form-check-label" for="{{ $field }}">{{ $label }}</label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header"><h3 class="card-title">Tracking & Verification Scripts</h3></div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label">Google Search Console Verification</label>
                <input type="text" name="google_site_verification" value="{{ old('google_site_verification', $siteinfo->google_site_verification) }}" class="form-control" placeholder="Paste only the verification content value">
            </div>
            <div class="col-12">
                <label class="form-label">Head Scripts</label>
                <textarea name="head_scripts" rows="5" class="form-control font-monospace" placeholder="Google Analytics, Google Tag Manager head code, meta tags...">{{ old('head_scripts', $siteinfo->head_scripts) }}</textarea>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mb-4">
    <a href="/admin/siteinfo" class="btn btn-secondary">Cancel</a>
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
</div>
