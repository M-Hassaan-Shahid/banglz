@if(isset($products) && $products->count())
    @foreach($products as $product)
        @php
            $firstImage = (!empty($product->images) && isset($product->images[0]))
                ? asset('assets/images/products/' . $product->images[0])
                : asset('assets/images/c-1.jpg');

            $userLoggedIn = auth()->check();

            // Build entries array: each entry = ['effective' => float, 'original' => float|null, 'type' => 'member'|'compare'|'price']
            $entries = [];

            // Product entry
            if ($userLoggedIn) {
                if (!is_null($product->member_price)) {
                    // show member price as effective, original is product price
                    if (!is_null($product->member_price)) {
                        $entries[] = [
                            'effective' => (float) $product->member_price,
                            'original'  => $product->price !== null ? (float) $product->price : null,
                            'type'      => 'member'
                        ];
                    }
                } elseif (!is_null($product->compare_price)) {
                    // logged in, no member -> visually compare crossed, effective is original price
                    if (!is_null($product->price)) {
                        $entries[] = [
                            'effective' => (float) $product->price,
                            'original'  => (float) $product->compare_price,
                            'type'      => 'compare'
                        ];
                    } else {
                        // fallback: show compare as effective if no base price (rare)
                        $entries[] = [
                            'effective' => (float) $product->compare_price,
                            'original'  => null,
                            'type'      => 'compare'
                        ];
                    }
                } else {
                    // logged in, no member and no compare -> show price
                    if (!is_null($product->price)) {
                        $entries[] = [
                            'effective' => (float) $product->price,
                            'original'  => null,
                            'type'      => 'price'
                        ];
                    }
                }
            } else {
                // Not logged in
                if (!is_null($product->compare_price) && !is_null($product->price)) {
                    // show compare crossed, effective is product.price
                    $entries[] = [
                        'effective' => (float) $product->price,
                        'original'  => (float) $product->compare_price,
                        'type'      => 'compare'
                    ];
                } elseif (!is_null($product->price)) {
                    $entries[] = [
                        'effective' => (float) $product->price,
                        'original'  => null,
                        'type'      => 'price'
                    ];
                } elseif (!is_null($product->compare_price)) {
                    // fallback if no price but has compare
                    $entries[] = [
                        'effective' => (float) $product->compare_price,
                        'original'  => null,
                        'type'      => 'compare'
                    ];
                }
            }

            // Variation entries
            if ($product->variations && $product->variations->isNotEmpty()) {
                foreach ($product->variations as $variation) {
                    if ($userLoggedIn) {
                        if (!is_null($variation->member_price)) {
                            $entries[] = [
                                'effective' => (float) $variation->member_price,
                                'original'  => $variation->price !== null ? (float) $variation->price : null,
                                'type'      => 'member'
                            ];
                        } elseif (!is_null($variation->compare_price) && !is_null($variation->price)) {
                            $entries[] = [
                                'effective' => (float) $variation->price,
                                'original'  => (float) $variation->compare_price,
                                'type'      => 'compare'
                            ];
                        } elseif (!is_null($variation->price)) {
                            $entries[] = [
                                'effective' => (float) $variation->price,
                                'original'  => null,
                                'type'      => 'price'
                            ];
                        } elseif (!is_null($variation->compare_price)) {
                            // fallback if no price but has compare
                            $entries[] = [
                                'effective' => (float) $variation->compare_price,
                                'original'  => null,
                                'type'      => 'compare'
                            ];
                        }
                    } else {
                        // Not logged in for variation
                        if (!is_null($variation->compare_price) && !is_null($variation->price)) {
                            $entries[] = [
                                'effective' => (float) $variation->price,
                                'original'  => (float) $variation->compare_price,
                                'type'      => 'compare'
                            ];
                        } elseif (!is_null($variation->price)) {
                            $entries[] = [
                                'effective' => (float) $variation->price,
                                'original'  => null,
                                'type'      => 'price'
                            ];
                        } elseif (!is_null($variation->compare_price)) {
                            $entries[] = [
                                'effective' => (float) $variation->compare_price,
                                'original'  => null,
                                'type'      => 'compare'
                            ];
                        }
                    }
                }
            }

            // Ensure we have at least one entry
            if (empty($entries)) {
                // fallback: try product price/compare
                if (!is_null($product->price)) {
                    $entries[] = ['effective' => (float) $product->price, 'original' => null, 'type' => 'price'];
                } elseif (!is_null($product->compare_price)) {
                    $entries[] = ['effective' => (float) $product->compare_price, 'original' => null, 'type' => 'compare'];
                }
            }

            // Choose which entry to show: price-asc -> min effective, price-desc -> max effective, else default choose product-preferred entry first
            $sort = request()->get('sort');
            $chosen = null;

            if ($sort === 'price-asc') {
                $minVal = null;
                foreach ($entries as $e) {
                    if (is_null($minVal) || $e['effective'] < $minVal) {
                        $minVal = $e['effective'];
                        $chosen = $e;
                    }
                }
            } elseif ($sort === 'price-desc') {
                $maxVal = null;
                foreach ($entries as $e) {
                    if (is_null($maxVal) || $e['effective'] > $maxVal) {
                        $maxVal = $e['effective'];
                        $chosen = $e;
                    }
                }
            } else {
                // default: prefer product entry if present, else first variation entry
                // find first entry that came from product (we added product entries first)
                $chosen = $entries[0] ?? null;
            }

            // final values
            $displayPrice = $chosen['effective'] ?? 0.00;
            $originalPrice = $chosen['original'] ?? null;
        @endphp

        <div class="card position-card">
            <a href="{{ url('product-detail/'.$product->slug ?? '#') }}">
                <img src="{{ $firstImage }}" alt="{{ $product->name }}">
            </a>
               <div class="whist-list-button">
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
      <!-- @if($product->variations->count() > 0)
    {{-- Product has variations → redirect to details --}}
    <div class="whist-list-button"
         onclick="window.location.href='{{ route('product.detail', $product->slug) }}'">
        <img src="{{ asset('assets/images/heart.png') }}" alt="Wishlist"/>
    </div>
@else
    {{-- Product has no variations → use API wishlist toggle --}}
    <div class="whist-list-button">
        <img src="{{ asset('assets/images/heart.png') }}"
             alt="Wishlist"
             class="api-wishlist-button"
             data-product-id="{{ $product->id }}"/>
    </div>
@endif -->
            <div class="card-content">
                <h4>{{ $product->name }}</h4>

                <!-- Price display: show original crossed if present, then effective price -->
                <div class="price">
                    @if(!is_null($originalPrice))
                        <span style="text-decoration: line-through; margin-right:6px;">
                            ${{ number_format((float)$originalPrice, 2) }}
                        </span>
                    @endif

                    <span style="font-weight:600;">
                        ${{ number_format((float)$displayPrice, 2) }}
                    </span>
                </div>
<div class="add-action-buttons">
    @if($product->variations && $product->variations->isNotEmpty())
        <button
            class="add-to-bundle"
            onclick="window.location.href='{{ route('product.detail', $product->slug) }}'"
            @if($product->is_pre_order) style="display:none;" @endif>
            Add to Bundle
        </button>

        <button
            class="add-to-cart"
            onclick="window.location.href='{{ route('product.detail', $product->slug) }}'">
            {{ $product->is_pre_order ? 'Add to Pre-Order' : 'Add to Cart' }}
        </button>
    @else
        <button
            class="add-to-bundle btn-add-bundle-product"
            data-product-id="{{ $product->id }}"
            @if($product->is_pre_order) style="display:none;" @endif>
            Add to Bundle
        </button>

        <button
            class="add-to-cart btn-add-to-cart"
            data-type="product"
            data-type-id="{{ $product->id }}">
            {{ $product->is_pre_order ? 'Add to Pre-Order' : 'Add to Cart' }}
        </button>
    @endif
</div>

           <!-- <div class="add-action-buttons">
    @if($product->variations && $product->variations->isNotEmpty())
        <button
            class="add-to-bundle"
            onclick="window.location.href='{{ route('product.detail', $product->slug) }}'">
            Add to Bundle
        </button>
        <button
            class="add-to-cart"
            onclick="window.location.href='{{ route('product.detail', $product->slug) }}'">
            Add to Cart
        </button>
    @else
        <button
            class="add-to-bundle btn-add-bundle-product"
            data-product-id="{{ $product->id }}">
            Add to Bundle
        </button>
        <button
            class="add-to-cart btn-add-to-cart"
            data-type="product"
            data-type-id="{{ $product->id }}">
            Add to Cart
        </button>
    @endif
</div> -->

            </div>
        </div>
    @endforeach
@else
    <div class="no-results" style="padding:40px 0; text-align:center; width:100%;">
        <h3>No product found.</h3>
    </div>
@endif