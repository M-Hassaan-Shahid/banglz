<x-layouts.user-default>
  <x-slot name="insertstyle">

    <style>
      .price-tag {
        color: wheat !important;
        padding: 8px !important;
        font-size: 30px;
        /* make it larger */
        font-weight: bold;
        /* bold for emphasis */
        color: #333;
        /* darker color */
      }

      .blog-detail-hearo {
        margin-bottom: 0px
      }

      .clearfix {
        content: "";
        display: table;
        clear: both;
        width: 100%;
      }

      .clearfix h1 {
        width: 100%;
        text-align: left;
      }

      #site-header,
      #site-footer {
        background: #fff;
      }

      #site-header {
        margin: 0 0 30px 0;
      }

      #site-header h1 {
        font-size: 31px;
        font-weight: 300;
        padding: 40px 0;
        position: relative;
        margin: 0;
      }

      a {
        color: #000;
        text-decoration: none;

        -webkit-transition: color .2s linear;
        -moz-transition: color .2s linear;
        -ms-transition: color .2s linear;
        -o-transition: color .2s linear;
        transition: color .2s linear;
      }

      a:hover {
        color: #9a6b55;
      }

      #site-header h1 span {
        color: #9a6b55;
      }

      #site-header h1 span.last-span {
        background: #fff;
        padding-right: 150px;
        position: absolute;
        left: 217px;

        -webkit-transition: all .2s linear;
        -moz-transition: all .2s linear;
        -ms-transition: all .2s linear;
        -o-transition: all .2s linear;
        transition: all .2s linear;
      }

      #site-header h1:hover span.last-span,
      #site-header h1 span.is-open {
        left: 363px;
      }

      #site-header h1 em {
        font-size: 16px;
        font-style: normal;
        vertical-align: middle;
      }

      #cart {
        width: 100%;
        height: fit-content;
      }

      #cart h1 {
        font-weight: 300;
      }

      #cart a {
        color: #9a6b55;
        text-decoration: none;

        -webkit-transition: color .2s linear;
        -moz-transition: color .2s linear;
        -ms-transition: color .2s linear;
        -o-transition: color .2s linear;
        transition: color .2s linear;
      }

      #cart a:hover {
        color: #000;
      }

      .product.removed {
        margin-left: 980px !important;
        opacity: 0;
      }

      .product {
        border: 1px solid #eee;
        margin: 20px 0;
        width: 100%;
        min-height: 195px;
        height: fit-content;
        position: relative;

        -webkit-transition: margin .2s linear, opacity .2s linear;
        -moz-transition: margin .2s linear, opacity .2s linear;
        -ms-transition: margin .2s linear, opacity .2s linear;
        -o-transition: margin .2s linear, opacity .2s linear;
        transition: margin .2s linear, opacity .2s linear;
      }

      .product img {
        width: 100%;
        height: 100%;
        object-fit: cover;
      }

      .bundle-images {
        display: flex;
        width: 100%;
        height: 100%;
      }

      .bundle-images img {
        flex: 1 1 0;
        /* All images grow/shrink equally */
        width: 0;
        /* Forces equal share */
        height: 100%;
        object-fit: cover;
        /* Prevents distortion */
      }

      .product header,
      .product .content {
        background-color: #fff;
        border: 1px solid #ccc;
        border-style: none none solid none;
        float: left;
      }

      .product header {
        background: #000;
        margin: 0 1% 20px 0;
        overflow: hidden;
        padding: 0;
        position: relative;
        width: 30%;
        height: 195px;
      }

      .product header:hover img {
        opacity: .7;
      }

      .product header:hover h3 {
        bottom: 73px;
      }

      .product header h3 {
        background: #9a6b55;
        color: #fff;
        font-weight: 300;
        line-height: 20px;
        margin: 0;
        padding: 0 30px;
        position: absolute;
        bottom: -50px;
        right: 0;
        left: 0;
        text-align: center;

        -webkit-transition: bottom .2s linear;
        -moz-transition: bottom .2s linear;
        -ms-transition: bottom .2s linear;
        -o-transition: bottom .2s linear;
        transition: bottom .2s linear;
      }

      .remove {
        cursor: pointer;
      }

      .remove h3 {
        font-size: 12px !important;
      }

      .product .content {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        padding: 0 20px;
        width: 65%;
        padding-bottom: 10px;
        border: none;
      }

      .product h1 {
        color: #9a6b55;
        font-size: 16px;
        font-weight: 600 !important;
        margin: 10px 0 0px 0;
      }


      .product footer.content {
        padding: 0;
        display: flex;
        flex-direction: column;
        border: none;
        padding-left: 20px;
      }

      .product footer.content p {
        font-size: 12px !important;
      }

      .product footer .price {
        background: #fcfcfc;
        color: #000;
        float: right;
        font-size: 15px;
        font-weight: 300;
        margin: 0;
        padding: 5px 20px;
      }

      .product footer .full-price {
        background: #9a6b55;
        color: #fff;
        float: right;
        font-size: 18px;
        font-weight: 300;
        margin: 0;
        padding: 5px 20px;


        -webkit-transition: margin .15s linear;
        -moz-transition: margin .15s linear;
        -ms-transition: margin .15s linear;
        -o-transition: margin .15s linear;
        transition: margin .15s linear;
      }

      .plus-minus-button {
        border: 1px solid #ddd;
        width: fit-content
      }

      .product-price {
        margin: 0px;
        padding-top: 10px;
        padding-bottom: 10px
      }

      .qt,
      .qt-plus,
      .qt-minus {
        display: block;
        float: left;
      }

      .qt {
        font-size: 19px;
        width: 70px;
        line-height: 35px;
        text-align: center;
      }

      .qt-plus,
      .qt-minus {
        background: #fcfcfc;
        border: none;
        font-size: 25px;
        font-weight: 300;
        height: 100%;
        padding: 0 10px;
        -webkit-transition: background .2s linear;
        -moz-transition: background .2s linear;
        -ms-transition: background .2s linear;
        -o-transition: background .2s linear;
        transition: background .2s linear;
      }

      .qt-plus:hover,
      .qt-minus:hover {
        background: #e7af95;
        color: #fff;
        cursor: pointer;
      }



      #site-footer {
        padding: 20px;
        width: 30%;
        min-width: 350px;

      }

      #site-footer h1 {
        background: #fcfcfc;
        border: 1px solid #ccc;
        border-bottom: none;
        border-style: none none none none;
        font-size: 24px;
        font-weight: 600;
        margin: 0 0 7px 0;
        padding-top: 10px;
        padding-bottom: 10px;
        text-align: left;
      }

      #site-footer h2 {
        font-size: 24px;
        font-weight: 300;
        margin: 10px 0 0 0;
        width: 100%;
        display: flex;
        justify-content: space-between;
      }

      #site-footer h3 {
        font-size: 19px;
        font-weight: 300;
        margin: 15px 0;
      }

      .left {
        float: left;
        width: 100%;
      }

      .tax {
        width: 100%;
        display: flex;
        justify-content: space-between;
      }

      .shipping {
        width: 100%;
        display: flex;
        justify-content: space-between;
      }

      .total {
        width: 100%;
        display: flex;
        justify-content: space-between;
      }

      .right {
        float: right;
        width: 100%;
      }

      .right a {
        margin-top: 10px;
        width: 100%;
      }

      .btn {
        background: #9a6b55;
        border: 1px solid #999;
        border-style: none none solid none;
        cursor: pointer;
        display: block;
        color: #fff;
        font-size: 20px;
        font-weight: 300;
        padding: 10px 0;
        width: 290px;
        text-align: center;

        -webkit-transition: all .2s linear;
        -moz-transition: all .2s linear;
        -ms-transition: all .2s linear;
        -o-transition: all .2s linear;
        transition: all .2s linear;
      }

      .apply-btn {
        width: fit-content;
        padding: 10px 18px
      }

      .btn:hover {
        color: #fff;
        background: #714d3c;
      }

      .type {
        background: #fcfcfc;
        font-size: 13px;
        padding: 10px 16px;
        left: 100%;
      }

      .type,
      .color {
        border: 1px solid #ccc;
        border-style: none none solid none;
        position: absolute;
      }

      .color {
        width: 40px;
        height: 40px;
        right: -40px;
      }

      .red {
        background: #cb5a5e;
      }

      .yellow {
        background: #f1c40f;
      }

      .blue {
        background: #3598dc;
      }

      .minused {
        margin: 0 50px 0 0 !important;
      }

      .added {
        margin: 0 -50px 0 0 !important;
      }

      .best-seller-product {
        position: relative;
        /* needed for absolute buttons */
      }

      .carousel {
        display: flex;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        scroll-behavior: smooth;
        padding: 10px 0;
        /* optional spacing */
      }

      .carousel::-webkit-scrollbar {
        display: none;
      }

      .carousel .card {
        flex: 0 0 calc(100% / 3);
        /* show 3 cards */
        scroll-snap-align: start;
        margin-right: 10px;
        background: transparent;

        overflow: hidden;
      }

      /* ✅ Nav buttons fixed over carousel */
      .nav-buttons {
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        display: flex;
        justify-content: space-between;
        transform: translateY(-50%);
        pointer-events: none;
        /* so clicks go through except on buttons */
      }

      .nav-buttons .nav {
        pointer-events: all;
        color: #fff;
        border: none;
        padding: 10px;
        border-radius: 50%;
        cursor: pointer;
      }

      .shopping-cart {
        width: 70%;
      }

      .dots-container {
        display: flex;
        justify-content: center;
        margin-top: 10px;
      }

      .dot {
        width: 10px;
        height: 10px;
        margin: 0 4px;
        border-radius: 50%;
        background: #ccc;
        cursor: pointer;
      }

      .dot.active {
        background: #333;
      }

      #cart::-webkit-scrollbar {
        height: 6px;
        /* control scrollbar thickness (horizontal) */
      }

      #cart::-webkit-scrollbar-track {
        background: #f1f1f1;
        /* track color */
        border-radius: 10px;
      }

      #cart::-webkit-scrollbar-thumb {
        background: #888;
        /* thumb color */
        border-radius: 10px;
      }

      #cart::-webkit-scrollbar-thumb:hover {
        background: #555;
        /* thumb color on hover */
      }

      .dropdown {
        width: 100%;
        padding: 8px 12px;
        margin-top: 8px;
        border: 1px solid #ccc;
        border-radius: 6px;
        background: #fff;
        font-size: 14px;
        cursor: pointer;
      }

      .dropdown:focus {
        border-color: #9a6b55;
        outline: none;
        box-shadow: 0 0 4px rgba(154, 107, 85, 0.4);
      }

      /* Firefox */
      #cart {
        scrollbar-width: thin;
        /* makes scrollbar thinner */
        scrollbar-color: #888 #f1f1f1;
        /* thumb color | track color */
      }
      /* layout: left stacked images, right content */
/* ------- BANGLE BOX LAYOUT ------- */
/* Layout: use CSS Grid so footer sits below content, header left column fixed height */
.product.bangle-box {
  --header-width: 120px;   /* left column width (images column) */
  --header-height: 270px;  /* fixed height you wanted */
  display: grid;
  grid-template-columns: var(--header-width) 1fr;
  grid-template-rows: auto 1fr;
  grid-template-areas:
    "header content"
    "header footer";
  gap: 18px;
  padding: 14px 12px;
  border-bottom: 1px solid #ececec;
  background: #fff;
  align-items: start;
}

/* Left - fixed header column */
.product.bangle-box .bangle-header {
  grid-area: header;
  width: var(--header-width);
  height: var(--header-height);
  position: relative;
  display: flex;
  align-items: flex-start;
  justify-content: center;
}

/* Bundle images container fills header height */
.bundle-images {
  display: flex;
  flex-direction: column;
  gap: 8px;
  height: 100%;
  align-items: center;
  justify-content: flex-start;
  overflow: hidden;
}

/* Groups to toggle (only one visible) */
.bundle-images .img-group {
  display: none;
  flex-direction: column;
  gap: 8px;
  width: 100%;
  align-items: center;
  transition: opacity .28s ease, transform .18s ease;
  opacity: 0;
}
.bundle-images .img-group.active {
  display: flex;
  opacity: 1;
}

/* Image sizing will be adjusted by JS; provide default fallback */
.bundle-images img {
  width: calc(var(--header-width) - 8px); /* small padding inside column */
  height: auto; /* set by JS */
  object-fit: cover;
  border-radius: 6px;
  border: 1px solid #f0f0f0;
  background: #fafafa;
  display: block;
}

/* “Remove” overlay mimic other products */
.product.bangle-box .remove.remove-bangle {
  display: block;
  color: inherit;
  text-decoration: none;
}
.product.bangle-box .remove.remove-bangle h3 {
  position: absolute;
  left: 6px;
  top: 6px;
  background: rgba(255,255,255,0.95);
  padding: 5px 8px;
  border-radius: 4px;
  color: #333;
  font-size: 13px;
  font-weight: 600;
  opacity: 0;
  transition: opacity .12s ease;
}
.product.bangle-box:hover .remove.remove-bangle h3 { opacity: 1; }

/* Middle content column (fixed min height to match header) */
.product.bangle-box .bangle-content {
  grid-area: content;
  min-height: var(--header-height);
  max-width: 720px;
  overflow: hidden;
}
.product.bangle-box .bangle-content h1 { font-size: 16px; margin: 0 0 6px; font-weight:700; line-height:1.1; }
.product.bangle-box .bangle-content p { margin: 6px 0; color:#444; font-size:14px; }

/* Footer placed under content column */
.product.bangle-box .bangle-footer {
  grid-area: footer;
  display:flex;
  flex-direction: column;
  align-items: flex-end;
  gap: 10px;
  justify-self: end;
  padding-top: 6px;
}

/* Price box & qty controls */
.product-price .full-price {
  background: #b77964;
  color: #fff;
  padding: 8px 12px;
  border-radius: 6px;
  font-weight: 700;
  display: inline-block;
  font-size: 15px;
}
.product-price .price { color:#666; font-weight:600; font-size:13px; }

/* Qty styling */
.plus-minus-button {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  border: 1px solid #e6e6e6;
  padding: 4px;
  border-radius: 6px;
  background: #fafafa;
}
.plus-minus-button button { background: transparent; border: none; width: 30px; height: 30px; cursor: pointer; font-size: 18px; color: #333; }
.plus-minus-button .qt { min-width: 28px; text-align:center; font-weight:600; }

/* responsive: stack on small screens */
@media (max-width: 780px) {
  .product.bangle-box {
    grid-template-columns: 1fr;
    grid-template-areas:
      "header"
      "content"
      "footer";
  }
  .product.bangle-box .bangle-header { width: 100%; justify-content:center; }
  .bundle-images img { width: 120px; }
  .product.bangle-box .bangle-footer { width: 100%; align-items: space-between; flex-direction: row; justify-content: space-between; }
}



    </style>
  </x-slot>
  <x-slot name="content">
    <div class="product-detail-main-wrapper">
      {{-- <div class="about-hero-section blog-detail-hearo">
                <h1>Welcome To Contact Us</h1>
            </div> --}}

      <div class="cart-main-wrapper ">
        <div class="cart-headig">
          <h1>Your Cart</h1>
          @if ($products->isNotEmpty())
          <h3>Cart Products</h3>
          @endif

        </div>

        <div class="cart-main-body">
          <div class="shopping-cart">

            <section id="cart">
              @if($products->isEmpty())
              <p></p>
              @else
              @foreach($products as $item)
              {{-- skip if product relation missing (safe-guard) --}}
              @if(!$item->product)
              @continue
              @endif

              @php
              // Choose variation if exists, otherwise product
              $base = $item->variation ?? $item->product;

              // Pricing rules:
              // Logged in: member_price -> compare_price -> price
              // Guest: compare_price -> price
              if (auth()->check()) {
              $unitPrice = $base->member_price ?? $base->compare_price ?? $base->price;
              } else {
              $unitPrice = $base->compare_price ?? $base->price;
              }

              $qty = (int) ($item->qty ?? 1);
              $totalPrice = (float) $unitPrice * $qty;

              // Stock comes from variation or product
              $availableStock = $item->variation
              ? (($item->variation->quantity ?? 0) - ($item->variation->unavailable_quantity ?? 0))
              : (($item->product->quantity ?? 0) - ($item->product->unavailable_quantity ?? 0));

              // $availableStock = $item->variation ? $item->variation->quantity : $item->product->quantity;
              @endphp

              <article class="product" data-stock="{{ $availableStock }}">
                <header style="background">
                  <a href="#" class="remove" data-id="{{ $item->id }}">
                    <div class="bundle-images">
                      <img src="{{ asset('assets/images/products/' . ($item->product->images[0] ?? 'c-1.jpg')) }}"
                        alt="{{ $item->product->name }}">
                    </div>
                    <h3>Remove product</h3>
                  </a>
                </header>

                <div class="content">
                  <h1>{{ $item->product->name }}</h1>

                  @if($item->variation)
                  <p>
                    Variation: {{ $item->variation->size ?? '' }}
                    @if(optional($item->variation->color)->name)
                    - {{ $item->variation->color->name }}
                    @endif
                  </p>
                  @endif

                  {{-- Stock message --}}
                  @if($availableStock <= 0)
                    <p class="stock-msg text-warning">No more product available</p>

                    @elseif($availableStock <= 5)
                      <p class="stock-msg text-warning">Only {{ $availableStock }} left</p>
                      @else
                      <p class="stock-msg text-warning"></p>
                      @endif
                </div>

                <footer class="content">
                  <div class="plus-minus-button">
                    {{-- Disable minus if qty = 1 --}}
                    <button type="button" class="qt-minus" data-type="product" data-id="{{ $item->id }}"
                      @if($qty <=1) disabled @endif>-</button>

                    <span class="qt">{{ $qty }}</span>

                    {{-- Disable plus if stock exhausted --}}
                    <button type="button" class="qt-plus" data-type="product" data-id="{{ $item->id }}"
                      @if($availableStock <=$qty) disabled @endif>+</button>
                  </div>

                  <div class="product-price">
                    <h2 class="full-price">
                      $ {{ number_format($totalPrice, 2) }}
                    </h2>

                    <h2 class="price">
                      $ {{ number_format((float) $unitPrice, 2) }}
                    </h2>
                  </div>
                </footer>
              </article>
              @endforeach
              @endif
            </section>


            @if ($bundles->isNotEmpty())
            <h3 class="mt-3">Cart Bundle</h3>
            @endif
            <section id="cart">
              @foreach($bundles as $cartBundle)
              @php
              $bundle = $cartBundle->bundle;
              $bundleProducts = $bundle->bundleProducts ?? collect();
              $firstItem = $bundleProducts->first();
              if (!$firstItem) continue;

              $base = $firstItem->variation ?? $firstItem->product;
              if (auth()->check()) {
              $unitPrice = $base->member_price ?? $base->compare_price ?? $base->price;
              } else {
              $unitPrice = $base->compare_price ?? $base->price;
              }
              $qty = (int) ($cartBundle->qty ?? 1);

              // bundle price = sum of products
              $bundleUnitPrice = $bundleProducts->sum(function($bp) {
              $bpBase = $bp->variation ?? $bp->product;
              return auth()->check()
              ? ($bpBase->member_price ?? $bpBase->compare_price ?? $bpBase->price)
              : ($bpBase->compare_price ?? $bpBase->price);
              });
              $bundleTotalPrice = $bundleUnitPrice * $qty;

              $bundleData = $bundleProducts->map(fn($bp) => [
              'id' => $bp->id,
              'product' => [
              'id' => $bp->product->id,
              'name' => $bp->product->name,
              'description' => $bp->product->description,
              'images' => $bp->product->images,
              ],
              'variation' => $bp->variation ? [
              'id' => $bp->variation->id,
              'size' => $bp->variation->size,
              'color' => optional($bp->variation->color)->name,
              ] : null,
              ])->toArray();
              @endphp

              <article class="product bundle" data-bundle='@json($bundleData)'>
                <header>
                  <a href="#" class="remove" data-id="{{ $cartBundle->id }}">
                    <div class="bundle-images">
                      @foreach(array_slice($firstItem->product->images ?? [], 0, 3) as $img)
                      <img src="{{ asset('assets/images/products/' . $img) }}" alt="product-image">
                      @endforeach
                    </div>
                    <h3>Remove bundle</h3>
                  </a>
                </header>

                <div class="content">
                  <h1 class="bundle-title">{{ $firstItem->product->name }}</h1>

                  <p class="bundle-desc">
                    @if($firstItem->variation)
                    Variation: {{ $firstItem->variation->size ?? '' }}
                    @if(optional($firstItem->variation->color)->name)
                    - {{ $firstItem->variation->color->name }}
                    @endif
                    @endif
                  </p>

                  <!-- ✅ dropdown -->
                  <select class="dropdown bundle-switcher">
                    @foreach($bundleProducts as $bp)
                    <option value="{{ $bp->id }}" {{ $bp->id === $firstItem->id ? 'selected' : '' }}>
                      {{ $bp->product->name }}
                      <!-- @if($bp->variation)
                ({{ $bp->variation->size }} {{ optional($bp->variation->color)->name }})
              @endif -->
                    </option>
                    @endforeach
                  </select>
                </div>

                <footer class="content">
                  <div class="plus-minus-button">
                    <span class="qt-minus" data-type="bundle" data-id="{{ $cartBundle->id }}">-</span>
                    <span class="qt">{{ $qty }}</span>
                    <span class="qt-plus" data-type="bundle" data-id="{{ $cartBundle->id }}">+</span>
                  </div>

                  <div class="product-price">
                    <h2 class="full-price">$ {{ number_format($bundleTotalPrice, 2) }} </h2>
                    <h2 class="price">$ {{ number_format($bundleUnitPrice, 2) }} </h2>
                  </div>
                </footer>
              </article>
              @endforeach
            </section>
            @if ($giftCards->isNotEmpty())
            <h3 class="mt-3">Cart Gift Cards</h3>
            @endif
            <section id="cart">
              @foreach($giftCards as $giftCard)
              <article class="product gift-card">
                <header style="display: flex; align-items: center !important; justify-content: space-between;">
                  <div class="bundle-images price-tag">
                    ${{ number_format($giftCard->gift_card_price, 2) }}
                  </div>
                  <a href="#" class="remove" data-id="{{ $giftCard->id }}">
                    <h3>Remove Gift Card</h3>
                  </a>
                </header>


                <div class="content">
                  {{-- Instead of image, we only show text --}}
                  <h1>Gift Card</h1>
                  <p>Value: ${{ number_format($giftCard->gift_card_price, 2) }}</p>

                  {{-- ✅ Show email if available --}}
                  @if(!empty($giftCard->recipient_email))
                  <p><strong>Recipient:</strong> {{ $giftCard->recipient_email }}</p>
                  @endif
                </div>

                <footer class="content">
                  <div class="plus-minus-button">
                    <span class="qt-minus" data-type="gift-card" data-id="{{ $giftCard->id }}">-</span>
                    <span class="qt">{{ $giftCard->qty }}</span>
                    <span class="qt-plus" data-type="gift-card" data-id="{{ $giftCard->id }}">+</span>
                  </div>

                  <div class="product-price">
                    <h2 class="full-price">$ {{ number_format($giftCard->gift_card_price * $giftCard->qty, 2) }}</h2>
                    <h2 class="price">$ {{ number_format($giftCard->gift_card_price, 2) }}</h2>
                  </div>
                </footer>
              </article>
              @endforeach
            </section>
<!-- {{-- BANGLE BOX — display like Bundle block --}}
@if($bangleBoxCartItems->isNotEmpty())
    <h3 class="mt-3">Cart - Bangle Boxes</h3>
@endif

<section id="cart">
  @foreach($bangleBoxCartItems as $item)
      @php
          $bangleBox = $item->bangleBox;       // BoxSize model (variation)
          $bangleSize = $item->bangleSize;     // BangleBoxSize model
          $colors = $item->bangleCartColors ?? collect();
          $colorModels = $colors->map(fn($bc) => $bc->color)->filter();
          // build small array of image filenames (first 3)
          $images = $colorModels->pluck('image')->filter()->values()->toArray();
          // a friendly description similar to bundle
          $descParts = [];
          if ($bangleSize && $bangleSize->size) $descParts[] = 'Size: '.$bangleSize->size;
          if ($bangleBox && $bangleBox->size)  $descParts[] = 'Box size: '.$bangleBox->size;
          $desc = implode(' - ', $descParts);
          // order price logic (use box price)
          $unitPrice = $bangleBox->price ?? 0;
          $qty = (int) ($item->qty ?? 1);
      @endphp

      <article class="product bundle bangle-like" data-bangle-id="{{ $item->id }}">
      <header>
  <a href="#" class="remove" data-id="{{ $item->id }}">
    <div class="bundle-images">
      @foreach(array_slice($images, 0, 3) as $img)
        <img src="{{ asset('assets/images/bangle-box/' . $img) }}" alt="bangle-color">
      @endforeach
    </div>
    <h3>Remove bangle box</h3>
  </a>
</header>


        <div class="content">
          <h1 class="bundle-title">Build Your Own Bangle Box</h1>

          <p class="bundle-desc">
            {!! nl2br(e($desc)) !!}
            @if(optional($bangleBox)->price)
              <br>
              <small>- ${{ number_format(optional($bangleBox)->price, 2) }} CAD</small>
            @endif
          </p>

          {{-- List the colors as the bundle lists products — keep same look --}}
          @if($colorModels->isNotEmpty())
            @php $index = 0; @endphp
            @foreach($colorModels as $c)
              @php $index++; @endphp
              <p class="color-line">
                <strong>{{ $index }}{{ ($index == 1) ? 'st' : (($index==2)?'nd':(($index==3)?'rd':'th')) }} Color:</strong>
                {{ $c->color_name ?? '-' }}
              </p>
            @endforeach
          @else
            <p><em>No colors selected</em></p>
          @endif
        </div>

        <footer class="content">
          <div class="plus-minus-button">
            {{-- use same span pattern as bundle so existing JS works --}}
            <span class="qt-minus" data-type="bangle_box" data-id="{{ $item->id }}">-</span>
            <span class="qt">{{ $qty }}</span>
            <span class="qt-plus" data-type="bangle_box" data-id="{{ $item->id }}">+</span>
          </div>

          <div class="product-price">
            @php
              $totalPrice = $unitPrice * $qty;
            @endphp
            <h2 class="full-price">$ {{ number_format($totalPrice, 2) }} </h2>
            <h2 class="price">$ {{ number_format($unitPrice, 2) }} </h2>
          </div>
        </footer>
      </article>
  @endforeach
</section> -->
@if($bangleBoxCartItems->isNotEmpty())
  <h3 class="mt-3">Cart - Bangle Boxes</h3>
@endif

<section id="cart">
  @foreach($bangleBoxCartItems as $item)
    @php
      $bangleBox = $item->bangleBox;
      $bangleSize = $item->bangleSize;
      $colors = $item->bangleCartColors ?? collect();
      $colorModels = $colors->map(fn($bc) => $bc->color)->filter();

      $firstColor = $colorModels->first();
      $unitPrice = $bangleBox->price ?? 0;
      $qty = (int) ($item->qty ?? 1);
      $totalPrice = $unitPrice * $qty;

      $bangleData = $colorModels->map(fn($c, $index) => [
        'index' => $index,
        'name' => $c->color_name,
        'image' => $c->image,
      ])->values()->toArray();

      $descParts = [];
      if ($bangleSize && $bangleSize->size) $descParts[] = 'Size: '.$bangleSize->size;
      if ($bangleBox && $bangleBox->size)  $descParts[] = 'Box size: '.$bangleBox->size;
      $desc = implode(' - ', $descParts);
    @endphp

    <article class="product bundle bangle-like" data-bangle='@json($bangleData)' data-id="{{ $item->id }}">
      <!-- <header>
        <a href="#" class="remove" data-id="{{ $item->id }}">
          <div class="bundle-images">
            @if($firstColor && $firstColor->image)
              <img src="{{ asset('assets/images/bangle-box/' . $firstColor->image) }}" alt="bangle-color" class="active-image">
            @else
              <img src="{{ asset('assets/images/no-image.png') }}" alt="no-image" class="active-image">
            @endif
          </div>
          <h3>Remove bangle box</h3>
        </a>
      </header> -->
<header style="position: relative; background-color: #fff; border-radius: 8px; height: 190px; overflow: hidden;">
  <a href="#" class="remove" data-id="{{ $item->id }}" 
     style="position: absolute; inset: 0; text-decoration: none; color: inherit; display: flex; align-items: center; justify-content: center;">

    <div class="bundle-images" 
         style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
      @if($firstColor && $firstColor->image)
        <img src="{{ asset('assets/images/bangle-box/' . $firstColor->image) }}"
             alt="bangle-color"
             class="active-image"
             style="max-width: 100%; max-height: 100%; object-fit: contain; transition: transform 0.3s ease, opacity 0.3s ease;">
      @else
        <img src="{{ asset('assets/images/no-image.png') }}"
             alt="no-image"
             class="active-image"
             style="max-width: 100%; max-height: 100%; object-fit: contain; transition: transform 0.3s ease, opacity 0.3s ease;">
      @endif
    </div>

    <h3 style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 500; color: #fff; background: rgba(0, 0, 0, 0.6); margin: 0; opacity: 0; transition: opacity 0.3s ease;">
      Remove bangle box
    </h3>
  </a>
</header>

<script>
  document.querySelectorAll('header').forEach(header => {
    const removeText = header.querySelector('h3');
    const img = header.querySelector('img');
    if (!removeText || !img) return;

    header.addEventListener('mouseenter', () => {
      removeText.style.opacity = '1';
      img.style.transform = 'scale(1.05)';
      img.style.opacity = '0.5';
    });
    header.addEventListener('mouseleave', () => {
      removeText.style.opacity = '0';
      img.style.transform = 'scale(1)';
      img.style.opacity = '1';
    });
  });
</script>





      <div class="content">

        <p class="bundle-desc">
          {!! nl2br(e($desc)) !!}
          @if(optional($bangleBox)->price)
            <br>
            <small>- ${{ number_format(optional($bangleBox)->price, 2) }} CAD</small>
          @endif
        </p>

        {{-- ✅ Default color name and dropdown --}}
        @if($firstColor)
          <p class="bangle-current-color">
            <strong>Color:</strong> <span>{{ $firstColor->color_name }}</span>
          </p>
        @endif

        @if($colorModels->isNotEmpty())
          <select class="dropdown bangle-switcher">
            @foreach($colorModels as $index => $color)
              <option value="{{ $index }}" {{ $index === 0 ? 'selected' : '' }}>
                {{ $color->color_name ?? 'Color' }}
              </option>
            @endforeach
          </select>
        @endif
      </div>

      <footer class="content">
        <div class="plus-minus-button">
          <span class="qt-minus" data-type="bangle_box" data-id="{{ $item->id }}">-</span>
          <span class="qt">{{ $qty }}</span>
          <span class="qt-plus" data-type="bangle_box" data-id="{{ $item->id }}">+</span>
        </div>

        <div class="product-price">
          <h2 class="full-price">$ {{ number_format($totalPrice, 2) }}</h2>
          <h2 class="price">$ {{ number_format($unitPrice, 2) }}</h2>
        </div>
      </footer>
    </article>
  @endforeach
</section>


<!-- {{-- BANGLE BOX: Friendly human-readable summary with stacked images + remove-on-hover --}}
@if($bangleBoxCartItems->isNotEmpty())
    <h3 class="mt-3">Cart - Bangle Boxes</h3>
@endif

<section id="cart">
@foreach($bangleBoxCartItems as $item)
    @php
        $bangleBox = $item->bangleBox;       // BoxSize model (variation)
        $bangleSize = $item->bangleSize;     // BangleBoxSize model
        $colors = $item->bangleCartColors ?? collect(); // collection of BangleCartColor
        $colorModels = $colors->map(fn($bc) => $bc->color)->filter();
        $ordinal = function($n) {
            if ($n % 100 >= 11 && $n % 100 <= 13) return $n . 'th';
            switch ($n % 10) { case 1: return $n . 'st'; case 2: return $n . 'nd'; case 3: return $n . 'rd'; default: return $n . 'th'; }
        };

        // split colors into two groups for toggling
        $totalColors = $colorModels->count();
        $half = (int) ceil($totalColors / 2);
        $groupA = $colorModels->slice(0, $half);
        $groupB = $colorModels->slice($half);
    @endphp

    <article class="product bangle-box">
        <header class="bangle-header" style="background: white !important;">
            {{-- Wrap images and remove link into same clickable area like other products --}}
            <a href="#" class="remove remove-bangle" data-id="{{ $item->id }}">
                <div class="bundle-images" data-item-id="{{ $item->id }}">
                    <div class="img-group group-a @if($groupB->isEmpty()) active @endif">
                        @if($groupA->isEmpty())
                            <img src="{{ asset('assets/images/no-image.png') }}" alt="No image">
                        @else
                            @foreach($groupA as $c)
                                <img src="{{ asset('assets/images/bangle-box/' . ($c->image ?? 'no-image.png')) }}"
                                     alt="{{ $c->color_name ?? '' }}">
                            @endforeach
                        @endif
                    </div>

                    @if($groupB->isNotEmpty())
                    <div class="img-group group-b">
                        @foreach($groupB as $c)
                            <img src="{{ asset('assets/images/bangle-box/' . ($c->image ?? 'no-image.png')) }}"
                                 alt="{{ $c->color_name ?? '' }}">
                        @endforeach
                    </div>
                    @endif
                </div>

                <h3 class="sr-only">Remove Bangle Box</h3>
            </a>
        </header>

        <div class="content bangle-content">
            <h1>Build Your Own Bangle Box</h1>

            <p><strong>Size:</strong> {{ optional($bangleSize)->size ?? ($item->bangle_size_id ? 'Size #' . $item->bangle_size_id : '-') }}</p>

            <p>
                <strong>Box size:</strong>
                {{ optional($bangleBox)->size ?? ($item->box_size ?? '-') }}
                @if(optional($bangleBox)->price)
                    &nbsp; - &nbsp; ${{ number_format(optional($bangleBox)->price, 2) }} CAD
                @endif
            </p>

            <div class="mt-2 bangle-colors-list">
                @if($colorModels->isEmpty())
                    <p><em>No colors selected</em></p>
                @else
                    @foreach($colorModels as $index => $color)
                        <p>
                            <strong>{{ $ordinal($index + 1) }} Color:</strong>
                            {{ $color->color_name ?? '-' }}
                        </p>
                    @endforeach
                @endif
            </div>
        </div>

        <footer class="content bangle-footer">
            <div class="product-price">
                @php
                    $unitPrice = $bangleBox->price ?? 0;
                    $qty = (int) ($item->qty ?? 1);
                    $totalPrice = $unitPrice * $qty;
                @endphp

                <h2 class="full-price">$ {{ number_format($totalPrice, 2) }}</h2>
                <h2 class="price">$ {{ number_format((float) $unitPrice, 2) }}</h2>
            </div>

            <div class="plus-minus-button">
                <button type="button" class="qt-minus" data-type="bangle_box" data-id="{{ $item->id }}" @if($qty <=1) disabled @endif>-</button>
                <span class="qt">{{ $qty }}</span>
                <button type="button" class="qt-plus" data-type="bangle_box" data-id="{{ $item->id }}">+</button>
            </div>
        </footer>
    </article>
@endforeach
</section> -->



            <div class="best-seller-product">
              <h1>Top Seller</h1>
              <div class="carousel">
                @if($topListedProducts->isEmpty())
                <p>No top Seller products available.</p>
                @else
                @foreach($topListedProducts as $topProduct)
                <div class="card cursor-pointer"
                  onclick="window.location='{{ route('product.detail', $topProduct->slug) }}'">

                  {{-- First Image --}}
                  @php
                  if (is_array($topProduct->images) && !empty($topProduct->images)) {
                  $firstImage = 'assets/images/products/' . $topProduct->images[0];
                  } else {
                  $firstImage = 'assets/images/no-image.png';
                  }
                  @endphp

                  <img src="{{ asset($firstImage) }}" alt="{{ $topProduct->name }}" class="w-full h-48 object-cover">

                  <div class="card-content p-3 pt-0">
                    <h4>{{ $topProduct->name }}</h4>
                  </div>
                </div>
                @endforeach

                @endif

              </div>

              {{-- ✅ Only show nav buttons if more than 3 products --}}
              @if($topListedProducts->count() > 2)
              <div class="nav-buttons">
                <button class="nav prev">
                  <img src="{{ asset('assets/images/slide-left.png') }}" alt="Prev">
                </button>
                <button class="nav next">
                  <img src="{{ asset('assets/images/slide-right.png') }}" alt="Next">
                </button>
              </div>
              @endif
            </div>

          </div>

          <footer id="site-footer">
            <div class="clearfix order-summary" style="display:none;">
              <h1>Order Summary</h1>
              <div class="left">
                <h2 class="subtotal">Subtotal: <span> $ 163.96</span> </h2>
                <h3 class="tax">Taxes (5%): <span> $ 8.2 </span></h3>
                <h3 class="shipping">Shipping: <span> $ 5.00 </span> </h3>
              </div>

              <div class="right">
                <h1 class="total">Total: <span>$ 177.16 </span></h1>
                <a href="{{ url('/check-out') }}" class="btn ">Checkout</a>
              </div>
            </div>

            <div class="promo-section" style="display:none;">
              <h1>Gift Card</h1>
              <div class="promo-field">
                <div class="form-group">
                  <input type="text">
                </div>
                <div class="btn apply-btn">
                  Apply
                </div>
              </div>

            </div>

            <div class="promo-section" style="display:none;">
              <h1>Rewards & Points</h1>
              <div class="promo-field">
                <div class="form-group">
                  <p>Sign in to account to redeem Rewards, check out faster, and view your order history.</p>
                </div>
                <div class="btn apply-btn">
                  Sign In Or Join
                </div>
              </div>

            </div>
          </footer>
        </div>
      </div>
    </div>



    </div>
  </x-slot>
  <x-slot name="insertjavascript">
    <script>
      (function() {
        // helper: parse numeric value from strings like "14.99 $" or " 14.99 "
        function parseMoney(str) {
          if (str === null || typeof str === 'undefined') return 0;
          var s = String(str).replace(/[^0-9.\-]/g, '');
          var n = parseFloat(s);
          return isNaN(n) ? 0 : n;
        }

        function changeTotal() {
          var subtotal = 0;
          $(".full-price").each(function() {
            subtotal += parseMoney($(this).text());
          });

          subtotal = Math.round(subtotal * 100) / 100;
          var tax = Math.round(subtotal * 0.05 * 100) / 100;

          var $shippingSpan = $(".shipping span").first();
          var shipping = 0;
          if ($shippingSpan.length) {
            var dataShipping = $shippingSpan.data('shipping');
            shipping = (typeof dataShipping !== 'undefined' && dataShipping !== null) ?
              parseMoney(dataShipping) :
              parseMoney($shippingSpan.text());
          }

          var total = Math.round((subtotal + tax + shipping) * 100) / 100;

          // update DOM
          $(".subtotal span").text("$ " + subtotal.toFixed(2));
          $(".tax span").text("$ " + tax.toFixed(2));
          $(".shipping span").text("$ " + shipping.toFixed(2));
          $(".total span").text("$ " + total.toFixed(2));

          // hide/show Order Summary
          if (subtotal <= 0) {
            $(".order-summary").hide();
          } else {
            $(".order-summary").show();
          }
        }

        // attach handlers when DOM ready
        $(document).ready(function() {
          changeTotal(); // initial total calc

          // detach previous handlers just in case
          $(".qt-plus").off('click');
          $(".qt-minus").off('click');

          function updateStockUI($article, qty) {
            var stock = parseInt($article.data('stock')) || 0;
            var $plusBtn = $article.find('.qt-plus');
            var $minusBtn = $article.find('.qt-minus');
            var $stockMsg = $article.find('.stock-msg');

            // Update buttons
            if (qty >= stock) {
              $plusBtn.prop('disabled', true);
            } else {
              $plusBtn.prop('disabled', false);
            }
            if (qty <= 1) {
              $minusBtn.prop('disabled', true);
            } else {
              $minusBtn.prop('disabled', false);
            }
            // alert(stock);
            // Update stock message
            if (stock - qty <= 0) {
              $stockMsg.text("No more product available").removeClass().addClass("stock-msg text-danger");
              $plusBtn.prop('disabled', true);
            } else if (stock - qty <= 5) {
              $stockMsg.text("Only " + (stock - qty) + " left").removeClass().addClass("stock-msg text-warning");
            } else {
              // $stockMsg.text((stock - qty) + " in stock").removeClass().addClass("stock-msg text-success");
            }
          }

          // PLUS handler
          $(".qt-plus").on('click', function(e) {
            e.preventDefault();
            var $btn = $(this);
            var typeId = $btn.data('id');
            var variationId = $btn.data('variationId') || $btn.data('variation-id') || null;
            var $article = $btn.closest('article.product');
            var $qtyEl = $article.find('.qt').first();
            var currentQty = parseInt($qtyEl.text()) || 1;
            var newQty = currentQty + 1;

            var unitVal = parseMoney($article.find('.price').first().text());
            var newFull = Math.round(unitVal * newQty * 100) / 100;

            $qtyEl.text(newQty);
            $article.find('.full-price').first().text(' $' + newFull.toFixed(2));

            // animation
            $article.find('.full-price').addClass('added');
            setTimeout(function() {
              $article.find('.full-price').removeClass('added');
            }, 150);

            // Update stock UI
            updateStockUI($article, newQty);

            if (typeof changeTotal === 'function') changeTotal();

            // Send update to server
            var payload = {
              id: typeId,
              qty: newQty
            };
            if (variationId) payload.variation_id = variationId;

            if (typeof sendCartUpdate === 'function') {
              sendCartUpdate(payload);
            } else {
              // fallback fetch
              var csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
              var form = new FormData();
              Object.keys(payload).forEach(k => form.append(k, payload[k]));
              fetch(cartAddUrl, {
                method: 'POST',
                headers: {
                  'X-CSRF-TOKEN': csrf,
                  'Accept': 'application/json'
                },
                body: form,
                credentials: 'same-origin'
              });
            }
          });

          // MINUS handler
          $(".qt-minus").on('click', function(e) {
            e.preventDefault();
            var $btn = $(this);
            var typeId = $btn.data('id');
            var variationId = $btn.data('variationId') || $btn.data('variation-id') || null;
            var $article = $btn.closest('article.product');
            var $qtyEl = $article.find('.qt').first();
            var currentQty = parseInt($qtyEl.text()) || 1;
            if (currentQty <= 1) return;
            var newQty = currentQty - 1;

            var unitVal = parseMoney($article.find('.price').first().text());
            var newFull = Math.round(unitVal * newQty * 100) / 100;

            $qtyEl.text(newQty);
            $article.find('.full-price').first().text(' $' + newFull.toFixed(2));

            // animation
            $article.find('.full-price').addClass('minused');
            setTimeout(function() {
              $article.find('.full-price').removeClass('minused');
            }, 150);

            // Update stock UI
            updateStockUI($article, newQty);

            if (typeof changeTotal === 'function') changeTotal();

            // Send update to server
            var payload = {
              id: typeId,
              qty: newQty
            };
            if (variationId) payload.variation_id = variationId;

            if (typeof sendCartUpdate === 'function') {
              sendCartUpdate(payload);
            } else {
              var csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
              var form = new FormData();
              Object.keys(payload).forEach(k => form.append(k, payload[k]));
              fetch(cartAddUrl, {
                method: 'POST',
                headers: {
                  'X-CSRF-TOKEN': csrf,
                  'Accept': 'application/json'
                },
                body: form,
                credentials: 'same-origin'
              });
            }
          });

          // Initialize stock UI on page load
          $("article.product").each(function() {
            var $article = $(this);
            var qty = parseInt($article.find('.qt').first().text()) || 1;
            updateStockUI($article, qty);
          });
        });




      })();
    </script>


    <script>
      (function() {
        const cartRemoveUrl = '{{ route("cart.remove") }}';

        // Delegated handler so it works for dynamically added rows too
        $(document).on('click', '.remove', function(e) {
          e.preventDefault();
          e.stopImmediatePropagation();

          const $remove = $(this);
          const cartId = $remove.data('id');
          if (!cartId) {
            if (typeof Toast !== 'undefined') Toast.fire({
              icon: 'error',
              title: 'Missing cart id.'
            });
            return;
          }
          const $article = $remove.closest('article.product');
          const isBundle = $article.hasClass('bundle');
          $remove.prop('disabled', true);

          // Prepare request
          const csrfMeta = document.querySelector('meta[name="csrf-token"]');
          const csrf = csrfMeta ? csrfMeta.getAttribute('content') : '';
          const form = new FormData();
          form.append('id', cartId);

          fetch(cartRemoveUrl, {
              method: 'POST',
              headers: {
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json'
              },
              body: form,
              credentials: 'same-origin'
            })
            .then(function(res) {
              return res.json().catch(() => ({})).then(function(data) {
                if (res.ok) {

                  // animate removal (matches your existing animation)
                  $article.addClass('removed');
                  setTimeout(function() {
                    $article.slideUp('fast', function() {
                      $article.remove();
                      // If cart is empty, show fallback text (same as your original logic)
                      if ($(".product").length === 0) {
                        $("#cart").html("<h1>No products!</h1>");
                      }

                      // Update totals

                      if (typeof changeTotal === 'function') changeTotal();
                    });
                  }, 200);

                  // Toast success
                  if (typeof Toast !== 'undefined') {
                    Toast.fire({
                      icon: 'success',
                      title: data.message || 'Item removed from cart.'
                    });
                    loadCartBadge();
                  }

                  // If removed a bundle, refresh sidebar (your existing behaviour)
                  if (isBundle && typeof loadBundleSidebar === 'function') {
                    loadBundleSidebar();
                  }
                } else {
                  // Error from server
                  if (typeof Toast !== 'undefined') {
                    Toast.fire({
                      icon: 'error',
                      title: data.message || 'Failed to remove item.'
                    });
                  }
                  $remove.prop('disabled', false);
                }
              });
            })
            .catch(function() {
              if (typeof Toast !== 'undefined') {
                Toast.fire({
                  icon: 'error',
                  title: 'Network error. Please try again.'
                });
              }
              $remove.prop('disabled', false);
            });
        });
      })();
    </script>


    <script>
      (function() {
        // When user changes the dropdown
        $(document).on('change', '.bundle-switcher', function() {
          var $select = $(this);
          var selectedId = $select.val();
          var $article = $select.closest('article.product.bundle');

          // Get bundle data from data attribute
          var bundleData = $article.data('bundle'); // already JSON from Blade
          if (!bundleData) return;

          // Find the selected item
          var selected = bundleData.find(function(bp) {
            return String(bp.id) === String(selectedId);
          });
          if (!selected) return;

          // === Update Title ===
          $article.find('.bundle-title').text(selected.product.name);

          // === Update Variation Description ===
          var variationText = '';
          if (selected.variation) {
            variationText = 'Variation: ' + (selected.variation.size || '');
            if (selected.variation.color) {
              variationText += (selected.variation.size ? ' - ' : '') + selected.variation.color;
            }
          }
          $article.find('.bundle-desc').text(variationText);

          // === Update Images (max 3) ===
          var $imgContainer = $article.find('.bundle-images');
          $imgContainer.empty();

          if (selected.product.images && selected.product.images.length > 0) {
            selected.product.images.slice(0, 3).forEach(function(img) {
              var $img = $('<img>', {
                src: "{{ asset('assets/images/products') }}/" + img,
                alt: 'product-image'
              });
              $imgContainer.append($img);
            });
          } else {
            // fallback image
            $imgContainer.append('<img src="{{ asset("assets/images/products/c-1.jpg") }}" alt="product-image">');
          }

        });
      })();
    </script>
    <script>
      document.addEventListener("DOMContentLoaded", function() {
        const carousel = document.querySelector(".carousel");
        const prevBtn = document.querySelector(".nav.prev");
        const nextBtn = document.querySelector(".nav.next");

        if (carousel && prevBtn && nextBtn) {
          const cardWidth = carousel.querySelector(".card")?.offsetWidth || 200; // fallback

          prevBtn.addEventListener("click", () => {
            carousel.scrollBy({
              left: -cardWidth,
              behavior: "smooth"
            });
          });

          nextBtn.addEventListener("click", () => {
            carousel.scrollBy({
              left: cardWidth,
              behavior: "smooth"
            });
          });
        }
      });
    </script>
    <script>
      document.addEventListener("DOMContentLoaded", function() {
        const carousel = document.querySelector(".carousel");
        const prevBtn = document.querySelector(".nav.prev");
        const nextBtn = document.querySelector(".nav.next");
        const cards = carousel.querySelectorAll(".card");

        if (carousel && prevBtn && nextBtn && cards.length > 0) {
          const cardWidth = cards[0].offsetWidth + 10; // include margin-right
          const visibleCards = 3; // based on your CSS calc(100% / 3)
          const totalCards = cards.length;

          nextBtn.addEventListener("click", () => {
            if (carousel.scrollLeft + carousel.offsetWidth >= carousel.scrollWidth - 5) {
              // ✅ If at the end → go back to start
              carousel.scrollTo({
                left: 0,
                behavior: "smooth"
              });
            } else {
              carousel.scrollBy({
                left: cardWidth * visibleCards,
                behavior: "smooth"
              });
            }
          });

          prevBtn.addEventListener("click", () => {
            if (carousel.scrollLeft <= 0) {
              // ✅ If at the start → jump to end
              carousel.scrollTo({
                left: carousel.scrollWidth,
                behavior: "smooth"
              });
            } else {
              carousel.scrollBy({
                left: -cardWidth * visibleCards,
                behavior: "smooth"
              });
            }
          });
        }
      });
    </script>
<!-- <script>
(function() {
  // cycle interval in ms
  const INTERVAL = 1000;

  // For each bangle item, find the bundle-images and cycle group-a / group-b
  document.querySelectorAll('.bundle-images').forEach(function(container) {
    const groupA = container.querySelector('.img-group.group-a');
    const groupB = container.querySelector('.img-group.group-b');

    // nothing to toggle when only one group exists
    if (!groupB) {
      if (groupA) groupA.classList.add('active');
      return;
    }

    // start with groupA active
    groupA.classList.add('active');

    let showA = true;
    setInterval(() => {
      showA = !showA;
      if (showA) {
        groupA.classList.add('active');
        groupB.classList.remove('active');
      } else {
        groupB.classList.add('active');
        groupA.classList.remove('active');
      }
    }, INTERVAL);
  });
})();
</script> -->
<script>
  const bangleImageBase = "{{ asset('assets/images/bangle-box') }}"; // ✅ Laravel base URL

  $(document).on('change', '.bangle-switcher', function() {
    const $select = $(this);
    const selectedIndex = parseInt($select.val());
    const $article = $select.closest('article.product.bundle.bangle-like');
    const bangleData = $article.data('bangle') || [];

    if (!bangleData || !bangleData[selectedIndex]) return;

    const selected = bangleData[selectedIndex];

    // === Update image (fix path) ===
    const $img = $article.find('.bundle-images img.active-image');
    const encodedImg = encodeURIComponent(selected.image);
    $img.attr('src', `${bangleImageBase}/${encodedImg}`);

    // === Update color name ===
    $article.find('.bangle-current-color span').text(selected.name);
  });
</script>

<!-- <script>
(function(){
  const GAP = 8; // must match CSS .bundle-images gap
  const PADDING = 12; // small padding allowance inside header
  const DEFAULT_HEADER = 270; // default header height in px
  const MAX_HEADER = 480; // max allowed header height before enabling scroll
  const INTERVAL = 1000; // toggle interval ms

  function adjustBangleImages() {
    document.querySelectorAll('.product.bangle-box').forEach(item => {
      const productRoot = item;
      const header = item.querySelector('.bangle-header');
      const bundle = item.querySelector('.bundle-images');
      if (!header || !bundle) return;

      // groups inside bundle
      const groups = Array.from(bundle.querySelectorAll('.img-group'));
      if (groups.length === 0) return;

      // compute max images shown at once across groups (groupA or groupB)
      let maxCount = 0;
      groups.forEach(g => {
        const cnt = g.querySelectorAll('img').length;
        if (cnt > maxCount) maxCount = cnt;
      });
      if (maxCount === 0) return;

      // compute desired image height
      let idealImgH;
      if (maxCount <= 2) idealImgH = 110;
      else if (maxCount <= 3) idealImgH = 90;
      else if (maxCount <= 5) idealImgH = 72;
      else idealImgH = 56;

      const totalGaps = Math.max(0, (maxCount - 1) * GAP);
      const neededHeight = Math.max(DEFAULT_HEADER, (idealImgH * maxCount) + totalGaps + PADDING);

      let finalHeaderHeight = Math.min(neededHeight, MAX_HEADER);
      productRoot.style.setProperty('--header-height', finalHeaderHeight + 'px');

      if (neededHeight > MAX_HEADER) {
        bundle.style.overflowY = 'auto';
        bundle.style.maxHeight = (finalHeaderHeight - 8) + 'px';
      } else {
        bundle.style.overflowY = '';
        bundle.style.maxHeight = '';
      }

      const headerHeightPx = finalHeaderHeight;
      const available = Math.max(48, headerHeightPx - totalGaps - PADDING);
      const imgH = Math.max(40, Math.floor(available / maxCount));

      bundle.querySelectorAll('img').forEach(img => {
        img.style.height = imgH + 'px';
        img.style.width = 'auto';
      });
    });
  }

  function initAndStartToggle() {
    document.querySelectorAll('.bundle-images').forEach(container => {
      const groupA = container.querySelector('.img-group.group-a');
      const groupB = container.querySelector('.img-group.group-b');

      // ensure at least groupA exists
      if (groupA) groupA.classList.add('active');

      // if there's no groupB, just size and continue
      if (!groupB) {
        adjustBangleImages();
        return;
      }

      // both groups exist -> start toggling, ensure groupA visible first
      groupA.classList.add('active');
      groupB.classList.remove('active');
      adjustBangleImages();

      let showA = true;
      setInterval(() => {
        showA = !showA;
        if (showA) {
          groupB.classList.remove('active');
          groupA.classList.add('active');
        } else {
          groupA.classList.remove('active');
          groupB.classList.add('active');
        }
        // recompute sizes after toggle (so scroll/fit remains correct)
        adjustBangleImages();
      }, INTERVAL);
    });
  }

  // init on DOM ready and on resize
  window.addEventListener('DOMContentLoaded', () => {
    initAndStartToggle();
  });

  window.addEventListener('load', () => {
    // in case images load later
    adjustBangleImages();
  });

  window.addEventListener('resize', () => {
    clearTimeout(window._bangleImgResizeTimer);
    window._bangleImgResizeTimer = setTimeout(() => {
      adjustBangleImages();
    }, 120);
  });

  // expose for manual calls if your AJAX changes items
  window.adjustBangleImages = adjustBangleImages;
  window.initBangleToggle = initAndStartToggle;
})();
</script> -->

  </x-slot>
</x-layouts.user-default>

</html>