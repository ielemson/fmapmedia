<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gallery_albums', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Event Information
            |--------------------------------------------------------------------------
            */

            $table->string('title');
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable();
            $table->string('event_type')->nullable();

            $table->date('event_date')->nullable();
            $table->date('end_date')->nullable();

            $table->string('venue')->nullable();
            $table->string('location')->nullable();
            $table->string('organizer')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Event Content
            |--------------------------------------------------------------------------
            */

            $table->text('excerpt')->nullable();
            $table->longText('report')->nullable();
            $table->string('cover_image')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Publishing
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'draft',
                'published',
                'archived',
            ])->default('draft');

            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamp('published_at')->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Database Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('status');
            $table->index('event_date');
            $table->index('published_at');
            $table->index(['status', 'is_featured']);
            $table->index(['status', 'published_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery_albums');
    }
};