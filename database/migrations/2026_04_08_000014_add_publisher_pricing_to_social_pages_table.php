<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('social_pages', function (Blueprint $table) {
            $table->decimal('cpc_publisher', 8, 4)->nullable()->after('page_topics');
        });
    }

    public function down(): void
    {
        Schema::table('social_pages', function (Blueprint $table) {
            $table->dropColumn('cpc_publisher');
        });
    }
};
