<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siteinfo', function (Blueprint $table) {
            foreach (['body_scripts', 'footer_scripts'] as $column) {
                if (Schema::hasColumn('siteinfo', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table('blog_pages', function (Blueprint $table) {
            if (Schema::hasColumn('blog_pages', 'hero_background_source')) {
                $table->dropColumn('hero_background_source');
            }
        });
    }

    public function down(): void
    {
        Schema::table('siteinfo', function (Blueprint $table) {
            if (! Schema::hasColumn('siteinfo', 'body_scripts')) {
                $table->longText('body_scripts')->nullable()->after('head_scripts');
            }

            if (! Schema::hasColumn('siteinfo', 'footer_scripts')) {
                $table->longText('footer_scripts')->nullable()->after('body_scripts');
            }
        });

        Schema::table('blog_pages', function (Blueprint $table) {
            if (! Schema::hasColumn('blog_pages', 'hero_background_source')) {
                $table->string('hero_background_source')->nullable()->after('hero_background_path');
            }
        });
    }
};
