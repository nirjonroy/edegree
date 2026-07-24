<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('custom_pages', function (Blueprint $table) {
            $table->string('desired_url')->nullable()->unique()->after('slug');
            $table->string('subtitle')->nullable()->after('desired_url');
            $table->text('short_description')->nullable()->after('subtitle');
            $table->string('background_image')->nullable()->after('description');
            $table->timestamp('published_at')->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('custom_pages', function (Blueprint $table) {
            $table->dropUnique(['desired_url']);
            $table->dropColumn([
                'desired_url',
                'subtitle',
                'short_description',
                'background_image',
                'published_at',
            ]);
        });
    }
};
