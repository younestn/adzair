<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pricing_rules', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['advertiser', 'publisher']);
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('platform', ['facebook', 'instagram', 'tiktok', 'youtube', 'twitter', 'snapchat'])->nullable();
            $table->decimal('default_cpc', 8, 4);
            $table->boolean('is_global')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pricing_rules');
    }
};
