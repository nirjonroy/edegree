<?php

namespace App\Http\Controllers\Admin\Concerns;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

trait HasSeoFields
{
    protected function seoValidationRules(array $overrides = []): array
    {
        return array_merge([
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'meta_image' => ['nullable', 'image', 'max:2048'],
            'author' => ['nullable', 'string', 'max:255'],
            'publisher' => ['nullable', 'string', 'max:255'],
            'copyright' => ['nullable', 'string', 'max:255'],
            'site_name' => ['nullable', 'string', 'max:255'],
            'keywords' => ['nullable', 'string'],
            'robots' => ['nullable', 'string', 'max:255'],
            'canonical_url' => ['nullable', 'string', 'max:255'],
        ], $overrides);
    }

    protected function seoFields(array $overrides = []): array
    {
        $fields = [
            ['name' => 'seo_title', 'label' => 'SEO Title', 'type' => 'text', 'col' => 6],
            ['name' => 'seo_description', 'label' => 'SEO Description', 'type' => 'textarea', 'rows' => 3, 'col' => 6],
            ['name' => 'meta_title', 'label' => 'Meta Title', 'type' => 'text', 'col' => 6],
            ['name' => 'meta_description', 'label' => 'Meta Description', 'type' => 'textarea', 'rows' => 3, 'col' => 6],
            ['name' => 'meta_image', 'label' => 'Meta Image', 'type' => 'file', 'accept' => 'image/*', 'col' => 6],
            ['name' => 'author', 'label' => 'Author', 'type' => 'text', 'col' => 6],
            ['name' => 'publisher', 'label' => 'Publisher', 'type' => 'text', 'col' => 6],
            ['name' => 'copyright', 'label' => 'Copyright', 'type' => 'text', 'col' => 6],
            ['name' => 'site_name', 'label' => 'Site Name', 'type' => 'text', 'col' => 6],
            ['name' => 'keywords', 'label' => 'Keywords', 'type' => 'textarea', 'rows' => 3, 'col' => 6],
            ['name' => 'robots', 'label' => 'Robots', 'type' => 'text', 'col' => 6],
            ['name' => 'canonical_url', 'label' => 'Canonical URL', 'type' => 'url', 'col' => 6],
        ];

        foreach ($overrides as $name => $override) {
            foreach ($fields as $index => $field) {
                if ($field['name'] === $name) {
                    $fields[$index] = array_merge($field, $override);
                    break;
                }
            }
        }

        return $fields;
    }

    protected function storeSeoUploads(Request $request, array $data, mixed $record = null, string $directory = 'seo'): array
    {
        if (! $request->hasFile('meta_image')) {
            if ($record) {
                unset($data['meta_image']);
            }

            return $data;
        }

        if ($record && ! empty($record->meta_image)) {
            $this->deleteSeoUpload($record->meta_image);
        }

        $file = $request->file('meta_image');
        $filename = 'meta-image-'.time().'-'.uniqid().'.'.$file->getClientOriginalExtension();
        File::ensureDirectoryExists(public_path('uploads/'.$directory));
        $file->move(public_path('uploads/'.$directory), $filename);
        $data['meta_image'] = 'uploads/'.$directory.'/'.$filename;

        return $data;
    }

    protected function deleteSeoUpload(?string $path): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
