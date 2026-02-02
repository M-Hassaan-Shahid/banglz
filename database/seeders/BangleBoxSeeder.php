<?php

namespace Database\Seeders;

use App\Models\BangleBoxColor;
use App\Models\BangleBoxSize;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BangleBoxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run()
    {
        // --- Step 1: Sizes ---
        $sizes = ['2.4', '2.6', '2.8', '2.10'];

        // --- Step 2: Colors and images ---
        $imageNames = [
            "Matte Peach", "Matte Dark Peach", "Peach with Glitter", "Peach Pink with Gold Glitter",
            "Peach with Gold Glitter", "Matte Light Pink", "Light Pink with Silver Glitter", "Pink with Gold Glitter",
            "Matte Pink", "Matte Bright Pink", "Metallic Velvet Rose", "Rose with Gold Glitter", "Wine with Gold Glitter",
            "Hot Pink with Gold Glitter", "Coral Matte", "Matte Fuschia", "Metallic Velvet Fuschia",
            "Matte Fuchsia with Sparkles", "Fuchsia with Gold Glitter", "Dark Purple with Gold Glitter",
            "Metallic Velvet Purple", "Velvet Purple", "Purple with Gold Glitter", "Matte Lavender", "Velvet Lavender",
            "Light Purple with Silver Glitter", "Matte Lilac", "Metallic Velvet Lilac", "Lilac with Gold Glitter",
            "Grape with Gold Glitter", "Matte Grape", "Navy Blue with Gold Glitter", "Matte Blue", "Blue with Gold Glitter",
            "Matte Cobalt Blue", "Cobalt Blue with Gold Glitter", "Matte Light Blue", "Light Blue with Gold Glitter",
            "Teal with Gold Glitter", "Dark Green with Gold Glitter"
        ];

        $imageFiles = [
            "matte-peach.avif", "matte-dark-peach.avif", "Peach with Glitter.avif", "Peach Pink with Gold Glitter.avif",
            "Peach with Gold Glitter.avif", "Matte Light Pink.avif", "Light Pink with Silver Glitter.webp", "Pink with Gold Glitter.avif",
            "Matte Pink.avif", "Matte Bright Pink.avif", "Metallic Velvet Rose.webp", "Rose with Gold Glitter.avif", "Wine with Gold Glitter.avif",
            "Hot Pink with Gold Glitter.avif", "Coral Matte.avif", "Matte Fuschia.avif", "Metallic Velvet Fuschia.webp",
            "Matte Fuchsia with Sparkles.avif", "Fuchsia with Gold Glitter.avif", "Dark Purple with Gold Glitter.avif",
            "Metallic Velvet Purple.webp", "Velvet Purple.webp", "Purple with Gold Glitter.avif", "Matte Lavender.avif", "Velvet Lavender.webp",
            "Light Purple with Silver Glitter.webp", "Matte Lilac.avif", "Metallic Velvet Lilac.webp", "Lilac with Gold Glitter.avif",
            "Grape with Gold Glitter.avif", "Matte Grape.avif", "Navy Blue with Gold Glitter.avif", "Matte Blue.avif", "Blue with Gold Glitter.avif",
            "Matte Cobalt Blue.avif", "Cobalt Blue with Gold Glitter.avif", "Matte Light Blue.avif", "Light Blue with Gold Glitter.avif",
            "Teal with Gold Glitter.avif", "Dark Green with Gold Glitter.avif"
        ];

        // --- Step 3: Create sizes and assign colors ---
        foreach ($sizes as $sizeValue) {
            $size = BangleBoxSize::firstOrCreate(['size' => $sizeValue]);

            foreach ($imageNames as $i => $colorName) {
                BangleBoxColor::create([
                    'bangle_box_size_id' => $size->id,
                    'color_name' => $colorName,
                    'image' => $imageFiles[$i] ?? null,
                ]);
            }
        }

        $this->command->info('✅ BangleBox sizes and colors seeded successfully!');
    }
}
