<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('page_visits', function (Blueprint $table) {
            $table->string('visitor_id')->nullable()->after('user_id')->index();
            $table->boolean('is_frontend')->default(false)->after('mac_address')->index();
        });
    }

    public function down()
    {
        Schema::table('page_visits', function (Blueprint $table) {
            $table->dropIndex(['visitor_id']);
            $table->dropIndex(['is_frontend']);
            $table->dropColumn(['visitor_id', 'is_frontend']);
        });
    }
};
