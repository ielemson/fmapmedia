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
       Schema::create('orders', function (Blueprint $table) {
    $table->id();

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    $table->foreignId('user_id')
        ->nullable()
        ->constrained()
        ->nullOnDelete();

    $table->foreignId('product_id')
        ->constrained()
        ->cascadeOnDelete();

    $table->foreignId('vendor_id')
        ->nullable()
        ->constrained()
        ->nullOnDelete();

    /*
    |--------------------------------------------------------------------------
    | Order Information
    |--------------------------------------------------------------------------
    */

    $table->string('order_no')->unique();

    $table->unsignedInteger('qty')->default(1);

    $table->decimal('unit_price', 15, 2);

    $table->decimal('subtotal', 15, 2);

    $table->decimal('discount', 15, 2)->default(0);

    $table->decimal('total', 15, 2);

    /*
    |--------------------------------------------------------------------------
    | Vendor Referral
    |--------------------------------------------------------------------------
    */

    $table->string('referral_slug')->nullable();

    $table->decimal('commission_rate', 8, 2)->default(0);

    $table->decimal('commission_amount', 15, 2)->default(0);

    /*
    |--------------------------------------------------------------------------
    | Payment
    |--------------------------------------------------------------------------
    */

    $table->string('payment_reference')->nullable();

    $table->string('transaction_id')->nullable();

    $table->string('payment_gateway')->nullable();

    $table->string('gateway_reference')->nullable();

    $table->decimal('charged_amount', 15, 2)->default(0);

    $table->decimal('gateway_fee', 15, 2)->default(0);

    $table->string('processor_response')->nullable();

    /*
    |--------------------------------------------------------------------------
    | Status
    |--------------------------------------------------------------------------
    */

    $table->enum('status', [
        'pending',
        'processing',
        'completed',
        'cancelled',
        'refunded'
    ])->default('pending');

    $table->enum('payment_status', [
        'unpaid',
        'paid',
        'failed',
        'refunded'
    ])->default('unpaid');

    /*
    |--------------------------------------------------------------------------
    | Competition
    |--------------------------------------------------------------------------
    */

    $table->boolean('competition_entry')->default(false);

    /*
    |--------------------------------------------------------------------------
    | Miscellaneous
    |--------------------------------------------------------------------------
    */

    $table->string('location')->nullable();

    $table->json('meta')->nullable();

    $table->timestamp('paid_at')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
