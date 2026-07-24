<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('siteinfo', function (Blueprint $table) {
            $table->string('google_site_verification')->nullable()->after('footer_contact_note');
            $table->longText('head_scripts')->nullable()->after('google_site_verification');
            $table->longText('body_scripts')->nullable()->after('head_scripts');
            $table->longText('footer_scripts')->nullable()->after('body_scripts');
        });
    }

    public function down()
    {
        Schema::table('siteinfo', function (Blueprint $table) {
            $table->dropColumn([
                'google_site_verification',
                'head_scripts',
                'body_scripts',
                'footer_scripts',
            ]);
        });
    }
};
