<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('universities', function (Blueprint $table) {
            foreach ($this->columns() as $name => $definition) {
                if (! Schema::hasColumn('universities', $name)) {
                    $definition($table);
                }
            }
        });
    }

    public function down()
    {
        Schema::table('universities', function (Blueprint $table) {
            foreach (array_reverse(array_keys($this->columns())) as $column) {
                if (Schema::hasColumn('universities', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }

    private function columns(): array
    {
        return [
            'location' => fn (Blueprint $table) => $table->string('location')->nullable()->after('link'),
            'founded_year' => fn (Blueprint $table) => $table->string('founded_year')->nullable()->after('location'),
            'ranking_badge' => fn (Blueprint $table) => $table->string('ranking_badge')->nullable()->after('founded_year'),
            'accreditation_badge' => fn (Blueprint $table) => $table->string('accreditation_badge')->nullable()->after('ranking_badge'),
            'degree_badge' => fn (Blueprint $table) => $table->string('degree_badge')->nullable()->after('accreditation_badge'),
            'profile_title' => fn (Blueprint $table) => $table->string('profile_title')->nullable()->after('long_description'),
            'profile_description' => fn (Blueprint $table) => $table->longText('profile_description')->nullable()->after('profile_title'),
            'accomplishment_title' => fn (Blueprint $table) => $table->string('accomplishment_title')->nullable()->after('profile_description'),
            'accomplishment_text' => fn (Blueprint $table) => $table->string('accomplishment_text')->nullable()->after('accomplishment_title'),
            'accreditation_title' => fn (Blueprint $table) => $table->string('accreditation_title')->nullable()->after('accomplishment_text'),
            'accreditation_description' => fn (Blueprint $table) => $table->longText('accreditation_description')->nullable()->after('accreditation_title'),
            'accrediting_commission_title' => fn (Blueprint $table) => $table->string('accrediting_commission_title')->nullable()->after('accreditation_description'),
            'accrediting_commission_text' => fn (Blueprint $table) => $table->text('accrediting_commission_text')->nullable()->after('accrediting_commission_title'),
            'admissions_title' => fn (Blueprint $table) => $table->string('admissions_title')->nullable()->after('accrediting_commission_text'),
            'admissions_description' => fn (Blueprint $table) => $table->longText('admissions_description')->nullable()->after('admissions_title'),
            'reviews_title' => fn (Blueprint $table) => $table->string('reviews_title')->nullable()->after('admissions_description'),
            'review_1_name' => fn (Blueprint $table) => $table->string('review_1_name')->nullable()->after('reviews_title'),
            'review_1_text' => fn (Blueprint $table) => $table->text('review_1_text')->nullable()->after('review_1_name'),
            'review_1_rating' => fn (Blueprint $table) => $table->unsignedTinyInteger('review_1_rating')->nullable()->after('review_1_text'),
            'review_2_name' => fn (Blueprint $table) => $table->string('review_2_name')->nullable()->after('review_1_rating'),
            'review_2_text' => fn (Blueprint $table) => $table->text('review_2_text')->nullable()->after('review_2_name'),
            'review_2_rating' => fn (Blueprint $table) => $table->unsignedTinyInteger('review_2_rating')->nullable()->after('review_2_text'),
            'advisor_title' => fn (Blueprint $table) => $table->string('advisor_title')->nullable()->after('review_2_rating'),
            'advisor_description' => fn (Blueprint $table) => $table->text('advisor_description')->nullable()->after('advisor_title'),
        ];
    }
};
