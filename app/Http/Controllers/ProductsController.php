<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductNotify;
use App\Models\ProductVariation;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    public function show($slug)
    {
        $product = Product::with('variations.color')
            ->where('slug', $slug)
            ->firstOrFail();
        // dd($product);
        $product->images = $product->images ?? [];
        return view('pages.product-detail', compact('product'));
    }



    public function shopAll($slug, $subcategory = null)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $subcategories = Category::where('parent_id', $category->id)->get();
        $materials = Tag::where('type', 'material')->get();
        $styles = Tag::where('type', 'style')->get();
        $productvariations = ProductVariation::all();
        $colors = ProductColor::all();
        $variations = $productvariations
            ->map(function ($variation) {
                if ($variation->size < 2.4) {
                    $variation->size_label = 'Kid';
                } else {
                    $variation->size_label = $variation->size;
                }
                return $variation;
            })
            ->unique('size_label') // remove duplicates
            ->sortBy(function ($variation) {
                // Ensure "Kid" is first, then sort numerically by size
                return $variation->size_label === 'Kid' ? -1 : (float) $variation->size_label;
            })
            ->values();

        $categoryIds = $subcategories->pluck('id')->push($category->id);
        // 1 = logged in, 0 = not logged in (embed as integer in SQL)
        $userLoggedIn = auth()->check() ? 1 : 0;

        $variationPrices = DB::table('product_variations')
            ->select(
                'product_id',
                DB::raw("
                MIN(
                    CASE
                        WHEN {$userLoggedIn} = 1 AND member_price IS NOT NULL THEN member_price
                        ELSE price
                    END
                ) as min_price
            "),
                DB::raw("
                MAX(
                    CASE
                        WHEN {$userLoggedIn} = 1 AND member_price IS NOT NULL THEN member_price
                        ELSE price
                    END
                ) as max_price
            ")
            )
            ->groupBy('product_id');

        // Base query joining the derived variation min/max
        $query = Product::with(['tags', 'category', 'variations'])
            ->leftJoinSub($variationPrices, 'pv', 'pv.product_id', '=', 'products.id')
            ->select('products.*', 'pv.min_price', 'pv.max_price')
            ->distinct();

        // Category / subcategory filtering
        if ($subSlug = request('subcategory')) {
            $sub = Category::where('slug', $subSlug)
                ->where('parent_id', $category->id)
                ->first();
            if ($sub) {
                $query->where('products.category_id', $sub->id);
            } else {
                $query->whereIn('products.category_id', $categoryIds);
            }
        } else {
            $query->whereIn('products.category_id', $categoryIds);
        }

        // Tag filters
        if (request()->filled('styles')) {
            $stylesSlugs = (array) request('styles');
            $query->whereHas('tags', function ($q) use ($stylesSlugs) {
                $q->whereIn('slug', $stylesSlugs);
            });
        }

        if (request()->filled('materials')) {
            $materialsSlugs = (array) request('materials');
            $query->whereHas('tags', function ($q) use ($materialsSlugs) {
                $q->whereIn('slug', $materialsSlugs);
            });
        }

        // Parse price filter (supports price_min/price_max or price range "min-max")
        $hasPriceFilter = false;
        $min = null;
        $max = null;
        if (request()->filled('price_min') || request()->filled('price_max')) {
            $hasPriceFilter = true;
            $min = request('price_min') !== null ? (float) request('price_min') : null;
            $max = request('price_max') !== null ? (float) request('price_max') : null;
        } elseif (request()->filled('price')) {
            $parts = explode('-', request('price'));
            if (isset($parts[0]) && is_numeric($parts[0])) {
                $min = (float) $parts[0];
                $hasPriceFilter = true;
            }
            if (isset($parts[1]) && is_numeric($parts[1])) {
                $max = (float) $parts[1];
                $hasPriceFilter = true;
            }
        }
        $effectiveProductPrice = "
        CASE
            WHEN {$userLoggedIn} = 1 AND products.member_price IS NOT NULL THEN products.member_price
            ELSE products.price
        END
          ";

        $effectiveVariationPrice = "
        CASE
            WHEN {$userLoggedIn} = 1 AND member_price IS NOT NULL THEN member_price
            ELSE price
        END
         ";
        if ($hasPriceFilter) {
            $query->where(function ($q) use ($effectiveProductPrice, $effectiveVariationPrice, $min, $max) {
                // Filter on product effective price
                if (!is_null($min) && !is_null($max)) {
                    $q->whereBetween(DB::raw($effectiveProductPrice), [$min, $max]);
                } elseif (!is_null($min)) {
                    $q->where(DB::raw($effectiveProductPrice), '>=', $min);
                } elseif (!is_null($max)) {
                    $q->where(DB::raw($effectiveProductPrice), '<=', $max);
                }
                $q->orWhereHas('variations', function ($vq) use ($effectiveVariationPrice, $min, $max) {
                    if (!is_null($min) && !is_null($max)) {
                        $vq->whereBetween(DB::raw($effectiveVariationPrice), [$min, $max]);
                    } elseif (!is_null($min)) {
                        $vq->where(DB::raw($effectiveVariationPrice), '>=', $min);
                    } elseif (!is_null($max)) {
                        $vq->where(DB::raw($effectiveVariationPrice), '<=', $max);
                    }
                });
            });
        }
        if (request()->filled('sizes')) {
            $sizes = (array) request('sizes');

            $query->whereHas('variations', function ($vq) use ($sizes) {
                $vq->where(function ($q) use ($sizes) {
                    foreach ($sizes as $size) {
                        if ($size === 'Kid') {
                            // any variation with size < 2.4
                            $q->orWhere('size', '<', 2.4);
                        } else {
                            // exact numeric/string size match
                            $q->orWhere('size', $size);
                        }
                    }
                });
            });
        }
        if (request()->filled('colors')) {
            $colors = (array) request('colors');

            $query->whereHas('variations', function ($vq) use ($colors) {
                $vq->whereIn('color_id', $colors);
            });
        }
        if (request()->filled('boxes')) {
            
    $boxes = (array) request('boxes');
// dd($boxes);
    $query->whereIn('products.category_box_id', $boxes);
}
        if (request()->filled('sort')) {
            switch (request('sort')) {
                case 'name-asc':
                    $query->orderBy('products.name', 'asc');
                    break;

                case 'name-desc':
                    $query->orderBy('products.name', 'desc');
                    break;

                case 'price-asc':
                    $query->orderByRaw("COALESCE(LEAST({$effectiveProductPrice}, pv.min_price), 999999999) ASC");
                    break;

                case 'price-desc':
                    $query->orderByRaw("COALESCE(GREATEST({$effectiveProductPrice}, pv.max_price), -1) DESC");
                    break;

                default:
                    $query->latest('products.created_at');
                    break;
            }
        } else {
            $query->latest('products.created_at');
        }
        $products = $query->paginate(10)->appends(request()->query());
 $boxCategory = $category; // default: parent
    if ($subSlug = request('subcategory')) {
        $sub = Category::where('slug', $subSlug)
            ->where('parent_id', $category->id)
            ->first();
        if ($sub) {
            $boxCategory = $sub;
        }
    }

    // Fetch boxes for the final category
    $boxes = $boxCategory->boxes ?? collect();
        if (request()->ajax()) {
        //          return response()->json([
        //     'html'  => view('pages.partials.product-list', compact('products'))->render(),
        //     'boxes' => $boxes
        // ]);
            return view('pages.partials.product-list', compact('products'))->render();
        }
        return view('pages.shop-all', compact('category', 'subcategories', 'materials', 'styles', 'products', 'subcategory', 'variations', 'colors', 'boxes'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        
        if (empty($query)) {
            return redirect()->route('home');
        }
        
        // Search products by name, description, or tags
        $products = Product::where('status', 1)
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%")
                  ->orWhere('sku', 'LIKE', "%{$query}%");
            })
            ->paginate(12);
        
        return view('pages.search-results', compact('products', 'query'));
    }

public function notify(Request $request)
{
    $request->validate([
        'product_id'   => 'required|exists:products,id',
        'variation_id' => 'nullable|exists:product_variations,id',
        'email'        => 'required|email',
    ]);

    $exists = ProductNotify::where('email', $request->email)
        ->where('product_id', $request->product_id)
        ->where('variation_id', $request->variation_id ?? null)
        ->exists();

    $message = '';

    if ($exists) {
        if ($request->variation_id) {
            $message = '✅ You are already subscribed to notifications for this size.';
        } else {
            $message = '✅ You are already subscribed to notifications for this product.';
        }

        return response()->json([
            'status'  => 'success',
            'message' => $message,
        ]);
    }

    $notify = ProductNotify::create([
        'product_id'   => $request->product_id,
        'variation_id' => $request->variation_id ?? null,
        'email'        => $request->email,
    ]);

    if ($request->variation_id) {
        $message = '✅ You have successfully subscribed to notifications for this size.';
    } else {
        $message = '✅ You have successfully subscribed to notifications for this product.';
    }

    return response()->json([
        'status'  => 'success',
        'message' => $message,
        'data'    => $notify,
    ]);
}


}
