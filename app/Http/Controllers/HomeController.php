<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\PageSetting;
use App\Models\Tag;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
        public function reviews()
    {
        $appKey = config('services.yotpo.app_key');
        $response = Http::get("https://api.yotpo.com/v1/widget/$appKey/reviews");

        if ($response->failed()) {
            return [];
        }

        return $response->json()['reviews'] ?? [];
    }
    public function index()
    {
        $data['featuredCategories'] = Category::where('is_featured', true)
            ->orderBy('name')
            ->take(4)
            ->get();
        $data['pageData'] = PageSetting::all();
        $data['collections'] = Collection::where('status', 1)->get();
        $data['tabsWithProducts'] = $this->topListedData();
       return view('pages.home', $data);
    }

    public function topListedData()
    {

        $topTags = Tag::where('top_listed', true)
            ->select('id', 'name', 'slug')
            ->get();
        $topCategories = Category::where('top_listed', true)
            ->select('id', 'name', 'slug')
            ->get();


        $tabs = $topTags->merge($topCategories);

        $tabsWithProducts = $tabs->map(function ($tab) {
            if ($tab instanceof Category) {
                $products = Product::where('category_id', $tab->id)
                    ->where('status', 1)
                    ->take(10)
                    ->get();

                $type = 'category';
            } elseif ($tab instanceof Tag) {
                $products = Product::whereHas('tags', function ($q) use ($tab) {
                    $q->where('tags.id', $tab->id);
                })
                    ->where('status', 1)
                    ->take(10)
                    ->get();

                $type = 'tag';
            } else {
                $products = collect();
                $type = 'unknown';
            }
            // Fetch collections which have any of these products

            return [
                'id' => $tab->id,
                'name' => $tab->name,
                'slug' => $tab->slug,
                'type' => $type,
                'products' => $products
            ];
        });

        return $tabsWithProducts;
    }
}
