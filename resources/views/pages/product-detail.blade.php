<x-layouts.user-default>
     <x-slot name="metatags">
        <title>{{ $product->meta_title ?? $product->name }}</title>
        <meta name="description" content="{{ $product->meta_description ?? Str::limit(strip_tags($product->description), 160) }}">
       
    </x-slot>
    <x-slot name="insertstyle">
   <style>
.color-options {
  display: flex;
  gap: 8px;
  margin-bottom: 8px;
  align-items: center;
  flex-wrap: wrap;
}

.color-option {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 6px 8px;
  border-radius: 8px;
  background: transparent;
  border: 1px solid transparent;
  cursor: pointer;
  font-size: 13px;
  line-height: 1;
}

.color-option .color-circle {
  width: 18px;
  height: 18px;
  border-radius: 50%;
  border: 1px solid #ccc;
  display: inline-block;
  vertical-align: middle;
}

.color-option.selected {
  border-color: rgba(0,0,0,0.12);
  box-shadow: 0 0 0 3px rgba(0,0,0,0.06);
  background: rgba(0,0,0,0.03);
}

.color-option .color-name {
  display: inline-block;
  font-size: 13px;
  color: #222;
  white-space: nowrap;
}
/* hide container if JS/Blade didn't insert any color buttons */
.color-options:empty { display: none !important; }

/* hide color-name if empty */
.color-option .color-name:empty { display: none; }
.product-detail-section{
    max-width: 1200px;
    margin: 0 auto;
}
</style>

   </style>

    </x-slot>
    <x-slot name="content">

        <div class="product-detail-main-wrapper">
            <div class="product-detail-section">
                <div class="row">
                    <!-- <div class="col-12 col-md-6">
                        <div class="product-detail-images-sec">
                            <div class="main-image">
                                <img src="{{ asset('assets/images/products/' . ($product->images[0] ?? 'default.jpg')) }}" alt="{{ $product->name }}">

                            </div>
                            <div class="thumbnail-gallery">
                                @foreach($product->images as $index => $image)
                                <div class="thumbnail {{ $index === 0 ? 'active' : '' }}">
                                    <img src="{{ asset('assets/images/products/' . $image) }}" alt="Thumbnail {{ $index + 1 }}">
                                </div>
                                @endforeach

                            </div>
                        </div>
                    </div> -->
                    @php
    $imagesDetails = json_decode($product->images_details, true) ?? [];
@endphp

@php
    $imagesDetails = json_decode($product->images_details, true) ?? [];
@endphp

<div class="col-12 col-md-6">
    <div class="product-detail-images-sec">
        {{-- ✅ Main Image --}}
        <div class="main-image">
            @if(!empty($imagesDetails))
                <img 
                    src="{{ asset('assets/images/products/' . ($imagesDetails[0]['name'] ?? 'default.jpg')) }}" 
                    alt="{{ $imagesDetails[0]['alt'] ?? $product->name }}">
            @else
                <img 
                    src="{{ asset('assets/images/products/' . ($product->images[0] ?? 'default.jpg')) }}" 
                    alt="{{ $product->name }}">
            @endif
        </div>

        {{-- ✅ Thumbnails --}}
        <div class="thumbnail-gallery">
            @if(!empty($imagesDetails))
                @foreach($imagesDetails as $index => $img)
                    <div class="thumbnail {{ $index === 0 ? 'active' : '' }}">
                        <img 
                            src="{{ asset('assets/images/products/' . $img['name']) }}" 
                            alt="{{ $img['alt'] ?? 'Thumbnail ' . ($index + 1) }}">
                    </div>
                @endforeach
            @else
                @foreach($product->images as $index => $image)
                    <div class="thumbnail {{ $index === 0 ? 'active' : '' }}">
                        <img 
                            src="{{ asset('assets/images/products/' . $image) }}" 
                            alt="Thumbnail {{ $index + 1 }}">
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>


                    <div class="col-12 col-md-6">
                        <div class="product-detail-info">
                            <h1 class="product-detail-info-title">{{$product->name}}</h1>

                            <div class="rating">
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                            </div>

                            @php
                            // initial prices: prefer first variation if exists, otherwise product-level
                            $firstVariation = $product->variations->isNotEmpty() ? $product->variations->first() : null;

                            // Helper to determine effective + original based on rules for a given item (product or variation)
                            $determine = function ($isLoggedIn, $item) {
                            $res = ['effective' => null, 'original' => null, 'type' => 'price'];

                            if ($isLoggedIn) {
                            if (!is_null($item->member_price)) {
                            $res['effective'] = (float) $item->member_price;
                            $res['original'] = $item->price !== null ? (float) $item->price : null;
                            $res['type'] = 'member';
                            return $res;
                            }
                            if (!is_null($item->compare_price) && !is_null($item->price)) {
                            // logged in, no member but compare exists -> show compare crossed, effective is price
                            $res['effective'] = (float) $item->price;
                            $res['original'] = (float) $item->compare_price;
                            $res['type'] = 'compare';
                            return $res;
                            }
                            // fallback to price or compare if price missing
                            if (!is_null($item->price)) {
                            $res['effective'] = (float) $item->price;
                            $res['original'] = null;
                            $res['type'] = 'price';
                            return $res;
                            }
                            if (!is_null($item->compare_price)) {
                            $res['effective'] = (float) $item->compare_price;
                            $res['original'] = null;
                            $res['type'] = 'compare';
                            return $res;
                            }
                            } else {
                            // not logged in
                            if (!is_null($item->compare_price) && !is_null($item->price)) {
                            $res['effective'] = (float) $item->price;
                            $res['original'] = (float) $item->compare_price;
                            $res['type'] = 'compare';
                            return $res;
                            }
                            if (!is_null($item->price)) {
                            $res['effective'] = (float) $item->price;
                            $res['original'] = null;
                            $res['type'] = 'price';
                            return $res;
                            }
                            if (!is_null($item->compare_price)) {
                            $res['effective'] = (float) $item->compare_price;
                            $res['original'] = null;
                            $res['type'] = 'compare';
                            return $res;
                            }
                            }

                            return $res;
                            };

                            $isLoggedIn = auth()->check();

                            // Determine initial values from first variation if present, else product
                            if ($firstVariation) {
                            $init = $determine($isLoggedIn, $firstVariation);
                            } else {
                            $init = $determine($isLoggedIn, $product);
                            }

                            $initialEffective = $init['effective'] ?? 0;
                            $initialOriginal = $init['original'] ?? null;
                            @endphp

                            <div class="price" id="productPriceWrapper">
                                @if(!is_null($initialOriginal))
                                <span id="productOriginal" style="text-decoration: line-through; margin-right:6px;">
                                    ${{ number_format($initialOriginal, 2) }}
                                </span>
                                @else
                                <span id="productOriginal" style="display:none; text-decoration: line-through; margin-right:6px;"></span>
                                @endif

                                <span id="productPrice">${{ number_format($initialEffective ?? 0, 2) }}</span>
                            @if($product->is_pre_order)
                                       <span class="badge bg-info">Pre Order</span>
                                    @endif
                            </div>


                            <div class="product-options"
                              data-default-stock="{{
    $product->variations->isNotEmpty()
        ? (($product->variations->first()->quantity ?? 0) - ($product->variations->first()->unavailable_quantity ?? 0))
        : (($product->quantity ?? 0) - ($product->unavailable_quantity ?? 0))
}}"
                                data-price="{{ $product->price ?? '' }}"
                                data-compare="{{ $product->compare_price ?? '' }}"
                                data-member="{{ $product->member_price ?? '' }}">

                  @php
    // Does product have variation rows?
    $hasVariations = $product->variations->isNotEmpty();

    // if your Product has relation ->color, use it; otherwise try lookup by color_id
    $productColor = $product->color ?? (\App\Models\ProductColor::find($product->color_id) ?? null);

    // Product-level size present?
    $productHasSize = !empty($product->size);
@endphp

@if($hasVariations)
    {{-- Normal case: render all variation buttons (unchanged) --}}
    <div class="option-title">Select Size</div>
    <div class="size-options">
        @foreach($product->variations as $index => $variation)
            <button
    type="button"
    class="size-option"
    data-variation-id="{{ $variation->id }}"
    data-size="{{ $variation->size ?? '' }}"
    data-stock="{{ ($variation->quantity ?? 0) - ($variation->unavailable_quantity ?? 0) }}"
    data-price="{{ $variation->price ?? '' }}"
    data-compare="{{ $variation->compare_price ?? '' }}"
    data-member="{{ $variation->member_price ?? '' }}"
    data-color="{{ $variation->color->hex_code ?? '' }}"
    data-color-name="{{ $variation->color->name ?? '' }}"
    data-color-id="{{ $variation->color_id ?? '' }}"
    style="{{ empty($variation->size) ? 'visibility:hidden !important;' : '' }}"
>
    {{ $variation->size }}

    @if(!empty($variation->color->hex_code) || !empty($variation->color->name))
        <span class="color-circle" style="{{ !empty($variation->color->hex_code) ? "background: {$variation->color->hex_code};" : '' }}"></span>
    @endif
</button>

        @endforeach
    </div>
@else
    {{-- No variations rows: build one pseudo-variation button from product fields so JS can work unchanged --}}
    {{-- If product has a size, show the size UI; otherwise hide size list visually but keep button so JS can group by color --}}
    @if($productHasSize)
        <div class="option-title">Select Size</div>
        <div class="size-options">
    @else
        <div class="size-options" style="display:none;" aria-hidden="true">
    @endif

        {{-- Single pseudo size-option representing product itself --}}
        <button
            type="button"
            class="size-option"
            data-variation-id="" {{-- empty -> signals product-level choice --}}
            data-product-level="1"
            data-size="{{ $product->size ?? '' }}"
            data-stock="{{ ($product->quantity ?? 0) - ($product->unavailable_quantity ?? 0) }}"
            data-price="{{ $product->price ?? '' }}"
            data-compare="{{ $product->compare_price ?? '' }}"
            data-member="{{ $product->member_price ?? '' }}"
            data-color="{{ $productColor->hex_code ?? '' }}"
            data-color-name="{{ $productColor->name ?? '' }}"
            data-color-id="{{ $productColor->id ?? '' }}"
        >
            @if(!empty($product->size))
                {{ $product->size }}
            @else
                {{ $productColor->name ?? 'Default' }}
            @endif

            @if(!empty($productColor->hex_code) || !empty($productColor->name))
                <span class="color-circle" style="{{ !empty($productColor->hex_code) ? "background: {$productColor->hex_code};" : '' }}"></span>
            @endif
        </button>

    </div> {{-- .size-options --}}
@endif



                                <div class="option-title">Quantity</div>
                                <div class="quantity-selector">
                                    <div class="quantity-control">
                                        <button type="button" class="quantity-btn minus">-</button>
                                        <input type="text" class="quantity-input" value="1" readonly>
                                        <button type="button" class="quantity-btn plus">+</button>
                                    </div>
                                    <div class="whist-list-button unset-position">
   @php
    $inWishlist = false;

    if (auth()->check()) {
        $inWishlist = \App\Models\WishList::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->exists();
    }
@endphp

<img
    src="{{ asset($inWishlist ? 'assets/images/heart-filled.png' : 'assets/images/heart.png') }}"
    alt="Wishlist"
    class="api-wishlist-button"
    data-product-id="{{ $product->id }}" />

</div>
    <div class="notify-wrapper" style="margin-top:12px; font-size:14px;">
        <div class="notify-me" style="display:flex; align-items:center; gap:6px;">
            <input type="checkbox" id="notify" name="notify" value="1"
                   style="cursor:pointer; width:16px; height:16px; accent-color:#007bff; display:none;"
                   data-product-id="{{ $product->id }}" data-variation-id="">
            <label for="notify" id="notify-label" style="cursor:pointer; color:#333; font-weight:500; display:none;">
                Notify me when the product is available
            </label>

            <div id="notify-message" style="margin-top:0; font-size:13px; color:green; display:none;">
       
            </div>
        </div>
    </div>



                                    <!-- <div class="whist-list-button unset-position">
                                        <img src="{{ asset('assets/images/heart.png') }}" alt="missing"/>
                                    </div> -->
                                </div>


                                <div class="remaining-stock" aria-live="polite"></div>
                            </div>


                            {!! $product->description !!}
                            <div class="tabs">
                                <div class="tab-buttons">
                                    <button class="tab-btn detail active">Care</button>
                                    <button class="tab-btn tab-details">Sustainability</button>
                                    <button class="tab-btn tab-reviews">Shipping</button>
                                    <button class="tab-btn tab-return">Returns</button>
                                </div>

                                <div class="tab-content">
                                    <div class="tab-panel detail active">
                                        <p>{{$product->care}}</p>
                                    </div>
                                    <div class="tab-panel panel-details">
                                        <p>{{$product->sustainability}}</p>
                                    </div>
                                    <div class="tab-panel panel-reviews">
                                        <p>{{$product->shipping}}.</p>
                                    </div>
                                    <div class="tab-panel tab-return">
                                        <p>{{$product->returns}}.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="add-action-buttons">
                              <button
    class="add-to-bundle-btn btn-add-bundle-product"
    data-product-id="{{ $product->id }}"
    id="addToBundleBtn"
    data-variation-id="">
    Add to Bundle
</button>

                                <button
    class="add-to-cart-btn btn-add-to-cart"
    data-type="product"
    data-type-id="{{ $product->id }}"
    data-qty="1"
    id="addToCartBtn"
    data-variation-id=""
>
    Add to Cart
</button>
                            </div> -->
<div class="add-action-buttons">
    <button
        class="add-to-bundle-btn btn-add-bundle-product"
        data-product-id="{{ $product->id }}"
        id="addToBundleBtn"
        data-variation-id=""
        @if($product->is_pre_order) style="display:none;" @endif>
        Add to Bundle
    </button>

    <button
        class="add-to-cart-btn btn-add-to-cart"
        data-type="product"
        data-type-id="{{ $product->id }}"
        data-qty="1"
        id="addToCartBtn"
        data-variation-id="">
        {{ $product->is_pre_order ? 'Add to Pre-Order' : 'Add to Cart' }}
    </button>
</div>


                        </div>
                    </div>
                </div>


            </div>
            <div class="container">
                <div class="Customize-section">
                    <div class="customize-sec-content">
                        <h1>Bundle your Look. Unlock Rewards</h1>
                        <p>Select pieces marked with the Complete Your Look tag to build your perfect set.
                            Add three eligible items and unlock exclusive perks, including free styling services and more.</p>
                    </div>
                </div>
            </div>

            <div class="customize-card-main video-servies">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-3 mt-3">
                        <div class="customize-card">
                            <img src="{{ asset('assets/images/browsing.png') }}" alt="">
                            <h1>Start Browsing</h1>
                            <p>Items marked with a “Excluded from Bundle + Save” tag will not count toward your reward.</p>
                            {{-- <button class="customize-card-button">
                                        Shop Now
                                    </button> --}}
                            <div class="video-section">
                                <video playsinline="playsinline" muted="muted" preload="yes" autoplay="autoplay" loop="loop" id="vjs_video_739_html5_api" class="video-js" data-setup='{"autoplay":"any"}'>
                                    <source src="{{asset("assets/images/product-vid.mp4")}}" type="video/mp4">
                                </video>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 mt-3">
                        <div class="customize-card">
                            <img src="{{ asset('assets/images/bundle.png') }}" alt="">
                            <h1>Start building your bundle</h1>
                            <p>Once you add your first eligible item, a “Bundle + Save” side window will open to guide your progress.</p>

                            <div class="video-section">
                                <video playsinline="playsinline" muted="muted" preload="yes" autoplay="autoplay" loop="loop" id="vjs_video_739_html5_api" class="video-js" data-setup='{"autoplay":"any"}'>
                                    <source src="{{asset("assets/images/product-vid.mp4")}}" type="video/mp4">
                                </video>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 mt-3">
                        <div class="customize-card">
                            <img src="{{ asset('assets/images/look.png') }}" alt="">
                            <h1>Complete your Look</h1>
                            <p>Add two more eligible items (Item 2 + Item 3). The side window will update as you go.</p>
                            <div class="video-section">
                                <video playsinline="playsinline" muted="muted" preload="yes" autoplay="autoplay" loop="loop" id="vjs_video_739_html5_api" class="video-js" data-setup='{"autoplay":"any"}'>
                                    <source src="{{asset("assets/images/product-vid.mp4")}}" type="video/mp4">
                                </video>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 mt-3">
                        <div class="customize-card">
                            <img src="{{ asset('assets/images/reward.png') }}" alt="">
                            <h1>Choose your Reward</h1>
                            <p>Customize your bangle within your budget and preferences.</p>
                            <div class="video-section">
                                <video playsinline="playsinline" muted="muted" preload="yes" autoplay="autoplay" loop="loop" id="vjs_video_739_html5_api" class="video-js" data-setup='{"autoplay":"any"}'>
                                    <source src="{{asset("assets/images/product-vid.mp4")}}" type="video/mp4">
                                </video>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="complete-look-btn">
                    <button id="openrRightbarBtn">Complete Your Look</button>
                </div>
            </div>

            {{-- feedback-section --}}
            <div class="userfeed-back-section">
                <h1>What our Customers Say</h1>
                
            @if (config('services.yotpo.app_key'))
                <div class="yotpo yotpo-reviews-carousel"
                     data-background-color="transparent"
                     data-mode="top_rated"
                     data-type="site"
                     data-count="8"
                     data-show-bottomline="true"
                     data-autoplay-enabled="true">
                </div>
            @else
            <div class="slider center">
                <div class="first slider-card">
                    <div class="slider-main-imager">
                        <img src="{{ asset('assets/images/quates.png') }}" alt="missing">
                    </div>
                    <div class="start-images">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                    </div>
                    <h1>"The customization options are simply amazing!"</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla.</p>
                    <div class="user-info">
                        <div class="feed-user-image">
                            <img src="{{ asset('assets/images/fake-user.png') }}" alt="missing">
                        </div>
                        <h2>Name</h2>
                    </div>
                </div>
                <div class="first1 slider-card">
                    <div class="slider-main-imager">
                        <img src="{{ asset('assets/images/quates.png') }}" alt="missing">
                    </div>
                    <div class="start-images">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                    </div>
                    <h1>"The customization options are simply amazing!"</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla.</p>
                    <div class="user-info">
                        <div class="feed-user-image">
                            <img src="{{ asset('assets/images/fake-user.png') }}" alt="missing">
                        </div>
                        <h2>Name</h2>
                    </div>
                </div>
                <div class="first2 slider-card">
                    <div class="slider-main-imager">
                        <img src="{{ asset('assets/images/quates.png') }}" alt="missing">
                    </div>
                    <div class="start-images">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                    </div>
                    <h1>"The customization options are simply amazing!"</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla.</p>
                    <div class="user-info">
                        <div class="feed-user-image">
                            <img src="{{ asset('assets/images/fake-user.png') }}" alt="missing">
                        </div>
                        <h2>Name</h2>
                    </div>
                </div>
                <div class="first3 slider-card">
                    <div class="slider-main-imager">
                        <img src="{{ asset('assets/images/quates.png') }}" alt="missing">
                    </div>
                    <div class="start-images">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                    </div>
                    <h1>"The customization options are simply amazing!"</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla.</p>
                    <div class="user-info">
                        <div class="feed-user-image">
                            <img src="{{ asset('assets/images/fake-user.png') }}" alt="missing">
                        </div>
                        <h2>Name</h2>
                    </div>
                </div>
                <div class="first4 slider-card">
                    <div class="slider-main-imager">
                        <img src="{{ asset('assets/images/quates.png') }}" alt="missing">
                    </div>
                    <div class="start-images">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                    </div>
                    <h1>"The customization options are simply amazing!"</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla.</p>
                    <div class="user-info">
                        <div class="feed-user-image">
                            <img src="{{ asset('assets/images/fake-user.png') }}" alt="missing">
                        </div>
                        <h2>Name</h2>
                    </div>
                </div>
                <div class="first5 slider-card">
                    <div class="slider-main-imager">
                        <img src="{{ asset('assets/images/quates.png') }}" alt="missing">
                    </div>
                    <div class="start-images">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                    </div>
                    <h1>"The customization options are simply amazing!"</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla.</p>
                    <div class="user-info">
                        <div class="feed-user-image">
                            <img src="{{ asset('assets/images/fake-user.png') }}" alt="missing">
                        </div>
                        <h2>Name</h2>
                    </div>
                </div>
            </div>
            @endif
            </div>



        </div>



    </x-slot>
    <x-slot name="insertjavascript">
     
   @auth
    @php
        $userNotifiedVariations = \App\Models\ProductNotify::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->whereNotNull('variation_id')
            ->pluck('variation_id')
            ->map(fn($v) => (int)$v)
            ->toArray();

        $userNotifiedProduct = \App\Models\ProductNotify::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->whereNull('variation_id')
            ->exists();
    @endphp
    <script>
        window.userNotifiedVariations = @json($userNotifiedVariations);
        window.userNotifiedProduct = @json($userNotifiedProduct);
    </script>
@endauth

<script>
/*
  Complete Blade-ready JS bundle (paste at end of <body>).
  - Thumbnails -> main image
  - Tabs -> panels
  - Product options:
      * color-above-sizes (color buttons built from variation buttons)
      * clicking color filters sizes and auto-selects first size
      * clicking size shows qty/stock/price
      * default: first color selected and its first size selected
      * updated price logic matching your Blade snippet (uses only isLoggedIn)
  - Minimal jQuery shim (only if $ undefined)
  - Uses Blade-injected boolean: @json(auth()->check())
  - Wrapped in DOMContentLoaded
*/

if (typeof window.$ === 'undefined') {
    window.$ = function(selector) {
        const nodes = document.querySelectorAll(selector);
        nodes.on = function(ev, handler) {
            Array.prototype.forEach.call(nodes, function(n) {
                if (n && n.addEventListener) n.addEventListener(ev, handler);
            });
            return nodes;
        };
        nodes.each = function(cb) {
            Array.prototype.forEach.call(nodes, cb);
            return nodes;
        };
        return nodes;
    };
    window.jQuery = window.$;
}

document.addEventListener('DOMContentLoaded', function() {

    /* ---------- Thumbnails -> main image ---------- */
    (function() {
        const mainImageEl = document.querySelector('.main-image img');
        const thumbnails = document.querySelectorAll('.thumbnail img');
        if (!thumbnails || !thumbnails.length) return;
        thumbnails.forEach(function(thumb) {
            if (!thumb) return;
            thumb.addEventListener('click', function() {
                if (mainImageEl) mainImageEl.src = this.src;
                document.querySelectorAll('.thumbnail').forEach(function(t) {
                    if (t && t.classList) t.classList.remove('active');
                });
                if (this.parentElement && this.parentElement.classList) {
                    this.parentElement.classList.add('active');
                }
            });
        });
    })();

    /* ---------- Tabs: buttons -> panels ---------- */
    (function() {
        const tabButtons = document.querySelectorAll('.tab-btn');
        const tabPanels = document.querySelectorAll('.tab-panel');
        if (!tabButtons || !tabButtons.length) return;
        tabButtons.forEach(function(btn, index) {
            if (!btn) return;
            btn.addEventListener('click', function() {
                tabButtons.forEach(function(b) { if (b && b.classList) b.classList.remove('active'); });
                tabPanels.forEach(function(p) { if (p && p.classList) p.classList.remove('active'); });
                if (btn && btn.classList) btn.classList.add('active');
                if (tabPanels && tabPanels[index] && tabPanels[index].classList) {
                    tabPanels[index].classList.add('active');
                }
            });
        });
    })();

    /* ---------- Product options: color-above-sizes + price/qty/stock ---------- */
    (function() {
        function formatPrice(value) {
            const n = parseFloat(value);
            if (isNaN(n)) return '$0.00';
            return '$' + n.toFixed(2);
        }

        function parseNum(v) {
            if (typeof v === 'undefined' || v === '') return null;
            const n = parseFloat(v);
            return isNaN(n) ? null : n;
        }

        // Blade-injected boolean: true if user logged in
        var isLoggedIn = @json(auth()->check());

        function initProductOptions(root) {
            if (!root) return;

            const qtyInput = root.querySelector('.quantity-input');
            const minusBtn = root.querySelector('.quantity-btn.minus');
            const plusBtn = root.querySelector('.quantity-btn.plus');
            const stockEl = root.querySelector('.remaining-stock');
            const sizeBtns = Array.prototype.slice.call(root.querySelectorAll('.size-option'));

            const priceElGlobal = document.getElementById('productPrice');
            const origElGlobal = document.getElementById('productOriginal');
            const priceElLocal = root.querySelector('.price');
            const priceEl = priceElGlobal || priceElLocal || null;
            const origEl = origElGlobal || (root.querySelector('#productOriginal') || null);

            const selectedNameEl = root.querySelector('.selected-size-name');
            const selectedPriceEl = root.querySelector('.selected-size-price');

            // Create or locate color options container above sizes
            let colorOptionsContainer = root.querySelector('.color-options');
            const sizeOptionsEl = root.querySelector('.size-options');
            if (!colorOptionsContainer) {
                colorOptionsContainer = document.createElement('div');
                colorOptionsContainer.className = 'color-options';
                // keep basic inline layout if no CSS
                colorOptionsContainer.style.display = 'flex';
                colorOptionsContainer.style.gap = '8px';
                colorOptionsContainer.style.marginBottom = '8px';
                colorOptionsContainer.style.flexWrap = 'wrap';
                if (sizeOptionsEl && sizeOptionsEl.parentElement) {
                    sizeOptionsEl.parentElement.insertBefore(colorOptionsContainer, sizeOptionsEl);
                } else {
                    root.insertBefore(colorOptionsContainer, root.firstChild);
                }
            } else {
                colorOptionsContainer.innerHTML = '';
            }

            // Prevent double-binding
            if (root.dataset.bound === "true") return;
            root.dataset.bound = "true";

            // Helper: extract color info from a size button
            function extractColorInfoFromBtn(btn) {
                const ds = btn.dataset || {};
                // Support multiple naming conventions
                const colorId = ds.colorId || ds.color_id || ds.colorid || ds.color_id || ds.color || '';
                const colorHex = ds.colorHex || ds.color_hex || ds.hex || ds.color || '';
                const colorName = ds.colorName || ds.color_name || ds.colour_name || ds.name || '';
                let finalHex = colorHex || '';
                if ((!finalHex || finalHex === '') && btn.querySelector) {
                    const span = btn.querySelector('.color-circle');
                    if (span) {
                        finalHex = span.style.backgroundColor || span.getAttribute('data-hex') || window.getComputedStyle(span).backgroundColor || '';
                    }
                }
                return { id: colorId || '', hex: finalHex || '', name: colorName || '' };
            }

            // Build color map grouping size buttons by color
            const colorMap = new Map();
            sizeBtns.forEach(function(btn) {
                const info = extractColorInfoFromBtn(btn);
                const key = info.id || info.hex || ('no-color-' + (Math.random().toString(36).slice(2,8)));
                if (!colorMap.has(key)) {
                    colorMap.set(key, { id: info.id, hex: info.hex, name: info.name, btns: [] });
                }
                colorMap.get(key).btns.push(btn);
                btn.dataset.colorKey = key;
            });

            // Core helpers: selected stock/name
            function selectedStock() {
                const selected = root.querySelector('.size-option.selected');
                if (selected) return parseInt(selected.dataset.stock || '0', 10);
                return parseInt(root.dataset.defaultStock || '0', 10);
            }
            function selectedSizeName() {
                const selected = root.querySelector('.size-option.selected');
                if (selected) return selected.dataset.size || selected.textContent.trim();
                return null;
            }

            // Price choosing logic that mirrors your Blade snippet
            // Accepts a dataset object with keys: price, compare, member
            function choosePriceForDataset(dataset) {
                const basePrice = parseNum(dataset.price);
                const memberPrice = parseNum(dataset.member);
                const comparePrice = parseNum(dataset.compare);
                if (isLoggedIn) {
                    if (memberPrice !== null) {
                        // logged in + memberPrice -> show member as effective, base as original if present
                        return { effective: memberPrice, original: (basePrice !== null ? basePrice : (comparePrice !== null ? comparePrice : null)) };
                    } else if (comparePrice !== null) {
                        // logged in, no memberPrice, but has compare -> show base as effective and compare as original
                        return { effective: (basePrice !== null ? basePrice : (comparePrice !== null ? comparePrice : 0)), original: comparePrice };
                    } else if (basePrice !== null) {
                        return { effective: basePrice, original: null };
                    } else {
                        return { effective: 0, original: null };
                    }
                } else {
                    // not logged in
                    if (comparePrice !== null) {
                        return { effective: comparePrice, original: basePrice };
                    } else if (basePrice !== null) {
                        return { effective: basePrice, original: null };
                    } else if (comparePrice !== null) {
                        return { effective: comparePrice, original: null };
                    } else {
                        return { effective: 0, original: null };
                    }
                }
            }

            // Update price DOM using chosen dataset (selected variation or product-level)
            function updatePriceDisplay() {
                const selected = root.querySelector('.size-option.selected');
                const dataset = selected ? selected.dataset : root.dataset || {};
                const chosen = choosePriceForDataset(dataset);
                const effective = chosen.effective;
                const original = chosen.original;

                if (priceEl) {
                    priceEl.textContent = formatPrice(effective);
                }
                if (origEl) {
                    if (original !== null) {
                        origEl.style.display = 'inline';
                        origEl.textContent = formatPrice(original);
                        origEl.style.textDecoration = 'line-through';
                    } else {
                        origEl.style.display = 'none';
                        origEl.style.textDecoration = 'none';
                    }
                }
                if (selectedPriceEl) selectedPriceEl.textContent = formatPrice(effective);
                if (selectedNameEl) selectedNameEl.textContent = selectedSizeName() || '-';
            }

            // clamp/render quantity + stock + price
            function clampAndRender() {
                const max = selectedStock();
                let val = qtyInput ? parseInt(qtyInput.value, 10) : 1;
                if (isNaN(val) || val < 1) val = 1;
                if (val > max) val = max;
                if (qtyInput) qtyInput.value = val;

                if (minusBtn) minusBtn.disabled = val <= 1;
                if (plusBtn) plusBtn.disabled = val >= max;

             if (stockEl) {
                   const selected = root.querySelector('.size-option.selected');
const selVariationId = selected ? (selected.dataset.variationId || selected.dataset.variationid || selected.getAttribute('data-variation-id') || '') : '';

    if (max == 0) {
        stockEl.textContent = 'Out of stock';
const remaining = (typeof max !== 'undefined' ? (parseInt(max,10) - (parseInt(val,10) || 0)) : undefined);
updateNotifyUIForSelectedVariation(root, selVariationId, max , '1');
    } else {
        const remaining = max - val;
        if (remaining <= 5) stockEl.textContent = remaining + ' item' + (remaining !== 1 ? 's' : '') + ' remaining in stock';
        else stockEl.textContent = '';
       
    }
    // alert(selVariationId);
updateNotifyUIForSelectedVariation(root, selVariationId, max , '1');

    // Update notify UI using helper (selected variation id)

}

                updatePriceDisplay();
            }

            // Attach original size handlers (click selects size, resets qty)
            if (sizeBtns && sizeBtns.length) {
                sizeBtns.forEach(function(btn) {
                    if (!btn) return;
                    btn.addEventListener('click', function() {
                        sizeBtns.forEach(function(b) { if (b && b.classList) b.classList.remove('selected'); });
                        if (btn && btn.classList) btn.classList.add('selected');
                        if (qtyInput) qtyInput.value = '1';
                        clampAndRender();
    //                     const vId = btn.dataset.variationId || btn.dataset.variationid || btn.getAttribute('data-variation-id') || '';
    // const vStock = btn.dataset.stock || btn.getAttribute('data-stock') || '0';
    // updateNotifyUIForSelectedVariation(root, vId, vStock-1, '2');
                    });
                });
            }

            // plus/minus handlers
            if (plusBtn) {
                plusBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    let val = qtyInput ? (parseInt(qtyInput.value, 10) || 1) : 1;
                    const max = selectedStock();
                    if (val < max) { if (qtyInput) qtyInput.value = val + 1; clampAndRender(); }
                });
            }
            if (minusBtn) {
                minusBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    let val = qtyInput ? (parseInt(qtyInput.value, 10) || 1) : 1;
                    if (val > 1) { if (qtyInput) qtyInput.value = val - 1; clampAndRender(); }
                });
            }

            // Build color buttons UI from colorMap (show name next to swatch if available)
         // Build color buttons UI from colorMap (show name next to swatch if available)
const colorButtons = [];
colorMap.forEach(function(data, key) {
    // Skip groups that have neither a hex nor a name (no meaningful color)
    if (!data.hex && !data.name) return;

    const btn = document.createElement('button');
    btn.type = 'button';
    btn.className = 'color-option';
    btn.dataset.colorKey = key;
    btn.setAttribute('aria-label', data.name || (data.hex || key));

    const span = document.createElement('span');
    span.className = 'color-circle';
    span.style.width = '18px';
    span.style.height = '18px';
    span.style.borderRadius = '50%';
    span.style.border = '1px solid #ccc';
    span.style.display = 'inline-block';
    span.style.verticalAlign = 'middle';
    // only set background if hex exists
    if (data.hex) span.style.background = data.hex;
    btn.appendChild(span);

    const nameSpan = document.createElement('span');
    nameSpan.className = 'color-name';
    nameSpan.style.marginLeft = '6px';
    nameSpan.style.fontSize = '13px';
    if (data.name) nameSpan.textContent = data.name;
    btn.appendChild(nameSpan);

    colorOptionsContainer.appendChild(btn);
    colorButtons.push(btn);
});

// If no buttons created, hide the container and show all sizes
if (!colorOptionsContainer.querySelector('.color-option')) {
    colorOptionsContainer.style.display = 'none';
    sizeBtns.forEach(function(s){ s.style.display = ''; });
    if (!root.querySelector('.size-option.selected') && sizeBtns.length) {
        sizeBtns[0].classList.add('selected');
    }
}


            // Helper: show sizes for a color key and auto-select first size
            function selectColorKey(key) {
                if (!key) return;
                colorButtons.forEach(function(cb) {
                    if (cb && cb.classList) cb.classList.toggle('selected', cb.dataset.colorKey === key);
                });
                sizeBtns.forEach(function(s) {
                    if (!s) return;
                    if (s.dataset.colorKey === key) {
                        s.style.display = '';
                    } else {
                        s.style.display = 'none';
                        if (s.classList) s.classList.remove('selected');
                    }
                });
                const firstVisible = sizeBtns.find(function(s) { return s && s.style && s.style.display !== 'none'; });
                if (firstVisible) {
                    sizeBtns.forEach(function(b) { if (b && b.classList) b.classList.remove('selected'); });
                    if (firstVisible.classList) firstVisible.classList.add('selected');
                    if (qtyInput) qtyInput.value = '1';
                    clampAndRender();
//                     const vId = firstVisible.dataset.variationId || firstVisible.dataset.variationid || firstVisible.getAttribute('data-variation-id') || '';
// const vStock = firstVisible.dataset.stock || firstVisible.getAttribute('data-stock') || '0';
// updateNotifyUIForSelectedVariation(root, vId, vStock-1 ,'3');

                } else {
                    clampAndRender();
                }
            }

            // Attach color click handlers and default select first color
            if (colorButtons.length) {
                colorButtons.forEach(function(cb) {
                    cb.addEventListener('click', function() {
                        const key = cb.dataset.colorKey;
                        selectColorKey(key);
                    });
                });
                const firstKey = colorMap.keys().next().value;
                if (firstKey) selectColorKey(firstKey);
            } else {
                // No color grouping available - show all sizes and ensure one selected
                sizeBtns.forEach(function(s) { s.style.display = ''; });
                if (!root.querySelector('.size-option.selected') && sizeBtns.length) {
                    const first = sizeBtns[0];
                    if (first && first.classList) first.classList.add('selected');
                }
            }

            // Final initialization: ensure price/qty reflect selected variation
            updatePriceDisplay();
            clampAndRender();
        }

        // Initialize all product-options blocks on page
        document.querySelectorAll('.product-options').forEach(function(el) {
            initProductOptions(el);
        });

    })();

}); // DOMContentLoaded
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  // Find Add to Cart & Add to Bundle buttons
  const addToCartBtn   = document.getElementById('addToCartBtn');
  const addToBundleBtn = document.getElementById('addToBundleBtn');

  document.querySelectorAll('.product-options').forEach(root => {
    const sizeBtns = Array.from(root.querySelectorAll('.size-option'));
    if (!sizeBtns.length) return;

    let colorContainer = root.querySelector('.color-options');
    let colorBtns = colorContainer ? Array.from(colorContainer.querySelectorAll('.color-option')) : [];

    const readColorKey = (btn) => {
      if (!btn) return '';
      return btn.dataset.colorKey || btn.dataset.colorId || btn.dataset.color_id || btn.dataset.color || btn.dataset.colorHex || '';
    };

    // Build color buttons dynamically if not already present
    if (!colorBtns.length) {
      if (!colorContainer) {
        colorContainer = document.createElement('div');
        colorContainer.className = 'color-options';
        const sizeOptionsEl = root.querySelector('.size-options');
        if (sizeOptionsEl && sizeOptionsEl.parentElement) {
          sizeOptionsEl.parentElement.insertBefore(colorContainer, sizeOptionsEl);
        } else {
          root.insertBefore(colorContainer, root.firstChild);
        }
      }

      const seen = new Map();
      sizeBtns.forEach(btn => {
        const key = readColorKey(btn) || ('no-color-' + (btn.dataset.variationId || btn.textContent.trim()));
        if (!seen.has(key)) {
          const hex = btn.dataset.color || btn.dataset.colorHex || '';
          const name = btn.dataset.colorName || '';
          seen.set(key, { key, hex, name });
        }
        btn.dataset.colorKey = key;
      });

     seen.forEach(item => {
  // skip items with neither hex nor name
  if (!item.hex && !item.name) return;

  const cb = document.createElement('button');
  cb.type = 'button';
  cb.className = 'color-option';
  cb.dataset.colorId = item.key;

  const circle = document.createElement('span');
  circle.className = 'color-circle';
  circle.style.display = 'inline-block';
  circle.style.width = '18px';
  circle.style.height = '18px';
  circle.style.borderRadius = '50%';
  circle.style.border = '1px solid #ccc';
  circle.style.verticalAlign = 'middle';
  if (item.hex) circle.style.background = item.hex;
  circle.style.marginRight = '6px';
  cb.appendChild(circle);

  const nameSpan = document.createElement('span');
  nameSpan.className = 'color-name';
  nameSpan.style.fontSize = '13px';
  if (item.name) nameSpan.textContent = item.name;
  cb.appendChild(nameSpan);

  colorContainer.appendChild(cb);
});

      colorBtns = Array.from(colorContainer.querySelectorAll('.color-option'));
    } else {
      sizeBtns.forEach(btn => {
        const key = readColorKey(btn) || ('no-color-' + (btn.dataset.variationId || btn.textContent.trim()));
        btn.dataset.colorKey = key;
      });
      colorBtns.forEach(cb => {
        cb.dataset.colorId = readColorKey(cb) || cb.dataset.colorId || cb.dataset.color || '';
      });
    }

    // Select a color
    const selectColorKey = (key) => {
      if (!key) return;
      colorBtns.forEach(cb => cb.classList.toggle('selected', (cb.dataset.colorId === key)));

      let firstVisible = null;
      sizeBtns.forEach(s => {
        if (s.dataset.colorKey === key) {
          s.style.display = '';
          if (!firstVisible) firstVisible = s;
        } else {
          s.style.display = 'none';
          s.classList.remove('selected');
        }
      });

      if (firstVisible) {
        firstVisible.click(); // trigger default size selection
      } else {
        if (addToCartBtn) {
          addToCartBtn.dataset.variationId = '';

        }
        if (addToBundleBtn) {
          addToBundleBtn.dataset.variationId = '';
        }
      }
    };

    colorBtns.forEach(cb => {
      cb.addEventListener('click', function () {
        const key = cb.dataset.colorId || readColorKey(cb);
        selectColorKey(key);
      });
    });

 sizeBtns.forEach(s => {
  s.addEventListener('click', function () {
    // allow selecting even if hidden (color-only case), so we still set datasets
    // If you want to prevent clicks on hidden ones remove the next line
    // if (getComputedStyle(s).display === 'none') return;

    // visual selection
    sizeBtns.forEach(x => x.classList.remove('selected'));
    s.classList.add('selected');

    const vId = s.dataset.variationId || ''; // will be '' for product-level pseudo-variation
    const sizeVal = s.dataset.size || '';
    const colorId = s.dataset.colorId || s.dataset.color_id || '';

    // set on action buttons so backend receives chosen attributes
    if (addToCartBtn) {
      addToCartBtn.dataset.variationId = vId;
      addToCartBtn.dataset.size = sizeVal;
      addToCartBtn.dataset.colorId = colorId;
    }
    if (addToBundleBtn) {
      addToBundleBtn.dataset.variationId = vId;
      addToBundleBtn.dataset.size = sizeVal;
      addToBundleBtn.dataset.colorId = colorId;
    }

    // update price/stock UI by triggering existing behaviour (if your code relies on click handlers)
    // If you have a function updatePriceDisplay() in the current scope, call it -- otherwise your existing mechanisms will run.
    if (typeof updatePriceDisplay === 'function') updatePriceDisplay();
    if (typeof clampAndRender === 'function') clampAndRender();
  });
});


    // Default selection
    let chosenColorBtn = colorBtns.find(c => c.classList.contains('selected')) || colorBtns[0];
    if (chosenColorBtn) {
      chosenColorBtn.click();
    } else {
      const preselectedSize = sizeBtns.find(s => s.classList.contains('selected') && getComputedStyle(s).display !== 'none')
                            || sizeBtns.find(s => getComputedStyle(s).display !== 'none')
                            || sizeBtns[0];
      if (preselectedSize) preselectedSize.click();
    }
  });
});

// ---------- notify UI helper ----------
// ---------- notify UI helper (accepts root) ----------
function updateNotifyUIForSelectedVariation(root, variationId, stock, number) {
    // alert(number+' is '+stock);
    if (!root) return;
    const notifyCheckbox = root.querySelector('#notify');
    const notifyLabel = root.querySelector('#notify-label');

    if (!notifyCheckbox || !notifyLabel) return;

    // set current variation on checkbox dataset
    notifyCheckbox.dataset.variationId = variationId || '';
    notifyCheckbox.dataset.productId = notifyCheckbox.dataset.productId || notifyCheckbox.getAttribute('data-product-id');
    if (typeof stock !== 'undefined' && parseInt(stock, 10) <= 0) {
// alert(number+'is '+stock);
        
        notifyCheckbox.style.display = '';
        notifyLabel.style.display = '';
        notifyCheckbox.checked = false;
    } else {
        notifyCheckbox.style.display = 'none';
        notifyLabel.style.display = 'none';
        notifyCheckbox.checked = false;
    }
}



</script>


<script>
$(document).on('change', '#notify', function () {
    if ($(this).is(':checked')) {
        const isLoggedIn = @json(Auth::check());
        let productId = $(this).data('product-id') || $(this).attr('data-product-id');
        let variationId = $('.size-option.selected').attr('data-variation-id') || null;

        // store ids globally for use after modal submit
        window.notifyData = { productId, variationId };

        // show modal
        const modal = new bootstrap.Modal(document.getElementById('notifyModal'));
        modal.show();
    } else {
        $("#notify-message").hide();
    }
});

// handle form submit inside modal
$(document).on('submit', '#notifyForm', function (e) {
    e.preventDefault();

    let email = $("#email").val();
    let productId = window.notifyData?.productId || null;
    let variationId = window.notifyData?.variationId || null;

    $.ajax({
        url: "{{ route('product.notify') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            product_id: productId,
            variation_id: variationId,
            email: email
        },
        success: function (response) {
            if (response.status === "success") {
                if (typeof Toast !== 'undefined') {
                    Toast.fire({ icon: 'success', title: response.message || 'You will be notified.' });
                } else {
                    $("#notify-message").text(response.message).show();
                }

                // update client-side state
                if (variationId) {
                    window.userNotifiedVariations = window.userNotifiedVariations || [];
                    if (window.userNotifiedVariations.indexOf(parseInt(variationId, 10)) === -1) {
                        window.userNotifiedVariations.push(parseInt(variationId, 10));
                    }
                } else {
                    window.userNotifiedProduct = true;
                }

                // close modal after success
                const modalEl = document.getElementById('notifyModal');
                const modal = bootstrap.Modal.getInstance(modalEl);
                modal.hide();
            }
        },
        error: function (xhr) {
            $("#notify").prop("checked", false);
        }
    });
});

// $(document).on('change', '#notify', function() {
//     if ($(this).is(':checked')) {
//           const isLoggedIn = @json(Auth::check()); 
//         let productId = $(this).data('product-id') || $(this).attr('data-product-id');
//         let variationId = $('.size-option.selected').attr('data-variation-id') || null;
//      const modal = new bootstrap.Modal(document.getElementById('notifyModal'));
//           modal.show();
//         return;
//         $.ajax({
//             url: "{{ route('product.notify') }}",
//             type: "POST",
//             data: {
//                 _token: "{{ csrf_token() }}",
//                 product_id: productId,
//                 variation_id: variationId,
//             },
//             success: function(response) {
//                 if (response.status === "success") {
//                     // toast if you have Toast
//                     if (typeof Toast !== 'undefined') {
//                         Toast.fire({ icon: 'success', title: response.message || 'You will be notified.' });
//                     } else {
//                         $("#notify-message").text(response.message).show();
//                     }
//                 // $("#notify").prop("checked", true);

//                     // hide checkbox and show message
//                     // $('#notify').hide();
//                     // $('#notify-label').hide();
//                     // $('#notify-message').text(response.message).show();

//                     // update client-side known notified list (so UI reacts immediately)
//                     if (variationId) {
//                         window.userNotifiedVariations = window.userNotifiedVariations || [];
//                         if (window.userNotifiedVariations.indexOf(parseInt(variationId,10)) === -1) {
//                             window.userNotifiedVariations.push(parseInt(variationId,10));
//                         }
//                     } else {
//                         window.userNotifiedProduct = true;
//                     }
//                 }
//             },
//             error: function(xhr) {
//                 $("#notify").prop("checked", false);
//             }
//         });
//     } else {
//         $("#notify-message").hide();
//     }
// });

</script>


    </x-slot>
</x-layouts.user-default>

</html>
