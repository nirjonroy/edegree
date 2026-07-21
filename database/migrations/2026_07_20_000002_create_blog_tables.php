<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('blog_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->integer('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('blog_pages', function (Blueprint $table) {
            $table->id();
            $table->string('hero_title');
            $table->string('hero_background_path')->nullable();
            $table->string('hero_background_source')->nullable();
            $table->string('home_section_title')->nullable();
            $table->string('categories_title')->nullable();
            $table->string('recommendation_title')->nullable();
            $table->string('latest_posts_title')->nullable();
            $table->string('tags_title')->nullable();
            $table->string('read_button_text')->nullable();
            $table->string('article_tags_title')->nullable();
            $table->string('comments_section_title')->nullable();
            $table->timestamps();
        });

        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_category_id')->nullable()->constrained('blog_categories')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('author_name');
            $table->text('excerpt');
            $table->longText('content');
            $table->text('quote')->nullable();
            $table->string('image')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('long_description')->nullable();
            $table->string('featured_image_path')->nullable();
            $table->string('featured_image_source')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_image')->nullable();
            $table->string('author')->nullable();
            $table->string('publisher')->nullable();
            $table->string('copyright')->nullable();
            $table->string('site_name')->nullable();
            $table->text('keywords')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('draft');
            $table->longText('tags')->nullable();
            $table->longText('comments')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->boolean('is_published')->default(false);
            $table->boolean('show_on_home')->default(false);
            $table->timestamps();
        });

        Schema::create('blog_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_post_id')->nullable()->constrained('blog_posts')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name');
            $table->string('email');
            $table->text('comment');
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('blog_comments');
        Schema::dropIfExists('blog_posts');
        Schema::dropIfExists('blog_pages');
        Schema::dropIfExists('blog_categories');
    }
};
