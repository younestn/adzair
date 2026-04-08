<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clicks', function (Blueprint $table) {
            $table->foreignId('social_page_id')->nullable()->after('website_id')->constrained('social_pages')->nullOnDelete();
            $table->string('country')->nullable()->after('ip_address');
            $table->string('wilaya')->nullable()->after('country');
        });
    }

    public function down(): void
    {
        Schema::table('clicks', function (Blueprint $table) {
            $table->dropConstrainedForeignId('social_page_id');
            $table->dropColumn(['country', 'wilaya']);
        });
    }
};
