<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('programs', function (Blueprint $table) {
            $columns = [
                'image' => fn (Blueprint $table) => $table->string('image')->nullable()->after('syllabus_pdf'),
                'overview_title' => fn (Blueprint $table) => $table->string('overview_title')->nullable()->after('long_description'),
                'curriculum_title' => fn (Blueprint $table) => $table->string('curriculum_title')->nullable()->after('overview_title'),
                'curriculum_description' => fn (Blueprint $table) => $table->longText('curriculum_description')->nullable()->after('curriculum_title'),
                'eligibility_title' => fn (Blueprint $table) => $table->string('eligibility_title')->nullable()->after('curriculum_description'),
                'eligibility_description' => fn (Blueprint $table) => $table->longText('eligibility_description')->nullable()->after('eligibility_title'),
                'documents_required' => fn (Blueprint $table) => $table->longText('documents_required')->nullable()->after('eligibility_description'),
                'fees_title' => fn (Blueprint $table) => $table->string('fees_title')->nullable()->after('documents_required'),
                'fees_description' => fn (Blueprint $table) => $table->longText('fees_description')->nullable()->after('fees_title'),
                'scholarship_title' => fn (Blueprint $table) => $table->string('scholarship_title')->nullable()->after('fees_description'),
                'scholarship_description' => fn (Blueprint $table) => $table->text('scholarship_description')->nullable()->after('scholarship_title'),
                'outcomes_title' => fn (Blueprint $table) => $table->string('outcomes_title')->nullable()->after('scholarship_description'),
                'outcomes_description' => fn (Blueprint $table) => $table->longText('outcomes_description')->nullable()->after('outcomes_title'),
                'delivery_mode' => fn (Blueprint $table) => $table->string('delivery_mode')->nullable()->after('duration'),
                'advisor_title' => fn (Blueprint $table) => $table->string('advisor_title')->nullable()->after('outcomes_description'),
                'advisor_description' => fn (Blueprint $table) => $table->text('advisor_description')->nullable()->after('advisor_title'),
                'apply_button_text' => fn (Blueprint $table) => $table->string('apply_button_text')->nullable()->after('advisor_description'),
            ];

            foreach ($columns as $name => $definition) {
                if (! Schema::hasColumn('programs', $name)) {
                    $definition($table);
                }
            }
        });
    }

    public function down()
    {
        Schema::table('programs', function (Blueprint $table) {
            foreach ([
                'image',
                'overview_title',
                'curriculum_title',
                'curriculum_description',
                'eligibility_title',
                'eligibility_description',
                'documents_required',
                'fees_title',
                'fees_description',
                'scholarship_title',
                'scholarship_description',
                'outcomes_title',
                'outcomes_description',
                'delivery_mode',
                'advisor_title',
                'advisor_description',
                'apply_button_text',
            ] as $column) {
                if (Schema::hasColumn('programs', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
