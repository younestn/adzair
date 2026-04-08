<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('platform', ['facebook', 'instagram', 'tiktok', 'youtube', 'twitter', 'snapchat']);
            $table->string('page_url', 500);
            $table->string('verification_code')->unique();
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->string('page_name')->nullable();
            $table->integer('followers_count')->nullable();
            $table->string('page_category')->nullable();
            $table->string('profile_picture_url')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('activity_location')->nullable();
            $table->json('most_viewed_wilayas')->nullable();
            $table->json('most_followed_wilayas')->nullable();
            $table->decimal('audience_reach_rate', 5, 2)->nullable();
            $table->json('page_topics')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_pages');
    }
};
