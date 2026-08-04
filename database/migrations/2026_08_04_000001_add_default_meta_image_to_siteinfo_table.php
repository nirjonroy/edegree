<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siteinfo', function (Blueprint $table) {
            if (! Schema::hasColumn('siteinfo', 'default_meta_image')) {
                $table->string('default_meta_image')->nullable()->after('favicon');
            }
        });

        if (Schema::hasTable('sliders') && Schema::hasColumn('sliders', 'meta_image')) {
            $sliderMetaImage = DB::table('sliders')
                ->whereNotNull('meta_image')
                ->where('meta_image', '!=', '')
                ->latest('id')
                ->value('meta_image');

            if ($sliderMetaImage) {
                DB::table('siteinfo')
                    ->whereNull('default_meta_image')
                    ->update(['default_meta_image' => $sliderMetaImage]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('siteinfo', function (Blueprint $table) {
            if (Schema::hasColumn('siteinfo', 'default_meta_image')) {
                $table->dropColumn('default_meta_image');
            }
        });
    }
};
