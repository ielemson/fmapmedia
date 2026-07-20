<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('details')->nullable();
            $table->text('summary')->nullable();

            $table->string('image')->nullable();
            $table->string('image_caption')->nullable();

            $table->foreignId('category_id')
                ->nullable()
                ->constrained('news_categories')
                ->nullOnDelete();

            $table->enum('status', [
                'draft',
                'pending',
                'published',
                'archived',
            ])->default('draft');

            $table->enum('type', [
                'news',
                'article',
                'opinion',
                'editorial',
                'interview',
                'press_release',
                'video',
                'photo_news',
            ])->default('news');

            $table->boolean('featured')->default(false);
            $table->boolean('breaking')->default(false);
            $table->boolean('headline')->default(false);
            $table->boolean('trending')->default(false);
            $table->boolean('editors_pick')->default(false);

            $table->unsignedBigInteger('view_count')->default(0);

            $table->foreignId('author_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Useful for importing old live-server records
            $table->string('old_id')->nullable()->index();
            $table->string('old_image')->nullable();
            $table->string('source')->nullable();

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();

            $table->timestamp('published_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'published_at']);
            $table->index(['category_id', 'status']);
            $table->index(['featured', 'status']);
            $table->index(['breaking', 'status']);
            $table->index(['headline', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
