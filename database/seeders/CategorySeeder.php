<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use App\Models\ProductTag;
use App\Models\Collection;
use App\Models\CollectionProduct;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categoryImages = [
            'bride-1.png',
            'bride-2.png',
            'bride-3.png',
            'bride-4.png'
        ];

        
        $collectionImages = [
            'collection-1.png',
            'collection-2.png',
            'collection-3.png'
        ];

        $mainCategories = [
            'Bangles' => [
                'Ready to Wear',
                'Banglez Boxes',
                'Banglez Chest',
                'Stone Bangles',
                'Punjabi Choora',
            ],
            'Necklaces' => [
                'Bridal/Formal',
                'Party',
                'Chokers',
                'Pendant/ Longhaar',
            ],
            'Earrings' => [
                'Jhumka',
                'Earrings + tikka set',
                'tops/studs',
            ],
            'Headpieces' => [
                'Tikkas',
                'Jhumar/Passa',
                'Matha Patti',
            ],
            'Accessories' => [
                'Nose Rings',
                'Payal/Anklets',
                'Rings',
                'Hand Pieces',
                'Kamarbands/belts',
                'Kaleera',
            ],
            'Trending' => [
                'Pre-Orders',
                'Gift Sets',
            ],
        ];

        // Clear all tables before seeding
        CollectionProduct::query()->delete();
        Collection::query()->delete();
        ProductTag::query()->delete();
        Tag::query()->delete();
        Product::query()->delete();
        Category::query()->delete();

        // Seed categories
        $allCategoryIds = [];

        foreach ($mainCategories as $mainName => $subCategories) {
            $mainCategory = Category::create([
                'name'        => $mainName,
                'slug'        => Str::slug($mainName),
                'status'      => 1,
                'description' => "$mainName description for testing",
                'images'      => [$categoryImages[array_rand($categoryImages)]],
                'parent_id'   => null,
                'is_featured' => true,
            ]);

            $allCategoryIds[] = $mainCategory->id;

            foreach ($subCategories as $subName) {
                $subCategory = Category::create([
                    'name'        => $subName,
                    'slug'        => Str::slug($subName),
                    'status'      => 1,
                    'description' => "$subName description for testing",
                    'images'      => [$categoryImages[array_rand($categoryImages)]],
                    'parent_id'   => $mainCategory->id,
                ]);
                $allCategoryIds[] = $subCategory->id;
            }
        }

        // Seed tags (mixed types material & style)
        $tags = [
            ['name' => 'Gold', 'type' => 'material'],
            ['name' => 'Silver', 'type' => 'material'],
            ['name' => 'Diamond', 'type' => 'material'],
            ['name' => 'Pearl', 'type' => 'material'],
            ['name' => 'Stone', 'type' => 'material'],
            ['name' => 'Wedding', 'type' => 'style'],
            ['name' => 'Casual', 'type' => 'style'],
            ['name' => 'Formal', 'type' => 'style'],
            ['name' => 'Vintage', 'type' => 'style'],
            ['name' => 'Boho', 'type' => 'style'],
        ];

        $tagIds = [];
        foreach ($tags as $tag) {
            $tagIds[] = Tag::create([
                'name'        => $tag['name'],
                'slug'        => Str::slug($tag['name']),
                'description' => $tag['name'] . ' tag description',
                'status'      => 1,
                'type'        => $tag['type'],
            ])->id;
        }

        // Seed collections
        $collectionNames = ['Wedding Collection', 'Casual Collection', 'Premium Collection'];
        $collectionIds = [];
        foreach ($collectionNames as $collection) {
            $collectionIds[] = Collection::create([
                'name'        => $collection,
                'slug'        => Str::slug($collection),
                'status'      => 1,
                'description' => "$collection description",
                'images'      => [$collectionImages[array_rand($collectionImages)]],
            ])->id;
        }

        // Realistic products data
        $productsData = [
    [
        'name' => '22K Gold Bridal Necklace',
        'description' => 'Elegant 22K gold bridal necklace with matching earrings.',
        'price' => 2500.00,
        'compare_price' => 3000.00,
        'sku' => 'BNG-22K-001',
        'quantity' => 10,
        'images' => ['product-1.png', 'product-2.png'],
        'attributes' => json_encode(['material' => 'Gold', 'style' => 'Bridal']),
        'slug' => '22k-gold-bridal-necklace',
    ],
    [
        'name' => 'Silver Casual Bangles',
        'description' => 'Lightweight silver bangles perfect for casual wear.',
        'price' => 150.00,
        'compare_price' => 180.00,
        'sku' => 'BNG-SLV-002',
        'quantity' => 25,
        'images' => ['product-3.png'],
        'attributes' => json_encode(['material' => 'Silver', 'style' => 'Casual']),
        'slug' => 'silver-casual-bangles',
    ],
    [
        'name' => 'Diamond Stud Earrings',
        'description' => 'Classic diamond stud earrings for all occasions.',
        'price' => 500.00,
        'compare_price' => 600.00,
        'sku' => 'EAR-DMD-003',
        'quantity' => 30,
        'images' => ['product-4.png'],
        'attributes' => json_encode(['material' => 'Diamond', 'style' => 'Formal']),
        'slug' => 'diamond-stud-earrings',
    ],
    [
        'name' => 'Pearl Pendant Necklace',
        'description' => 'Elegant pearl pendant necklace with sterling silver chain.',
        'price' => 350.00,
        'compare_price' => 400.00,
        'sku' => 'NEC-PRL-004',
        'quantity' => 15,
        'images' => ['product-2.png'],
        'attributes' => json_encode(['material' => 'Pearl', 'style' => 'Vintage']),
        'slug' => 'pearl-pendant-necklace',
    ],
    [
        'name' => 'Stone Bangles Set',
        'description' => 'Beautiful stone bangles set in vibrant colors.',
        'price' => 120.00,
        'compare_price' => 150.00,
        'sku' => 'BNG-STN-005',
        'quantity' => 40,
        'images' => ['product-2.png', 'product-3.png'],
        'attributes' => json_encode(['material' => 'Stone', 'style' => 'Boho']),
        'slug' => 'stone-bangles-set',
    ],
    [
        'name' => 'Bridal Matha Patti',
        'description' => 'Gold-plated matha patti for bridal wear.',
        'price' => 200.00,
        'compare_price' => 250.00,
        'sku' => 'HDP-MTH-006',
        'quantity' => 20,
        'images' => ['product-4.png'],
        'attributes' => json_encode(['material' => 'Gold', 'style' => 'Wedding']),
        'slug' => 'bridal-matha-patti',
    ],
    [
        'name' => 'Party Choker Necklace',
        'description' => 'Crystal choker necklace for party occasions.',
        'price' => 180.00,
        'compare_price' => 220.00,
        'sku' => 'NEC-CHK-007',
        'quantity' => 18,
        'images' => ['product-2.png'],
        'attributes' => json_encode(['material' => 'Stone', 'style' => 'Party']),
        'slug' => 'party-choker-necklace',
    ],
    [
        'name' => 'Vintage Hand Piece',
        'description' => 'Beautiful vintage-style gold hand piece.',
        'price' => 140.00,
        'compare_price' => 160.00,
        'sku' => 'ACC-HND-008',
        'quantity' => 14,
        'images' => ['product-1.png'],
        'attributes' => json_encode(['material' => 'Gold', 'style' => 'Vintage']),
        'slug' => 'vintage-hand-piece',
    ],
    [
        'name' => 'Formal Nose Ring',
        'description' => 'Elegant formal gold nose ring.',
        'price' => 100.00,
        'compare_price' => 130.00,
        'sku' => 'ACC-NOS-009',
        'quantity' => 25,
        'images' => ['product-3.png'],
        'attributes' => json_encode(['material' => 'Gold', 'style' => 'Formal']),
        'slug' => 'formal-nose-ring',
    ],
    [
        'name' => 'Pearl Bridal Earrings',
        'description' => 'Pearl drop earrings perfect for brides.',
        'price' => 160.00,
        'compare_price' => 200.00,
        'sku' => 'EAR-PRL-010',
        'quantity' => 15,
        'images' => ['product-2.png'],
        'attributes' => json_encode(['material' => 'Pearl', 'style' => 'Bridal']),
        'slug' => 'pearl-bridal-earrings',
    ],
    [
        'name' => 'Stone Jhumka Earrings',
        'description' => 'Traditional stone jhumka earrings.',
        'price' => 130.00,
        'compare_price' => 150.00,
        'sku' => 'EAR-STN-011',
        'quantity' => 30,
        'images' => ['product-1.png'],
        'attributes' => json_encode(['material' => 'Stone', 'style' => 'Wedding']),
        'slug' => 'stone-jhumka-earrings',
    ],
    [
        'name' => 'Silver Anklets Pair',
        'description' => 'Pair of silver anklets with intricate design.',
        'price' => 90.00,
        'compare_price' => 110.00,
        'sku' => 'ACC-ANK-012',
        'quantity' => 22,
        'images' => ['product-1.png'],
        'attributes' => json_encode(['material' => 'Silver', 'style' => 'Casual']),
        'slug' => 'silver-anklets-pair',
    ],
    [
        'name' => 'Diamond Pendant Set',
        'description' => 'Diamond pendant with matching earrings.',
        'price' => 800.00,
        'compare_price' => 950.00,
        'sku' => 'NEC-DMD-013',
        'quantity' => 8,
        'images' => ['product-2.png'],
        'attributes' => json_encode(['material' => 'Diamond', 'style' => 'Formal']),
        'slug' => 'diamond-pendant-set',
    ],
    [
        'name' => 'Boho Stone Ring',
        'description' => 'Boho-style adjustable stone ring.',
        'price' => 70.00,
        'compare_price' => 85.00,
        'sku' => 'ACC-RNG-014',
        'quantity' => 40,
        'images' => ['product-3.png'],
        'attributes' => json_encode(['material' => 'Stone', 'style' => 'Boho']),
        'slug' => 'boho-stone-ring',
    ],
    [
        'name' => 'Gold Kamarband',
        'description' => 'Traditional gold-plated kamarband for weddings.',
        'price' => 300.00,
        'compare_price' => 350.00,
        'sku' => 'ACC-KMB-015',
        'quantity' => 10,
        'images' => ['product-4.png'],
        'attributes' => json_encode(['material' => 'Gold', 'style' => 'Wedding']),
        'slug' => 'gold-kamarband',
    ],
];


     // Pick 3 categories that will be top listed
$topCategoryIds = array_slice($allCategoryIds, 0, 3); // first 3 from your created categories

// 1️⃣ Give each top category at least 6 products
foreach ($topCategoryIds as $catId) {
    for ($i = 0; $i < 6; $i++) {
        $productData = $productsData[array_rand($productsData)];
        // Make SKU and slug unique to avoid duplicate key error
        $productData['sku'] .= '-' . uniqid();
        $productData['slug'] .= '-' . uniqid();

        $productData['category_id'] = $catId;
        $product = Product::create($productData);

        // Attach random tags
        $randomTags = array_rand($tagIds, rand(1, 3));
        if (!is_array($randomTags)) $randomTags = [$randomTags];
        foreach ($randomTags as $tagKey) {
            ProductTag::create([
                'product_id' => $product->id,
                'tag_id' => $tagIds[$tagKey],
            ]);
        }

        // Attach to random collections
        $randomCollections = array_rand($collectionIds, rand(1, 2));
        if (!is_array($randomCollections)) $randomCollections = [$randomCollections];
        foreach ($randomCollections as $colKey) {
            CollectionProduct::create([
                'collection_id' => $collectionIds[$colKey],
                'product_id' => $product->id,
            ]);
        }
    }
}

// 2️⃣ Add remaining products randomly
foreach ($productsData as $productData) {
    $productData['category_id'] = $allCategoryIds[array_rand($allCategoryIds)];
    $product = Product::create($productData);

    // Attach random tags
    $randomTags = array_rand($tagIds, rand(1, 3));
    if (!is_array($randomTags)) $randomTags = [$randomTags];
    foreach ($randomTags as $tagKey) {
        ProductTag::create([
            'product_id' => $product->id,
            'tag_id' => $tagIds[$tagKey],
        ]);
    }

    // Attach to random collections
    $randomCollections = array_rand($collectionIds, rand(1, 2));
    if (!is_array($randomCollections)) $randomCollections = [$randomCollections];
    foreach ($randomCollections as $colKey) {
        CollectionProduct::create([
            'collection_id' => $collectionIds[$colKey],
            'product_id' => $product->id,
        ]);
    }
}


        // Mark top listed categories based on product count
        $topCategories = Category::withCount('products')
            ->orderBy('products_count', 'desc')
            ->take(3) // or however many you want to mark top listed
            ->get();

        foreach ($topCategories as $category) {
            $category->top_listed = true;
            $category->save();
        }

        // Mark top listed tags based on product count
        $topTags = Tag::withCount('products')
            ->orderBy('products_count', 'desc')
            ->take(3) // or however many you want to mark top listed
            ->get();

        foreach ($topTags as $tag) {
            $tag->top_listed = true;
            $tag->save();
        }
    }
}
