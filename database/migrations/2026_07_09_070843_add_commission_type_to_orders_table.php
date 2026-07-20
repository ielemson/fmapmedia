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
        Schema::table('orders', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | Commission Snapshot
            |--------------------------------------------------------------------------
            |
            | Stored at the time of payment so future product commission
            | changes do not affect historical orders.
            |
            */

            $table->enum('commission_type', [
                'none',
                'percentage',
                'fixed',
                'target_fixed',
            ])
            ->default('none')
            ->after('referral_slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('commission_type');
        });
    }
};