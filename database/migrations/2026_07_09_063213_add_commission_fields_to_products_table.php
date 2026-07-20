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
        Schema::table('products', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | Vendor Commission Configuration
            |--------------------------------------------------------------------------
            |
            | none         => No commission
            | percentage   => e.g 10% of product price
            | fixed        => e.g ₦500 per sale
            | target_fixed => e.g Sell 20 copies and earn ₦2,000
            |
            */

            $table->enum('commission_type', [
                'none',
                'percentage',
                'fixed',
                'target_fixed',
            ])
            ->default('none')
            ->after('competition_status');

            $table->decimal('commission_value', 12, 2)
                ->default(0)
                ->after('commission_type');

            /*
            |--------------------------------------------------------------------------
            | Target Sales Quantity
            |--------------------------------------------------------------------------
            |
            | Used only when commission_type = target_fixed
            |
            */

            $table->integer('commission_target_qty')
                ->nullable()
                ->after('commission_value');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'commission_type',
                'commission_value',
                'commission_target_qty',
            ]);
        });
    }
};