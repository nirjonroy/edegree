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
    <div class="card-header"><h3 class="card-title">General Settings</h3></div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Sidebar Large Header</label>
                <input type="text" name="sidebar_lg_header" value="{{ old('sidebar_lg_header', $siteinfo->sidebar_lg_header) }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Sidebar Small Header</label>
                <input type="text" name="sidebar_sm_header" value="{{ old('sidebar_sm_header', $siteinfo->sidebar_sm_header) }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">Contact Email</label>
                <input type="email" name="contact_email" value="{{ old('contact_email', $siteinfo->contact_email) }}" class="form-control">
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
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header"><h3 class="card-title">Location & Footer</h3></div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Google Location</label>
                <textarea name="google_location" rows="4" class="form-control">{{ old('google_location', $siteinfo->google_location) }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Footer Google Location</label>
                <textarea name="footer_google_location" rows="4" class="form-control">{{ old('footer_google_location', $siteinfo->footer_google_location) }}</textarea>
            </div>
            <div class="col-12">
                <label class="form-label">Footer Contact Note</label>
                <textarea name="footer_contact_note" rows="3" class="form-control">{{ old('footer_contact_note', $siteinfo->footer_contact_note) }}</textarea>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header"><h3 class="card-title">Brand Assets</h3></div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Logo</label>
                <input type="file" name="logo" class="form-control">
                @if ($siteinfo->logo)
                    <img src="/{{ $siteinfo->logo }}" alt="Logo" class="mt-2" style="max-height: 60px">
                @endif
            </div>
            <div class="col-md-3">
                <label class="form-label">Logo Width</label>
                <input type="number" name="logo_width" value="{{ old('logo_width', $siteinfo->logo_width) }}" class="form-control" min="0">
            </div>
            <div class="col-md-3">
                <label class="form-label">Logo Height</label>
                <input type="number" name="logo_height" value="{{ old('logo_height', $siteinfo->logo_height) }}" class="form-control" min="0">
            </div>
            <div class="col-md-6">
                <label class="form-label">Favicon</label>
                <input type="file" name="favicon" class="form-control">
                @if ($siteinfo->favicon)
                    <img src="/{{ $siteinfo->favicon }}" alt="Favicon" class="mt-2" style="max-height: 40px">
                @endif
            </div>
            <div class="col-md-3">
                <label class="form-label">Favicon Width</label>
                <input type="number" name="favicon_width" value="{{ old('favicon_width', $siteinfo->favicon_width) }}" class="form-control" min="0">
            </div>
            <div class="col-md-3">
                <label class="form-label">Favicon Height</label>
                <input type="number" name="favicon_height" value="{{ old('favicon_height', $siteinfo->favicon_height) }}" class="form-control" min="0">
            </div>
            <div class="col-md-4">
                <label class="form-label">Image Output Format</label>
                <select name="image_output_format" class="form-select">
                    @foreach (['webp', 'jpg', 'jpeg', 'png'] as $format)
                        <option value="{{ $format }}" @selected(old('image_output_format', $siteinfo->image_output_format) === $format)>{{ strtoupper($format) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header"><h3 class="card-title">Feature Toggles</h3></div>
    <div class="card-body">
        <div class="row g-3">
            @foreach ([
                'maintenance_mode' => 'Maintenance Mode',
                'enable_user_register' => 'Enable User Register',
                'phone_number_required' => 'Phone Number Required',
                'enable_subscription_notify' => 'Enable Subscription Notify',
                'enable_save_contact_message' => 'Enable Save Contact Message',
            ] as $field => $label)
                <div class="col-md-4">
                    <div class="form-check form-switch">
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
    <div class="card-header"><h3 class="card-title">Currency & Frontend</h3></div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Currency Name</label>
                <input type="text" name="currency_name" value="{{ old('currency_name', $siteinfo->currency_name) }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Currency Icon</label>
                <input type="text" name="currency_icon" value="{{ old('currency_icon', $siteinfo->currency_icon) }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Currency Rate</label>
                <input type="number" step="0.0001" name="currency_rate" value="{{ old('currency_rate', $siteinfo->currency_rate) }}" class="form-control" min="0">
            </div>
            <div class="col-md-3">
                <label class="form-label">Default Phone Code</label>
                <input type="text" name="default_phone_code" value="{{ old('default_phone_code', $siteinfo->default_phone_code) }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Frontend URL</label>
                <input type="url" name="frontend_url" value="{{ old('frontend_url', $siteinfo->frontend_url) }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Homepage Section Title</label>
                <input type="text" name="homepage_section_title" value="{{ old('homepage_section_title', $siteinfo->homepage_section_title) }}" class="form-control">
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header"><h3 class="card-title">Image Sizes</h3></div>
    <div class="card-body">
        <div class="row g-3">
            @foreach ([
                'slider' => 'Slider',
                'about_image' => 'About Image',
                'property_image' => 'Property Image',
                'blog_post_image' => 'Blog Post Image',
                'blog_page_image' => 'Blog Page Image',
                'agency_logo' => 'Agency Logo',
            ] as $prefix => $label)
                <div class="col-md-4">
                    <label class="form-label">{{ $label }} Width</label>
                    <input type="number" name="{{ $prefix }}_width" value="{{ old($prefix.'_width', $siteinfo->{$prefix.'_width'}) }}" class="form-control" min="0">
                </div>
                <div class="col-md-4">
                    <label class="form-label">{{ $label }} Height</label>
                    <input type="number" name="{{ $prefix }}_height" value="{{ old($prefix.'_height', $siteinfo->{$prefix.'_height'}) }}" class="form-control" min="0">
                </div>
                <div class="col-md-4 d-none d-md-block"></div>
            @endforeach
        </div>
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mb-4">
    <a href="/admin/siteinfo" class="btn btn-secondary">Cancel</a>
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
</div>
