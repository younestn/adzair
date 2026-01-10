<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('earnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('website_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('ad_id')->nullable()->constrained()->onDelete('set null');
            $table->bigInteger('impressions')->default(0);
            $table->bigInteger('clicks')->default(0);
            $table->decimal('amount', 10, 2)->default(0);
            $table->string('period');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('earnings');
    }
};
