<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('page_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('session_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable()->index();
            $table->string('mac_address')->nullable();
            $table->string('method', 10)->default('GET');
            $table->string('url');
            $table->string('path')->index();
            $table->string('route_name')->nullable()->index();
            $table->text('user_agent')->nullable();
            $table->string('referer')->nullable();
            $table->timestamp('visited_at')->useCurrent()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('page_visits');
    }
};
