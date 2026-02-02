<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('page_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('page_settings', 'page_type')) {
                $table->string('page_type')->nullable()->after('page_name');
            }
            if (!Schema::hasColumn('page_settings', 'meta_data')) {
                $table->json('meta_data')->nullable()->after('page_type');
            }
            if (!Schema::hasColumn('page_settings', 'images')) {
                $table->json('images')->nullable()->after('image');
            }
            $table->text('description')->nullable()->change();
            $table->string('image')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('page_settings', function (Blueprint $table) {
            if (Schema::hasColumn('page_settings', 'meta_data')) {
                $table->dropColumn('meta_data');
            }
            if (Schema::hasColumn('page_settings', 'page_type')) {
                $table->dropColumn('page_type');
            }
            if (Schema::hasColumn('page_settings', 'images')) {
                $table->dropColumn('images');
            }
        });
    }
};