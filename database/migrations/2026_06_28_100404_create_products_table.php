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
       Schema::create('products', function (Blueprint $table) {
    $table->id();

    $table->foreignId('category_id')
        ->nullable()
        ->constrained('categories')
        ->nullOnDelete();

    $table->string('name');
    $table->string('slug')->unique();

    $table->string('image')->nullable();
    $table->string('file')->nullable();

    $table->decimal('price', 12, 2)->default(0);

    // Controlled date for magazine/product publication
    $table->date('published_at')->nullable();

    $table->longText('desc')->nullable();

    $table->enum('status', [
        'draft',
        'published',
        'archived',
    ])->default('draft');

    $table->enum('competition_status', [
        'none',
        'active',
        'closed',
    ])->default('none');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
