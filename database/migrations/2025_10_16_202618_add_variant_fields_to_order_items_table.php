<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            if (!Schema::hasColumn('order_items', 'variant_color')) {
                $table->string('variant_color')->nullable()->after('product_sku');
            }
            if (!Schema::hasColumn('order_items', 'variant_size')) {
                $table->string('variant_size')->nullable()->after('variant_color');
            }
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['variant_color', 'variant_size']);
        });
    }
};