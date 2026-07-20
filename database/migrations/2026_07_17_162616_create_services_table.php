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
        Schema::create('services', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Basic service information
            |--------------------------------------------------------------------------
            */

            $table->string('title');

            $table->string('slug')->unique();

            $table->string('icon')->nullable();
            // Example: fas fa-bullhorn, flaticon-consulting

            $table->string('image')->nullable();

            $table->text('short_description')->nullable();

            $table->longText('description')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Call-to-action
            |--------------------------------------------------------------------------
            */

            $table->string('button_text')->nullable();

            $table->string('button_url')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Display controls
            |--------------------------------------------------------------------------
            */

            $table->unsignedInteger('display_order')->default(0);

            $table->boolean('is_featured')->default(false);

            $table->boolean('is_active')->default(true);

            $table->timestamp('published_at')->nullable();

            /*
            |--------------------------------------------------------------------------
            | SEO information
            |--------------------------------------------------------------------------
            */

            $table->string('meta_title')->nullable();

            $table->text('meta_description')->nullable();

            $table->string('meta_keywords')->nullable();

            $table->timestamps();

            $table->softDeletes();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('display_order');
            $table->index('is_active');
            $table->index('is_featured');
            $table->index('published_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};