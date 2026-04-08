<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->json('target_wilayas')->nullable()->after('description');
            $table->json('target_audience')->nullable()->after('target_wilayas');
            $table->decimal('spent_amount', 10, 2)->default(0)->after('budget');
            $table->decimal('cpc_price', 8, 4)->nullable()->after('spent_amount');
            $table->string('niche')->nullable()->after('cpc_price');
        });
    }

    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn(['target_wilayas', 'target_audience', 'spent_amount', 'cpc_price', 'niche']);
        });
    }
};
