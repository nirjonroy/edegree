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
                            <textarea name="{{ $name }}" rows="{{ $field['rows'] ?? 4 }}" class="form-control {{ $type === 'summernote' ? 'js-summernote' : '' }}" @required(! empty($field['required']))>{{ $value }}</textarea>
                        @elseif ($type === 'select')
                            <select name="{{ $name }}" class="form-select" @required(! empty($field['required']))>
                                <option value="">Select {{ $field['label'] }}</option>
                                @foreach ($field['options'] ?? [] as $optionValue => $optionLabel)
                                    <option value="{{ $optionValue }}" @selected((string) $value === (string) $optionValue)>{{ $optionLabel }}</option>
                                @endforeach
                            </select>
                        @elseif ($type === 'file')
                            <input type="file" name="{{ $name }}" class="form-control" accept="{{ $field['accept'] ?? '' }}" @required(! empty($field['required']))>
                            @if ($value)
                                <div class="mt-2">
                                    <img src="/{{ $value }}" alt="{{ $field['label'] }}" class="img-thumbnail" style="max-height: 90px">
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
                if (window.jQuery && jQuery.fn.summernote) {
                    jQuery('.js-summernote').summernote({
                        height: 240,
                        toolbar: [
                            ['style', ['style']],
                            ['font', ['bold', 'italic', 'underline', 'clear']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['insert', ['link', 'picture']],
                            ['view', ['fullscreen', 'codeview']],
                        ],
                    });
                }
            });
        </script>
    @endpush
@endonce
