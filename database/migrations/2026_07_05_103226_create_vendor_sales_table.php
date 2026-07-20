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
        Schema::create('vendor_sales', function (Blueprint $table) {
    $table->id();

    $table->foreignId('vendor_id')->constrained()->cascadeOnDelete();

    $table->unsignedBigInteger('order_id')->nullable();

    $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();

    $table->foreignId('user_id')
        ->nullable()
        ->constrained('users')
        ->nullOnDelete();

    $table->unsignedInteger('quantity')->default(1);

    $table->decimal('sale_amount', 15, 2)->default(0);
    $table->decimal('commission_rate', 8, 2)->default(0);
    $table->decimal('commission_amount', 15, 2)->default(0);

    $table->enum('status', [
        'pending',
        'confirmed',
        'cancelled',
        'refunded'
    ])->default('pending');

    $table->timestamp('confirmed_at')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_sales');
    }
};
