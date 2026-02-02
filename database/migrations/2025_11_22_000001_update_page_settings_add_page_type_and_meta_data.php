<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('page_settings', function (Blueprint $table) {
            // New normalized columns
            $table->string('page_type')->nullable()->after('page_name');
            $table->json('meta_data')->nullable()->after('page_type');
        });

        // Backfill existing records into the new structure
        $pages = DB::table('page_settings')->select('id', 'page_name', 'heading', 'sub_heading', 'description', 'images', 'image')->get();

        foreach ($pages as $page) {
            $pageType = $page->page_name ?: 'custom';

            // Build meta_data structure
            $meta = [
                'page_type' => $pageType,
                'sections' => [],
            ];

            // Home page: map existing fields to a basic hero section
            if ($pageType === 'home') {
                $heroImage = null;
                $images = null;
                if (!empty($page->images)) {
                    try {
                        $images = is_string($page->images) ? json_decode($page->images, true) : $page->images;
                    } catch (\Throwable $e) {
                        $images = null;
                    }
                }
                if (is_array($images) && isset($images[0]['src'])) {
                    $heroImage = $images[0]['src'];
                } elseif (!empty($page->image)) {
                    $heroImage = $page->image;
                }

                $meta['sections']['hero_banner'] = [
                    'heading' => $page->heading,
                    'sub_heading' => $page->sub_heading,
                    'description' => $page->description,
                    'background_image' => $heroImage,
                ];
            } else {
                // Non-home pages: generic content section
                $meta['sections']['content'] = [
                    'heading' => $page->heading,
                    'sub_heading' => $page->sub_heading,
                    'description' => $page->description,
                    'image' => $page->image,
                ];
            }

            DB::table('page_settings')
                ->where('id', $page->id)
                ->update([
                    'page_type' => $pageType,
                    'meta_data' => json_encode($meta),
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('page_settings', function (Blueprint $table) {
            $table->dropColumn('meta_data');
            $table->dropColumn('page_type');
        });
    }
};