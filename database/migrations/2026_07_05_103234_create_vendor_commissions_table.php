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
        Schema::create('vendor_commissions', function (Blueprint $table) {
    $table->id();

    $table->foreignId('vendor_id')->constrained()->cascadeOnDelete();
    $table->foreignId('vendor_sale_id')->nullable()->constrained('vendor_sales')->nullOnDelete();

    $table->decimal('amount', 15, 2)->default(0);
    $table->decimal('rate', 8, 2)->default(0);

    $table->enum('status', ['pending', 'approved', 'paid', 'cancelled'])->default('pending');

    $table->timestamp('approved_at')->nullable();
    $table->timestamp('paid_at')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_commissions');
    }
};
