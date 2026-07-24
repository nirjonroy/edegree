<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('abouts', function (Blueprint $table) {
            $table->string('page_title')->nullable()->after('id');
            $table->string('profile_title')->nullable()->after('page_title');
            $table->string('stat_1_value')->nullable()->after('about_us');
            $table->string('stat_1_label')->nullable()->after('stat_1_value');
            $table->string('stat_2_value')->nullable()->after('stat_1_label');
            $table->string('stat_2_label')->nullable()->after('stat_2_value');
            $table->string('stat_3_value')->nullable()->after('stat_2_label');
            $table->string('stat_3_label')->nullable()->after('stat_3_value');
            $table->string('faq_title')->nullable()->after('stat_3_label');
            $table->string('faq_question_1')->nullable()->after('faq_title');
            $table->text('faq_answer_1')->nullable()->after('faq_question_1');
            $table->string('faq_question_2')->nullable()->after('faq_answer_1');
            $table->text('faq_answer_2')->nullable()->after('faq_question_2');
            $table->string('faq_question_3')->nullable()->after('faq_answer_2');
            $table->text('faq_answer_3')->nullable()->after('faq_question_3');
            $table->string('meta_title')->nullable()->after('faq_answer_3');
            $table->string('meta_description')->nullable()->after('meta_title');
            $table->boolean('status')->default(true)->after('meta_description');
        });
    }

    public function down()
    {
        Schema::table('abouts', function (Blueprint $table) {
            $table->dropColumn([
                'page_title',
                'profile_title',
                'stat_1_value',
                'stat_1_label',
                'stat_2_value',
                'stat_2_label',
                'stat_3_value',
                'stat_3_label',
                'faq_title',
                'faq_question_1',
                'faq_answer_1',
                'faq_question_2',
                'faq_answer_2',
                'faq_question_3',
                'faq_answer_3',
                'meta_title',
                'meta_description',
                'status',
            ]);
        });
    }
};
