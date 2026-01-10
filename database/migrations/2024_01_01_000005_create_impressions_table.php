<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('impressions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained()->onDelete('cascade');
            $table->foreignId('ad_id')->constrained()->onDelete('cascade');
            $table->foreignId('website_id')->constrained()->onDelete('cascade');
            $table->text('user_agent');
            $table->string('ip_address');
            $table->timestamp('timestamp');
            $table->index(['campaign_id', 'website_id', 'ip_address']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('impressions');
    }
};
