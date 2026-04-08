<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ad_page_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ad_id')->constrained()->onDelete('cascade');
            $table->foreignId('social_page_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['pending', 'active', 'paused', 'completed'])->default('pending');
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->integer('impressions_count')->default(0);
            $table->integer('clicks_count')->default(0);
            $table->decimal('publisher_earnings', 10, 4)->default(0);
            $table->decimal('advertiser_cost', 10, 4)->default(0);
            $table->timestamps();

            $table->unique(['ad_id', 'social_page_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ad_page_assignments');
    }
};
