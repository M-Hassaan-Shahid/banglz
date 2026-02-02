<x-layouts.user-default>
    <x-slot name="insertstyle">
        <style>
          .pre-order-badge {
        background: #935b08ff;
    color: #fefefeff;
    font-size: 12px;
    padding: 2px 6px;
    border-radius: 4px;
    font-weight: 600;
    white-space: nowrap;
}
        </style>
    </x-slot>
    <x-slot name="content">

        <div class="hero-section">
            <div class="left-hero-section">
                @php
                    $homePage = $pageData->where('page_type', 'home')->first() ?? $pageData->where('page_name', 'home')->first();
                    $meta = $homePage && $homePage->meta_data ? (is_array($homePage->meta_data) ? $homePage->meta_data : json_decode($homePage->meta_data, true)) : [];
                    $hero = $meta['sections']['hero'] ?? [];
                @endphp

                    <div class="left-inner-hero-sec">
                        <h1>{{ $hero['heading'] ?? ($homePage->heading ?? 'Create Bangle box for all Styles') }}</h1>

                        <p>{{ $hero['description'] ?? ($homePage->sub_heading ?? 'Explore our diverse selection of bangles designed for every occasion.') }}</p>

                        <div class="selection-sec">
                            <div class="circle-section">1</div>
                            <p>{{ $hero['size_label'] ?? 'Select Your Size' }}</p>
                            <div class="line-section"></div>
                            <div class="circle-section">2</div>
                            <p>{{ $hero['style_label'] ?? 'Select Your Style' }}</p>
                        </div>

                        <a href="{{ url('banglz-box') }}">
                            {{ $hero['button_label'] ?? 'Start building your bangle box' }}
                        </a>
                    </div>
                </div>


           @php
                $images = [];

                if ($hero && isset($hero['images'])) {
                    $decoded = is_array($hero['images']) ? $hero['images'] : [];
                    if (is_array($decoded) && count($decoded) > 0) {
                        $images = $decoded;
                    }
                } elseif ($homePage && !empty($homePage->images)) {
                    $decoded = json_decode($homePage->images, true);
                    if (is_array($decoded) && count($decoded) > 0) {
                        $images = $decoded;
                    }
                }

                // Default if nothing found
                if (empty($images)) {
                    $images = [
                        ['src' => 'Frame 92.png', 'transform' => ''],
                        ['src' => 'Frame 93.png', 'transform' => ''],
                    ];
                }
            @endphp

            <div class="right-hero-section">
                @foreach($images as $img)
                    <div class="sub-right-hero-section" style="width: {{ count($images) === 1 ? '100%' : '50%' }}">
                        <img src="{{ asset('assets/images/pages/'.$img['src']) }}"
                            alt="Hero image"
                            class="setting-image-thumb"
                            style="transform: {{ $img['transform'] ?? 'none' }};">
                    </div>
                @endforeach
            </div>


        </div>

        <div class="category-section" id="featured-categories-slider">
    @if (count($featuredCategories) > 0)
        @foreach ($featuredCategories as $category)
            <div class="category-iner-section"
                style="
                    background-image: linear-gradient(to top, rgba(0,0,0,0.3), rgba(0,0,0,0)),
                        url('{{ asset('assets/images/categories/'.$category->images[0]) }}');
                ">
                <div class="category-content">
                    <h1>{{ $category->name }}</h1>
                    <a href="#">
                        Shop Now
                        <img src="{{ asset('assets/images/right-arrow.png') }}" alt="missing-image" />
                    </a>
                </div>
            </div>
        @endforeach
    @else
        <p>No featured categories available.</p>
    @endif
</div>


        <div class="all-products-main">
            <div class="product-section">
                <h2>Products</h2>

                <!-- Tabs -->
                <div class="tabs">
                    @foreach ($tabsWithProducts as $index => $tab)
                    <button class="tab @if($index === 0) active @endif" data-category="{{ $tab['slug'] }}">
                        {{ $tab['name'] }}
                    </button>
                    @endforeach
                </div>

                <!-- Sliders -->
                <div class="all-carousels">
                    @foreach ($tabsWithProducts as $index => $tab)
                  <div class="carousel-wrapper @if($index === 0) active @endif" data-category="{{ $tab['slug'] }}">
                    <div class="carousel-container">

                        <!-- Left Arrow -->
                        <button class="nav prev">
                            <img src="{{ asset('assets/images/slide-left.png') }}" alt="Prev">
                        </button>

                        <!-- Product Items -->
                        <div class="carousel">
                            @forelse ($tab['products'] as $product)
                            <div class="card position-card">
                                <a href="{{ route('product.detail', $product->slug) }}">
                                    <img src="{{ asset('assets/images/products/' . ($product->images[0] ?? 'default.jpg')) }}" alt="{{ $product->name }}">
                                </a>
                                @php
    $inWishlist = false;

    if (auth()->check()) {
        $inWishlist = \App\Models\WishList::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->exists();
    }
@endphp
                                    <div class="whist-list-button">
                                        <img
  src="{{ asset($inWishlist ? 'assets/images/heart-filled.png' : 'assets/images/heart.png') }}"
  alt="Wishlist"
  class="api-wishlist-button"
  data-product-id="{{ $product->id }}"
/>

        <!-- <img src="{{ asset('assets/images/heart.png') }}"
             alt="Wishlist"
             class="api-wishlist-button"
             data-product-id="{{ $product->id }}"/> -->
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
                                    <!-- <p>{{ Str::limit($product->description, 40) }}</p> -->
                      <span>
    @php
        $userLoggedIn = auth()->check();

        // Base product/variation prices
        $basePrice    = $product->price ?? ($product->variations->first()->price ?? null);
        $memberPrice  = $product->member_price ?? ($product->variations->first()->member_price ?? null);
        $comparePrice = $product->compare_price ?? ($product->variations->first()->compare_price ?? null);
    @endphp

    @if($userLoggedIn)
        @if($memberPrice)
            <span class="text-muted text-decoration-line-through">
                ${{ number_format($basePrice, 2) }}
            </span>
            <span class="fw-bold">
                ${{ number_format($memberPrice, 2) }}
            </span>
        @elseif($comparePrice) {{-- Case 2: logged in, no member price but has compare price --}}
            <span class="text-muted text-decoration-line-through">
                ${{ number_format($basePrice, 2) }}
            </span>
            <span class="fw-bold">
                ${{ number_format($comparePrice, 2) }}
            </span>
        @elseif($basePrice)
            <span class="fw-bold">
                ${{ number_format($basePrice, 2) }}
            </span>
        @else
            <span>N/A</span>
        @endif
    @else {{-- User not logged in --}}
        @if($comparePrice)
            <span class="text-muted text-decoration-line-through">
                ${{ number_format($basePrice, 2) }}
            </span>
            <span class="fw-bold">
                ${{ number_format($comparePrice, 2) }}
            </span>
        @elseif($basePrice)
            <span class="fw-bold">
                ${{ number_format($basePrice, 2) }}
            </span>
        @else
            <span>N/A</span>
        @endif
    @endif

</span>
<div class="add-action-buttons add">
    @if($product->variations && $product->variations->isNotEmpty())
        <button
            class="add-to-bundle"
            onclick="window.location.href='{{ route('product.detail', $product->slug) }}'"
            @if($product->is_pre_order) style="display:none;" @endif>
            Add to Bundle
        </button>
        <button
            class="add-to-card"
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
            class="add-to-card btn-add-to-cart"
            data-type="product"
            data-type-id="{{ $product->id }}">
            {{ $product->is_pre_order ? 'Add to Pre-Order' : 'Add to Cart' }}
        </button>
    @endif
</div>


 <!-- <div class="add-action-buttons  add">
    @if($product->variations && $product->variations->isNotEmpty())
        <button
            class="add-to-bundle"
            onclick="window.location.href='{{ route('product.detail', $product->slug) }}'">
            Add to Bundle
        </button>
        <button
            class="add-to-card"
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
            class="add-to-card btn-add-to-cart"
            data-type="product"
            data-type-id="{{ $product->id }}">
            Add to Cart
        </button>
    @endif
</div> -->
                                </div>
                            </div>
                            @empty
                            <p>No products found.</p>
                            @endforelse
                        </div>

                        <!-- Right Arrow -->
                        <button class="nav next">
                            <img src="{{ asset('assets/images/slide-right.png') }}" alt="Next">
                        </button>
                    </div>

                    <!-- Pagination dots -->
                    <div class="dots-container"></div>
                </div>
                    @endforeach
                </div>

                <!-- Bottom Button -->

            </div>
        </div>



        <!-- Collection section -->
       <div class="category-slider category-section">
        @foreach ($collections ?? [] as $collection)

            <div  onclick="window.location='{{ route('catalog', $collection->slug) }}'"
            class="category-iner-section"
                style="
                    background-image:
                        linear-gradient(to top, rgba(0,0,0,0.3), rgba(0,0,0,0)),
                        url('{{ asset('assets/images/collections/' . ($collection->images[0] ?? 'default.jpg')) }}');
                    background-size: cover;
                    background-position: center;
                    background-repeat: no-repeat;
                ">
                <div class="category-content-two">
                    <span>Discover</span>
                    <h1>{{ $collection->name }}</h1>
                    <p>{{ Str::limit($collection->description ?? 'Explore our collection', 100) }}</p>
                    <a href="{{ route('catalog', $collection->slug) }}">Shop Now</a>
                </div>
            </div>
        @endforeach

    </div>



        @php
            $customize = $meta['sections']['customize'] ?? null;
        @endphp
        <div class="container">
                {{-- banglez box --}}
                <div class="Customize-section">
                    <div class="customize-sec-content">
                        <h1>{{ $customize['heading1'] ?? 'Create bangle box for all styles' }}</h1>
                        <p>{{ $customize['desc1'] ?? 'Select pieces marked with the Complete Your Look tag to build your perfect set. Add three eligible items and unlock exclusive perks, including free styling services and more.' }}</p>
                    </div>
                    <div class="customize-card-main video-servies">
                        <div class="row">
                            @php
                                $cards = $customize['cards'] ?? [];
                            @endphp
                            @for($i=0;$i<3;$i++)
                            @php
                                $card = $cards[$i] ?? [];
                                $cardImg = isset($card['image']) ? asset('assets/images/pages/'.$card['image']) : null;
                            @endphp
                            <div class="col-12 col-md-6 col-lg-4 mt-3">
                                <div class="category-iner-section" style="background-image: url('{{ $cardImg ?? asset('assets/images/about-head.jpg') }}'); background-size: cover; background-position: center;">
                                    <div class="category-content-two">
                                        <h1>{{ $card['title'] ?? 'Choose your Stack' }}</h1>
                                        <p>{{ $card['sub'] ?? 'Pick 6 or 9 bangles from over 250 colors to create your own custom set.' }}</p>
                                    </div>
                                </div>
                            </div>
                            @endfor

                        </div>

                        <div class="complete-look-btn">
                            <a href="{{ url('banglz-box') }}">
                                Start building your bangle box
                            </a>
                        </div>
                    </div>
                </div>

                {{-- customization Buttons --}}
                <div class="Customize-section">
                    <div class="customize-sec-content">
                        <h1>{{ $customize['heading2'] ?? 'Bundle your Look. Unlock Rewards' }}</h1>
                        <p>{{ $customize['desc2'] ?? 'Select pieces marked with the Complete Your Look tag to build your perfect set. Add three eligible items and unlock exclusive perks, including free styling services and more.' }}</p>
                    </div>
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

        {{-- appointment section --}}
        @php
            $appointmentsData = $pageData->firstWhere('page_type', 'appointments');
            $appointmentsHeading = $appointmentsData->heading ?? 'Book Your Personal Appointment';
            $appointmentsDescription = $appointmentsData->description ?? 'Book your personal appointment for styling and personalized consultation';
            $allAppointments = $appointmentsData->meta_data['appointments'] ?? [];
            // Filter out empty appointments
            $appointments = array_filter($allAppointments, function($apt) {
                return !empty($apt['title']) && !empty($apt['description']);
            });
        @endphp
        
        <div class="appointment-section-main">
            <div class="appointment-section-head">
                <h1>{{ $appointmentsHeading }}</h1>
                <p>{{ $appointmentsDescription }}</p>
            </div>
         <div class="appointment-slider">
                @forelse($appointments as $appointment)
                <div class="product-card">
                    <div class="product-card-img">
                        <img src="{{ asset('assets/images/' . ($appointment['image'] ?? 'ear.jpg')) }}" alt="{{ $appointment['title'] ?? '' }}">
                    </div>
                    <div class="product-content">
                        <h3 class="product-title">{{ $appointment['title'] ?? '' }}</h3>
                        <p class="product-desc">
                            {{ $appointment['description'] ?? '' }}
                        </p>
                        <a href="{{ $appointment['link'] ?? url('appointment') }}" class="product-link">
                            Start building
                            <span>
                                <img src="{{ asset('assets/images/right-b-arrow.png') }}" alt="">
                            </span>
                        </a>
                    </div>
                </div>
                @empty
                {{-- Fallback if no appointments data --}}
                <div class="product-card">
                    <div class="product-card-img">
                        <img src="{{ asset('assets/images/ear.jpg') }}" alt="">
                    </div>
                    <div class="product-content">
                        <h3 class="product-title">CUSTOM BANGLE SET</h3>
                        <p class="product-desc">
                            Create your perfect bangle set with our expert guidance.
                        </p>
                        <a href="{{ url('appointment') }}" class="product-link">
                            Start building
                            <span>
                                <img src="{{ asset('assets/images/right-b-arrow.png') }}" alt="">
                            </span>
                        </a>
                    </div>
                </div>
                @endforelse
            </div>

        </div>



    </x-slot>
    <x-slot name="insertjavascript">
       <script>
$(document).ready(function(){
    $('#featured-categories-slider').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        infinite: true,
        arrows: true,
        dots: false,
        prevArrow: '<button type="button" class="slick-prev"><img src="{{ asset('assets/images/slide-left.png') }}" alt="Prev"></button>',
        nextArrow: '<button type="button" class="slick-next"><img src="{{ asset('assets/images/slide-right.png') }}" alt="Next"></button>',
        responsive: [
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 557,
                settings: {
                    slidesToShow: 1,
                }
            }
        ]
    });
});

</script>



    </x-slot>
</x-layouts.user-default>

</html>
