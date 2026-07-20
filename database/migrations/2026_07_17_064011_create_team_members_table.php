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
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | User relationship
            |--------------------------------------------------------------------------
            |
            | Each team profile belongs to one registered user.
            | The unique constraint prevents a user from having multiple
            | team-member profiles.
            |
            */

            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Team profile information
            |--------------------------------------------------------------------------
            */

            $table->string('slug')->unique();

            $table->string('title')->nullable();
            // Dr., Prof., Mr., Mrs., Engr., Barr., etc.

            $table->string('position');
            // Founder/CEO, Editor-in-Chief, ICT Manager, etc.

            $table->string('department')->nullable();
            // Management, Editorial, ICT, Marketing, etc.

            $table->string('image')->nullable();

            $table->text('short_bio')->nullable();

            $table->longText('bio')->nullable();

            $table->string('qualification')->nullable();

            $table->string('specialization')->nullable();

            $table->unsignedSmallInteger('years_of_experience')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Optional social links
            |--------------------------------------------------------------------------
            */

            $table->string('website')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('youtube')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Display controls
            |--------------------------------------------------------------------------
            */

            $table->unsignedInteger('display_order')->default(0);

            $table->boolean('is_featured')->default(false);

            $table->boolean('is_active')->default(true);

            $table->timestamp('published_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('department');
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
        Schema::dropIfExists('team_members');
    }
};