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
    Schema::create('vendors', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->string('business_name');
        $table->string('vendor_type')->nullable();

        $table->string('phone')->nullable();
        $table->string('state')->nullable();
        $table->string('city')->nullable();

        // Unique referral/vendor code used for magazine sales tracking
        $table->string('vendor_code')->unique()->nullable();

        $table->enum('status', [
            'pending',
            'approved',
            'rejected',
            'suspended'
        ])->default('pending');

        // Commission setup
        $table->enum('commission_type', [
            'fixed',
            'percentage'
        ])->default('fixed');

        $table->decimal('commission_value', 12, 2)->default(0);

        // Earnings tracking
        $table->decimal('total_earned', 12, 2)->default(0);
        $table->decimal('total_paid', 12, 2)->default(0);

        $table->timestamp('approved_at')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
