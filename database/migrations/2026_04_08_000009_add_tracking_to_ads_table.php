<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->string('tracking_slug')->unique()->after('destination_url');
            $table->string('target_url')->after('tracking_slug');
            $table->boolean('is_product_ad')->default(false)->after('target_url');
            $table->integer('sales_count')->default(0)->after('is_product_ad');
        });
    }

    public function down(): void
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dropColumn(['tracking_slug', 'target_url', 'is_product_ad', 'sales_count']);
        });
    }
};
