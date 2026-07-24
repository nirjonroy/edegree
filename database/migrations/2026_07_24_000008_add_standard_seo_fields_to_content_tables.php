<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $columnsByTable = [
        'abouts' => ['seo_title', 'seo_description', 'meta_image', 'author', 'publisher', 'copyright', 'site_name', 'keywords', 'robots', 'canonical_url'],
        'contact_pages' => ['seo_title', 'seo_description', 'meta_image', 'author', 'publisher', 'copyright', 'site_name', 'keywords', 'robots', 'canonical_url'],
        'custom_pages' => ['seo_title', 'seo_description', 'author', 'publisher', 'copyright', 'site_name', 'keywords', 'robots'],
        'news' => ['seo_title', 'seo_description', 'publisher', 'copyright', 'site_name', 'keywords', 'robots'],
        'universities' => ['seo_title', 'seo_description', 'meta_image', 'author', 'publisher', 'copyright', 'site_name', 'robots', 'canonical_url'],
        'programs' => ['seo_title', 'seo_description', 'meta_image', 'copyright', 'site_name', 'robots'],
        'blog_posts' => ['seo_title', 'seo_description', 'robots', 'canonical_url'],
        'program_categories' => ['seo_title', 'seo_description', 'meta_title', 'meta_description', 'meta_image', 'author', 'publisher', 'copyright', 'site_name', 'keywords', 'robots', 'canonical_url'],
        'blog_categories' => ['seo_title', 'seo_description', 'meta_title', 'meta_description', 'meta_image', 'author', 'publisher', 'copyright', 'site_name', 'keywords', 'robots', 'canonical_url'],
        'blog_pages' => ['seo_title', 'seo_description', 'meta_title', 'meta_description', 'meta_image', 'author', 'publisher', 'copyright', 'site_name', 'keywords', 'robots', 'canonical_url'],
        'sliders' => ['seo_title', 'seo_description', 'meta_title', 'meta_description', 'meta_image', 'author', 'publisher', 'copyright', 'site_name', 'keywords', 'robots', 'canonical_url'],
        'home_sections' => ['seo_title', 'seo_description', 'meta_title', 'meta_description', 'meta_image', 'author', 'publisher', 'copyright', 'site_name', 'keywords', 'robots', 'canonical_url'],
        'home_testimonials' => ['seo_title', 'seo_description', 'meta_title', 'meta_description', 'meta_image', 'author', 'publisher', 'copyright', 'site_name', 'keywords', 'robots', 'canonical_url'],
        'home_partners' => ['seo_title', 'seo_description', 'meta_title', 'meta_description', 'meta_image', 'author', 'publisher', 'copyright', 'site_name', 'keywords', 'robots', 'canonical_url'],
    ];

    public function up(): void
    {
        foreach ($this->columnsByTable as $tableName => $columns) {
            if (! Schema::hasTable($tableName)) {
                continue;
            }

            $missingColumns = array_values(array_filter(
                $columns,
                fn (string $column): bool => ! Schema::hasColumn($tableName, $column)
            ));

            if ($missingColumns === []) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($missingColumns) {
                foreach ($missingColumns as $column) {
                    match ($column) {
                        'seo_description', 'meta_description', 'keywords' => $table->text($column)->nullable(),
                        default => $table->string($column)->nullable(),
                    };
                }
            });
        }
    }

    public function down(): void
    {
        foreach ($this->columnsByTable as $tableName => $columns) {
            if (! Schema::hasTable($tableName)) {
                continue;
            }

            $existingColumns = array_values(array_filter(
                $columns,
                fn (string $column): bool => Schema::hasColumn($tableName, $column)
            ));

            if ($existingColumns === []) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($existingColumns) {
                $table->dropColumn($existingColumns);
            });
        }
    }
};
