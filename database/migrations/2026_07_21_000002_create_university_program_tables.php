<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('universities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('link')->nullable();
            $table->string('location')->nullable();
            $table->string('founded_year')->nullable();
            $table->string('ranking_badge')->nullable();
            $table->string('accreditation_badge')->nullable();
            $table->string('degree_badge')->nullable();
            $table->boolean('status')->nullable();
            $table->boolean('is_done')->default(false);
            $table->unsignedInteger('priority')->nullable();
            $table->string('slider1')->nullable();
            $table->string('slider2')->nullable();
            $table->string('slider3')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('long_description')->nullable();
            $table->string('profile_title')->nullable();
            $table->longText('profile_description')->nullable();
            $table->string('accomplishment_title')->nullable();
            $table->string('accomplishment_text')->nullable();
            $table->string('accreditation_title')->nullable();
            $table->longText('accreditation_description')->nullable();
            $table->string('accrediting_commission_title')->nullable();
            $table->text('accrediting_commission_text')->nullable();
            $table->string('admissions_title')->nullable();
            $table->longText('admissions_description')->nullable();
            $table->string('reviews_title')->nullable();
            $table->string('review_1_name')->nullable();
            $table->text('review_1_text')->nullable();
            $table->unsignedTinyInteger('review_1_rating')->nullable();
            $table->string('review_2_name')->nullable();
            $table->text('review_2_text')->nullable();
            $table->unsignedTinyInteger('review_2_rating')->nullable();
            $table->string('advisor_title')->nullable();
            $table->text('advisor_description')->nullable();
            $table->string('rated')->nullable();
            $table->string('global_network')->nullable();
            $table->string('award')->nullable();
            $table->string('rank')->nullable();
            $table->string('image_1')->nullable();
            $table->string('image_2')->nullable();
            $table->string('image_3')->nullable();
            $table->string('image_4')->nullable();
            $table->string('image_5')->nullable();
            $table->string('faq_question_1')->nullable();
            $table->string('faq_question_2')->nullable();
            $table->string('faq_question_3')->nullable();
            $table->string('faq_question_4')->nullable();
            $table->string('faq_question_5')->nullable();
            $table->text('faq_answer_1')->nullable();
            $table->text('faq_answer_2')->nullable();
            $table->text('faq_answer_3')->nullable();
            $table->text('faq_answer_4')->nullable();
            $table->text('faq_answer_5')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->text('keywords')->nullable();
            $table->timestamps();
        });

        Schema::create('program_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->boolean('status')->nullable();
            $table->timestamps();
        });

        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('degree_id')->nullable()->constrained('program_categories')->nullOnDelete();
            $table->foreignId('university_id')->nullable()->constrained('universities')->nullOnDelete();
            $table->string('type')->nullable();
            $table->string('program');
            $table->string('short_name')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('long_description')->nullable();
            $table->string('slug')->unique();
            $table->string('total_fee')->nullable();
            $table->string('yearly')->nullable();
            $table->string('duration')->nullable();
            $table->string('link')->nullable();
            $table->string('syllabus_pdf')->nullable();
            $table->boolean('status')->nullable();
            $table->boolean('recommend')->default(false);
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->text('keywords')->nullable();
            $table->string('canonical_url')->nullable();
            $table->string('author')->nullable();
            $table->string('publisher')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('programs');
        Schema::dropIfExists('program_categories');
        Schema::dropIfExists('universities');
    }
};
