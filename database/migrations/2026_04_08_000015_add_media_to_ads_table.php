<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->enum('media_type', ['image', 'video', 'text'])->default('text')->after('type');
            $table->string('media_path')->nullable()->after('image_url');
            $table->string('media_url')->nullable()->after('media_path');
            $table->string('headline', 150)->nullable()->after('media_url');
            $table->text('description')->nullable()->after('headline');
        });
    }

    public function down(): void
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dropColumn(['media_type', 'media_path', 'media_url', 'headline', 'description']);
        });
    }
};
