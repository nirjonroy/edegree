<div class="card mb-4">
    <div class="card-header"><h3 class="card-title">Information</h3></div>
    <div class="card-body">
        <div class="row g-3">
            @foreach ($fields as $field)
                @php
                    $name = $field['name'];
                    $type = $field['type'] ?? 'text';
                    $value = old($name, data_get($record, $name));
                    if ($type === 'datetime-local' && $value) {
                        $value = \Illuminate\Support\Carbon::parse($value)->format('Y-m-d\TH:i');
                    }
                    if ($type === 'password') {
                        $value = '';
                    }
                @endphp
                <div class="col-md-{{ $field['col'] ?? 6 }}">
                    @if ($type === 'checkbox')
                        <div class="form-check form-switch mt-4">
                            <input type="hidden" name="{{ $name }}" value="0">
                            <input class="form-check-input" type="checkbox" name="{{ $name }}" value="1" id="{{ $name }}" @checked((bool) $value)>
                            <label class="form-check-label" for="{{ $name }}">{{ $field['label'] }}</label>
                        </div>
                    @else
                        <label class="form-label">{{ $field['label'] }} @if (! empty($field['required']))<span class="text-danger">*</span>@endif</label>

                        @if ($type === 'textarea' || $type === 'summernote')
                            <textarea name="{{ $name }}" rows="{{ $field['rows'] ?? 4 }}" class="form-control {{ $type === 'summernote' ? 'js-rich-editor' : '' }}" @required(! empty($field['required']))>{{ $value }}</textarea>
                        @elseif ($type === 'select')
                            <select name="{{ $name }}" class="form-select" @required(! empty($field['required']))>
                                <option value="">Select {{ $field['label'] }}</option>
                                @foreach ($field['options'] ?? [] as $optionValue => $optionLabel)
                                    <option value="{{ $optionValue }}" @selected((string) $value === (string) $optionValue)>{{ $optionLabel }}</option>
                                @endforeach
                            </select>
                        @elseif ($type === 'multiselect')
                            @php($selectedValues = collect(old($name, $field['value'] ?? $value ?? []))->map(fn ($item) => (string) $item)->all())
                            <select name="{{ $name }}[]" class="form-select" multiple size="{{ $field['size'] ?? 8 }}" @required(! empty($field['required']))>
                                @foreach ($field['options'] ?? [] as $optionValue => $optionLabel)
                                    <option value="{{ $optionValue }}" @selected(in_array((string) $optionValue, $selectedValues, true))>{{ $optionLabel }}</option>
                                @endforeach
                            </select>
                        @elseif ($type === 'file')
                            <input type="file" name="{{ $name }}" class="form-control" accept="{{ $field['accept'] ?? '' }}" @required(! empty($field['required']))>
                            @if ($value)
                                <div class="mt-2">
                                    @if (($field['preview'] ?? 'image') === 'file' || \Illuminate\Support\Str::endsWith(strtolower($value), '.pdf'))
                                        <a href="/{{ $value }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                                            <i class="bi bi-file-earmark-text"></i> View File
                                        </a>
                                    @else
                                        <img src="/{{ $value }}" alt="{{ $field['label'] }}" class="img-thumbnail" style="max-height: 90px">
                                    @endif
                                </div>
                            @endif
                        @else
                            <input type="{{ $type }}" name="{{ $name }}" value="{{ $value }}" class="form-control" @required(! empty($field['required']))>
                        @endif
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    <div class="card-footer text-end">
        <a href="{{ $routeBase }}" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">{{ $record->exists ? 'Update' : 'Create' }}</button>
    </div>
</div>

@once
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                if (window.tinymce) {
                    tinymce.init({
                        selector: 'textarea.js-rich-editor',
                        height: 460,
                        menubar: 'file edit view insert format tools table help',
                        branding: false,
                        promotion: false,
                        license_key: 'gpl',
                        plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
                        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | forecolor backcolor removeformat | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media table blockquote code fullscreen preview',
                        toolbar_mode: 'sliding',
                        contextmenu: 'link image table',
                        image_advtab: true,
                        automatic_uploads: false,
                        relative_urls: false,
                        remove_script_host: false,
                        convert_urls: false,
                        content_style: 'body { font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; font-size: 16px; line-height: 1.7; color: #1f2937; } h1,h2,h3,h4 { color: #111827; font-weight: 700; } blockquote { border-left: 4px solid #dc3545; margin-left: 0; padding-left: 1rem; font-style: italic; }',
                    });
                }
            });
        </script>
    @endpush
@endonce
