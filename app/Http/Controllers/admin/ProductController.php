<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\ProductBackInStockMail;
use App\Models\Category;
use App\Models\Collection;
use App\Models\CollectionProduct;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductNotify;
use App\Models\ProductTag;
use App\Models\ProductVariation;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{

    public function create()
    {
        $parentCategories = Category::whereNull('parent_id')->get();
        $collections = Collection::where('status', 1)->get();
        $materials = Tag::where('type', 'material')->where('status', 1)->get();
        $styles = Tag::where('type', 'style')->where('status', 1)->get();
        $colors = ProductColor::all();
        return view('admin.products.create', compact('parentCategories', 'collections', 'materials', 'styles', 'colors'));
    }
    public function show($id)
    {
        $product = Product::with('category', 'collection', 'tags')->find($id);
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found');
        }

        return view('admin.products.product_details', ['product' => $product]);
        /*******  2b2ba4a2-88ff-404c-a2f8-5637098e89a8  *******/
    }
    public function delete($id)
    {
        try {
            $product = Product::find($id);
            if (!$product) {
                return response()->json([
                    'status' => false,
                    'message' => 'Product not found'
                ]);
            }

            $product->delete(); // Soft delete if enabled
            return response()->json([
                'status' => true,
                'message' => 'Product deleted successfully'
            ]);
        } catch (\Exception $e) {
            // Catch any unexpected errors
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ]);
        }
    }

    public function get_products_list()
    {
        $query = Product::with('category', 'variations');

        // Handle search
        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('price', 'LIKE', "%{$search}%")
                    ->orWhere('meta_title', 'LIKE', "%{$search}%")
                    ->orWhere('meta_description', 'LIKE', "%{$search}%")
                    ->orWhereHas('category', function ($cat) use ($search) {
                        $cat->where('name', 'LIKE', "%{$search}%");
                    })
                    // ✅ Search inside images_details JSON (alt text)
                    ->orWhereRaw("JSON_SEARCH(images_details, 'one', ?) IS NOT NULL", [$search]);
            });
        }

        // if ($search = request('search')) {
        //     // dd($search);
        //     $query->where(function ($q) use ($search) {
        //         $q->where('name', 'LIKE', "%{$search}%")
        //             ->orWhere('price', 'LIKE', "%{$search}%")
        //             ->orWhereHas('category', function ($cat) use ($search) {
        //                 $cat->where('name', 'LIKE', "%{$search}%");
        //             });
        //     });
        // }

        $totalRecords = Product::count();
        $totalFiltered = $query->count();


        // Handle sorting
        $sortBy = request('sort_by', 'id');
        $sortDir = request('sort_dir', 'desc');
        $query->orderBy($sortBy, $sortDir);

        // Handle pagination
        $start = request('start', 0);
        $length = request('length', 10);
        $products = $query->skip($start)->take($length)->get();

        $data = [];

        foreach ($products as $product) {
            $commitCount = 0;

            // get pending orders (you can cache this outside the products loop for perf)
            $orders = Order::where('status', 'pending')->get();

            $commitCount = 0;

            foreach ($orders as $order) {
                $productsMeta = json_decode($order->products_meta_data, true);
                if (is_string($productsMeta)) {
                    $productsMeta = json_decode($productsMeta, true) ?: [];
                }
                $productsMeta = (array) $productsMeta;

                // 🔹 Normal products
                if (!empty($productsMeta['Products'])) {
                    foreach ($productsMeta['Products'] as $p) {
                        $pProductId = $p['product']['id'] ?? null;
                        $pVariationProductId = $p['variation']['product_id'] ?? null;

                        if ($pProductId == $product->id || $pVariationProductId == $product->id) {
                            $commitCount += (int) ($p['qty'] ?? 0);
                        }
                    }
                }

                // 🔹 Bundle products
                if (!empty($productsMeta['Bundle'])) {
                    foreach ($productsMeta['Bundle'] as $bundle) {
                        $bundleQty = (int) ($bundle['qty'] ?? 1); // parent bundle quantity

                        foreach ($bundle['bundle']['products'] ?? [] as $bp) {
                            $bpProductId = $bp['product']['id'] ?? null;
                            $bpVariationProductId = $bp['variation']['product_id'] ?? null;

                            if ($bpProductId == $product->id || $bpVariationProductId == $product->id) {
                                // multiply product qty × bundle qty
                                $commitCount += $bundleQty * (int) ($bp['qty'] ?? 0);
                            }
                        }
                    }
                }
            }

            $actions = '
            <a href="' . route('product.details', ['id' => $product->id]) . '">
                <button type="button" class="btn btn-primary">View</button>
            </a>
            <button type="button" class="btn btn-danger" onclick="confirmDelete(' . $product->id . ')">Delete</button>
             <a href="' . route('admin.product.edit', ['id' => $product->id]) . '">
        <button type="button" class="btn btn-info">Edit</button>
    </a>
        ';
            // if($product->id==89){
            //     dd($product->variations->sum('quantity') ?? $product->quantity  );
            // }
            $unavailableQty = $product->variations->count() > 0
                ? $product->variations->sum('unavailable_quantity')
                : $product->unavailable_quantity ?? 0;
            $totalQty = $product->variations->count() > 0
                ? $product->variations->sum('quantity')
                : $product->quantity;
            $availableQty = $totalQty - $unavailableQty ?? 0;
            $onhandQty = $availableQty + $unavailableQty + $commitCount ?? 0;
            $data[] = [
                'name'     => $product->name,
                'price'    => $product->price,
                'available_quantity' => $availableQty ?? 0,
                'unavailable_quantity' => $unavailableQty,
                'commited_quantity' => $commitCount ?? 0,
                'on_hand_quantity'  => $onhandQty ?? 0,
                'is_bangle' => $product->variations->count() > 0 ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-danger">No</span>',
                'category' => $product->category->name ?? '-',
                'action'   => $actions
            ];
        }

        return response()->json([
            'draw'            => intval(request('draw')),
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data'            => $data
        ]);
    }
    public function getChildren($parentId)
    {
        $children = Category::where('parent_id', $parentId)->get();
        return response()->json($children);
    }
    public function store(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $oldProduct = null;
            $oldVariations = collect();

            if ($request->has('id')) {
                $oldProduct = Product::with('variations')->find($request->id);
                if ($oldProduct) {
                    $oldVariations = $oldProduct->variations->keyBy('id');
                }
            }

            // Decide final category: child selected (category) else parent_category
            $finalCategoryId = $request->input('category') ?: $request->input('parent_category');

            // Check if bangles exist
            $hasBangles = $request->has('bangles') && is_array($request->input('bangles')) && count($request->input('bangles')) > 0;

            // Validation rules
            $rules = [
                'name'          => 'required|string|max:255',
                'sku'           => 'nullable|string|max:255',
                'category'      => 'required|exists:categories,id',
                'category_box_id' => 'nullable|exists:category_boxes,id', // ✅ validate category_box_id
                'images'        => 'nullable|array',  // nullable, conditionally required
                'images.*'      => 'image',
                'existing_images' => 'nullable|array',
                'removed_existing_images' => 'nullable|string',
                'bangles'       => 'nullable|array',
                'bangles.*.size' => 'nullable:bangles|string',
                'bangles.*.color_id' => 'required_with:bangles|exists:product_colors,id',
                'bangles.*.quantity' => 'required_with:bangles|integer',
                'bangles.*.unavailable_quantity' => 'nullable|integer',
                'bangles.*.price' => 'required_with:bangles|numeric',
                'bangles.*.compare_price' => 'nullable|numeric',
                'bangles.*.member_price' => 'nullable|numeric',
                'care' => 'required|string',
                'sustainability' => 'required|string',
                'shipping' => 'required|string',
                'returns' => 'required|string',
            ];

            if (!$hasBangles) {
                $rules['price'] = 'required|numeric';
                $rules['quantity'] = 'required|integer';
                $rules['unavailable_quantity'] = 'nullable|integer';
                $rules['compare_price'] = 'nullable|numeric';
                $rules['member_price'] = 'nullable|numeric';
            }

            $validator = Validator::make(array_merge($request->all(), ['category' => $finalCategoryId]), $rules);

            $validator->after(function ($validator) use ($request) {
                $isEdit = $request->has('id');

                $existingImages = $request->input('existing_images', []);
                if (!is_array($existingImages)) {
                    $existingImages = [];
                }

                $removedExisting = json_decode($request->input('removed_existing_images', '[]'), true);
                if (!is_array($removedExisting)) {
                    $removedExisting = [];
                }

                // Images remaining from existing after removals
                $remainingExisting = array_diff($existingImages, $removedExisting);

                // New images uploaded now
                $newImages = $request->file('images', []);

                $totalImages = count($remainingExisting) + count($newImages);

                if ($totalImages < 1) {
                    if ($isEdit) {
                        $validator->errors()->add('images', 'Please upload at least one image.');
                    } else {
                        $validator->errors()->add('images', 'Please upload at least one image.');
                    }
                }
            });


            if ($validator->fails()) {
                return response()->json([
                    'message' => implode(',', $validator->errors()->all()),
                    'status' => false
                ], 422);
            }
            // Handle uploaded images
            // $uploadedImages = [];
            // if ($request->hasFile('images')) {
            //     foreach ($request->file('images') as $image) {
            //         $fileName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            //         $image->move(public_path('assets/images/products'), $fileName);
            //         $uploadedImages[] = $fileName;
            //     }
            // }

            // // Handle removed existing images (edit)
            // $removedExisting = json_decode($request->input('removed_existing_images', '[]'), true);
            // if (!empty($removedExisting)) {
            //     foreach ($removedExisting as $file) {
            //         $fullPath = public_path('assets/images/products/' . $file);
            //         if (file_exists($fullPath)) {
            //             @unlink($fullPath);
            //         }
            //     }
            // }

            // // Combine existing images with newly uploaded
            // $existingFromForm = $request->input('existing_images', []);
            // $allImagesToStore = array_values(array_merge($existingFromForm, $uploadedImages));
            $uploadedImages = [];
            $imagesDetailsInput = json_decode($request->input('images_details', '[]'), true);

            // Handle new uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $fileName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('assets/images/products'), $fileName);

                    // find its alt by original name
                    $alt = '';
                    foreach ($imagesDetailsInput as $detail) {
                        if (($detail['isNew'] ?? false) && $detail['name'] === $image->getClientOriginalName()) {
                            $alt = $detail['alt'] ?? '';
                            break;
                        }
                    }

                    $uploadedImages[] = [
                        'name' => $fileName,
                        'alt'  => $alt
                    ];
                }
            }

            // Handle removed existing
            $removedExisting = json_decode($request->input('removed_existing_images', '[]'), true);
            if (!empty($removedExisting)) {
                foreach ($removedExisting as $file) {
                    $fullPath = public_path('assets/images/products/' . $file);
                    if (file_exists($fullPath)) {
                        @unlink($fullPath);
                    }
                }
            }

            // Handle existing kept images
            $finalDetails = [];

            // existing (with updated alts)
            foreach ($imagesDetailsInput as $detail) {
                if (($detail['isNew'] ?? false) === false && !in_array($detail['name'], $removedExisting)) {
                    $finalDetails[] = [
                        'name' => $detail['name'],
                        'alt'  => $detail['alt'] ?? ''
                    ];
                }
            }

            // merge new + existing
            $finalDetails = array_merge($finalDetails, $uploadedImages);

            // save
            $allImagesToStore = array_column($finalDetails, 'name'); // only names
            // dd($allImagesToStore, $finalDetails);

            // Feature checkbox
            $isFeature = $request->has('is_feature') ? 1 : 0;
            // Top Listed checkbox
            $isTopListed = $request->has('is_top_listed') ? 1 : 0;
            // Pre Order checkbox
            $isPreOrder = $request->has('is_pre_order') ? 1 : 0;
            $productData = [
                'name' => $request->input('name'),
                'sku' => $request->input('sku', null),
                'category_id' => $finalCategoryId,
                'category_box_id' => $request->input('category_box_id', null),
                'description' => $request->input('description', ''),
                // 'slug' => Str::slug($request->input('name') . '-' . uniqid()),
                'images' => $allImagesToStore,
                'images_details' => json_encode($finalDetails),
                'attributes' => json_encode([
                    'materials' => $request->input('materials', []),
                    'styles'    => $request->input('styles', []),
                ]),
                'is_featured' => $isFeature,
                'is_top_listed' => $isTopListed,
                'is_pre_order' => $isPreOrder,
                'care' => $request->input('care', ''),
                'sustainability' => $request->input('sustainability', ''),
                'shipping' => $request->input('shipping', ''),
                'returns' => $request->input('returns', ''),
                'meta_title' => $request->input('meta_title', ''),
                'meta_description' => $request->input('meta_description', ''),
            ];
            $banglesRaw = $request->input('bangles', []);
            $bangles = is_array($banglesRaw) ? array_values($banglesRaw) : [];
            $banglesCount = is_array($bangles) ? count($bangles) : 0;
            if ($banglesCount > 1) {
                $productData['color_id'] = $single['color_id'] ?? null;
                $productData['size'] = $single['size'] ?? null;
                $productData['quantity'] = null;
                $productData['price'] = null;
                $productData['compare_price'] = null;
                $productData['member_price'] = null;
                $productData['unavailable_quantity'] = null;
                $productData['weight'] = null;
                $productData['weight_unit'] = null;
            } elseif ($banglesCount == 1) {
                $single = $bangles[0];
                $productData['color_id'] = $single['color_id'] ?? null;
                $productData['size'] = $single['size'] ?? null;
                $productData['quantity'] = isset($single['quantity']) ? $single['quantity'] : 0;
                $productData['price'] = $single['price'] ?? null;
                $productData['compare_price'] = $single['compare_price'] ?? null;
                $productData['member_price'] = $single['member_price'] ?? null;
                $productData['unavailable_quantity'] = $single['unavailable_quantity'] ?? 0;
                $productData['weight'] = $single['weight'] ?? null;
                $productData['weight_unit'] = $single['weight_unit'] ?? null;
            }

            if (!$request->input('id')) {
                $productData['slug'] = Str::slug($request->input('name') . '-' . uniqid());
            }

            // Create or update product by ID
            $product = Product::updateOrCreate(
                ['id' => $request->input('id')],
                $productData
            );
            // ProductVariation::where('product_id', $product->id)->delete();
            CollectionProduct::where('product_id', $product->id)->delete();
            ProductTag::where('product_id', $product->id)->delete();
            // Handle collections
            if ($request->has('collections')) {
                foreach ($request->input('collections') as $collectionId) {
                    CollectionProduct::create([
                        'product_id' => $product->id,
                        'collection_id' => $collectionId,
                    ]);
                }
            }
            if ($request->has('style')) {
                foreach ($request->input('style') as $styleId) {
                    ProductTag::create([
                        'product_id' => $product->id,
                        'tag_id' => $styleId,
                    ]);
                }
            }
            if ($request->has('material')) {
                foreach ($request->input('material') as $materialId) {
                    ProductTag::create([
                        'product_id' => $product->id,
                        'tag_id' => $materialId,
                    ]);
                }
            }

            // Handle bangles (variations)
            if ($banglesCount > 1) {
                $submittedIds = [];
                foreach ($request->input('bangles') as $bangle) {
                    // dd($bangle);
                    if (!empty($bangle['id'])) {
                        // dd($bangle);

                        // Update existing variation
                        $variation = ProductVariation::where('id', $bangle['id'])
                            ->where('product_id', $product->id)
                            ->first();

                        if ($variation) {
                            $variation->update([
                                'size' => $bangle['size'],
                                'quantity' => $bangle['quantity'],
                                'unavailable_quantity' => $bangle['unavailable_quantity'] ?? 0,
                                'price' => $bangle['price'],
                                'compare_price' => $bangle['compare_price'] ?? null,
                                'member_price' => $bangle['member_price'] ?? null,
                                'color_id' => $bangle['color_id'] ?? null,
                                'weight' => $bangle['weight'] ?? null,
                                'weight_unit' => $bangle['weight_unit'] ?? null
                            ]);

                            $submittedIds[] = $variation->id;
                        } else {
                            $variation = ProductVariation::create([
                                'product_id' => $product->id,
                                'size' => $bangle['size'],
                                'quantity' => $bangle['quantity'],
                                'unavailable_quantity' => $bangle['unavailable_quantity'] ?? 0,
                                'price' => $bangle['price'],
                                'compare_price' => $bangle['compare_price'] ?? null,
                                'member_price' => $bangle['member_price'] ?? null,
                                'color_id' => $bangle['color_id'] ?? null,
                                'weight' => $bangle['weight'] ?? null,
                                'weight_unit' => $bangle['weight_unit'] ?? null
                                
                            ]);
                            $submittedIds[] = $variation->id;
                        }
                    } else {
                        // dd($bangle);

                        // Create new variation
                        $variation = ProductVariation::create([
                            'product_id' => $product->id,
                            'size' => $bangle['size'],
                            'quantity' => $bangle['quantity'],
                            'unavailable_quantity' => $bangle['unavailable_quantity'] ?? 0,
                            'price' => $bangle['price'],
                            'compare_price' => $bangle['compare_price'] ?? null,
                            'member_price' => $bangle['member_price'] ?? null,
                            'color_id' => $bangle['color_id'] ?? null,
                                'weight' => $bangle['weight'] ?? null,
                                'weight_unit' => $bangle['weight_unit'] ?? null

                        ]);

                        $submittedIds[] = $variation->id;
                    }
                }

                // Delete variations that were not submitted
                ProductVariation::where('product_id', $product->id)
                    ->whereNotIn('id', $submittedIds)
                    ->delete();
                // dd($submittedIds);

            } else {
                ProductVariation::where('product_id', $product->id)->delete();
            }

            if ($request->has('id')) {

                $notifies = ProductNotify::where('product_id', $request->id)->get();
                // dd('notifies', $notifies);

                foreach ($notifies as $notify) {

                    $email = $notify->email;
                    if (!$email) continue;

                    if ($notify->variation_id && $banglesCount > 1) {
                        $variation = ProductVariation::find($notify->variation_id);
                        $oldQty = (int) optional($oldVariations->get($variation->id))->quantity;
                        $newQty = (int) $variation->quantity;

                        if ($oldQty <= 0 && $newQty > 0) {
                            Mail::to($email)->send(new ProductBackInStockMail($product, $variation));
                            //     dd(
                            //         'quantity', $newQty
                            //         , 'old', $oldQty,
                            //         'notify', $notify
                            //         , 'variation', $variation


                            // );
                            ProductNotify::where('id', $notify->id)->delete();
                        }
                    } else {
                        $oldQty = (int) optional($oldProduct)->quantity;
                        $newQty = (int) $product->quantity;

                        if ($oldQty <= 0 && $newQty > 0) {
                            //   dd(
                            //         'quantity', $newQty
                            //         , 'old', $oldQty,


                            // );
                            Mail::to($email)->send(new ProductBackInStockMail($product));
                            ProductNotify::where('id', $notify->id)->delete();
                        }
                    }
                }
                // delete notifications
            }

            DB::commit();

            return response()->json([
                'message' => 'Product saved successfully.',
                'status' => true,
                'redirect_route' => route('admin.products')
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            if (!empty($uploadedImages)) {
                foreach ($uploadedImages as $img) {
                    $path = public_path('assets/images/products/' . $img);
                    if (file_exists($path)) {
                        @unlink($path);
                    }
                }
            }
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function edit($id)
    {
        $product = Product::with('collection', 'variations', 'category')->findOrFail($id);
        // dd($product);
        $colors = ProductColor::all();

        // decode attributes JSON into an array so Blade/JS gets a real structure
        $attrs = [];
        if (!empty($product->attributes) && is_string($product->attributes)) {
            $decoded = json_decode($product->attributes, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $attrs = $decoded;
            }
        }

        // guarantee keys exist (avoid undefined in view/JS)
        $attrs = array_merge([
            'materials' => [],
            'styles'    => [],
        ], $attrs);

        // replace string with decoded array for the view
        $product->attributes = $attrs;

        $parentCategories = Category::whereNull('parent_id')->get();
        $collections = Collection::where('status', 1)->get();
        $selectedCollectionIds = $product->collection->pluck('id')->toArray();
        $selectedMaterialIds = $product->tags()
            ->where('type', 'material')
            ->pluck('tags.id')
            ->toArray();

        $selectedStyleIds = $product->tags()
            ->where('type', 'style')
            ->pluck('tags.id')
            ->toArray();
        // dd($selectedStyleIds);
        $materials = Tag::where('type', 'material')->where('status', 1)->get();
        $styles = Tag::where('type', 'style')->where('status', 1)->get();
        $product->images_details = $product->images_details
            ? json_decode($product->images_details, true)
            : [];
        // dd($product->images_details);
        return view('admin.products.create', compact(
            'parentCategories',
            'collections',
            'product',
            'selectedCollectionIds',
            'selectedMaterialIds',
            'selectedStyleIds',
            'materials',
            'styles',
            'colors'
        ));
    }

    public function details($id)
    {
        $category = Category::find($id);
        return response()->json($category);
    }
}
