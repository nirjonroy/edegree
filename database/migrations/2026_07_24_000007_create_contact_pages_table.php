<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('contact_pages', function (Blueprint $table) {
            $table->id();
            $table->string('page_title');
            $table->text('subtitle')->nullable();
            $table->string('details_title')->nullable();
            $table->string('email_label')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_label')->nullable();
            $table->string('phone_1')->nullable();
            $table->string('phone_2')->nullable();
            $table->string('office_label')->nullable();
            $table->string('office_1')->nullable();
            $table->string('office_2')->nullable();
            $table->string('form_title')->nullable();
            $table->string('name_placeholder')->nullable();
            $table->string('email_placeholder')->nullable();
            $table->string('subject_placeholder')->nullable();
            $table->string('message_placeholder')->nullable();
            $table->string('button_text')->nullable();
            $table->string('success_title')->nullable();
            $table->text('success_message')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contact_pages');
    }
};
