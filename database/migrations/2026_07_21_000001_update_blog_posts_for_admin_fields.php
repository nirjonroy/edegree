<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            if (! Schema::hasColumn('blog_posts', 'image')) {
                $table->string('image')->nullable()->after('quote');
            }

            if (! Schema::hasColumn('blog_posts', 'short_description')) {
                $table->text('short_description')->nullable()->after('image');
            }

            if (! Schema::hasColumn('blog_posts', 'long_description')) {
                $table->longText('long_description')->nullable()->after('short_description');
            }

            if (! Schema::hasColumn('blog_posts', 'meta_title')) {
                $table->string('meta_title')->nullable()->after('featured_image_source');
            }

            if (! Schema::hasColumn('blog_posts', 'meta_image')) {
                $table->string('meta_image')->nullable()->after('meta_description');
            }

            if (! Schema::hasColumn('blog_posts', 'author')) {
                $table->string('author')->nullable()->after('meta_image');
            }

            if (! Schema::hasColumn('blog_posts', 'publisher')) {
                $table->string('publisher')->nullable()->after('author');
            }

            if (! Schema::hasColumn('blog_posts', 'copyright')) {
                $table->string('copyright')->nullable()->after('publisher');
            }

            if (! Schema::hasColumn('blog_posts', 'site_name')) {
                $table->string('site_name')->nullable()->after('copyright');
            }

            if (! Schema::hasColumn('blog_posts', 'keywords')) {
                $table->text('keywords')->nullable()->after('site_name');
            }

            if (! Schema::hasColumn('blog_posts', 'description')) {
                $table->text('description')->nullable()->after('keywords');
            }

            if (! Schema::hasColumn('blog_posts', 'status')) {
                $table->string('status')->default('draft')->after('description');
            }
        });
    }

    public function down()
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            foreach ([
                'status',
                'description',
                'keywords',
                'site_name',
                'copyright',
                'publisher',
                'author',
                'meta_image',
                'meta_title',
                'long_description',
                'short_description',
                'image',
            ] as $column) {
                if (Schema::hasColumn('blog_posts', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
