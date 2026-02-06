<x-layouts.user-default>
    <x-slot name="insertstyle">
        <style>
            .add-action-buttons button {
                width: 50%;
            }

            .price span {
                font-size: 16px;
            }

            /* Filter toggle for mobile */
            @media (max-width: 768px) {
                .filter-section-main {
                    position: fixed;
                    left: -100%;
                    top: 0;
                    height: 100vh;
                    width: 80%;
                    max-width: 300px;
                    background: white;
                    z-index: 1000;
                    overflow-y: auto;
                    transition: left 0.3s ease;
                    box-shadow: 2px 0 10px rgba(0,0,0,0.1);
                }

                .filter-section-main.active {
                    left: 0;
                }

                .filter-overlay {
                    display: none;
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0,0,0,0.5);
                    z-index: 999;
                }

                .filter-overlay.active {
                    display: block;
                }
            }
        </style>
    </x-slot>

    <x-slot name="content">
        <div class="product-detail-main-wrapper">
            @php
            $heroImage = (!empty($category->images) && isset($category->images[0]))
            ? asset('assets/images/categories/' . $category->images[0])
            : asset('assets/images/earings.jpg');
            @endphp

            <div class="earings-hero-section" style="
    height: 50vh;
    background:
        linear-gradient(to right, rgba(0,0,0,0.326) 22%, rgba(0,0,0,0.348) 100%),
        url('{{ $heroImage }}') no-repeat right center;
    background-size: cover;
    background-position: right center;
">
                <div class="earing-hero-content container">
                    <h1>{{ $category->name ?? 'Category' }}</h1>
                    <p>{{ $category->description ?? 'Shop the best pieces.' }}</p>
                </div>
            </div>


            {{-- Tabs (subcategories). No "All" tab — first subcategory is active --}}
            <div class="detai-tabs-about shop-all-detail">
                <ul id="shopallTabs" class="custom-tabs shop-tabs ">
                    @foreach($subcategories as $index => $sub)
                    <li data-subslug="{{ $sub->slug }}">{{ $sub->name }}</li>
                    @endforeach
                </ul>

                <div class="tab-content">
                    {{-- Single pane now — filters are common and product list updates via AJAX --}}
                    <div class="tab-main tab-pane active" id="products-pane">
                        <div class="main-earing-section">
                            {{-- FILTERS (COMMON) --}}
                            <div class="filter-section-main" id="filterSidebar">
                                <div class="filter-header">
                                    <div class="filter-header-left" id="filterToggleBtn" style="cursor: pointer;">
                                        Filter <img src="{{ asset('assets/images/filter-icon.png') }}" alt="" />
                                    </div>
                                    <div class="filter-header-right" id="clearAllBtn">Clear all</div>
                                </div>

                                {{-- Materials --}}
                                <div class="filter-section">
                                    <div class="filter-title" onclick="toggleSection(this)">
                                        Material <span>+</span>
                                    </div>
                                    <div class="filter-options">
                                        @foreach($materials as $material)
                                        <label class="custom-checkbox">
                                            <input type="checkbox" name="materials[]" value="{{ $material->slug }}"
                                                {{ (is_array(request('materials')) && in_array($material->slug, request('materials'))) ? 'checked' : '' }}>
                                            <span class="checkmark"></span>
                                            {{ $material->name }}
                                        </label>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Styles --}}
                                <div class="filter-section">
                                    <div class="filter-title" onclick="toggleSection(this)">
                                        Style <span>+</span>
                                    </div>
                                    <div class="filter-options">
                                        @foreach($styles as $style)
                                        <label class="custom-checkbox">
                                            <input type="checkbox" name="styles[]" value="{{ $style->slug }}"
                                                {{ (is_array(request('styles')) && in_array($style->slug, request('styles'))) ? 'checked' : '' }}>
                                            <span class="checkmark"></span>
                                            {{ $style->name }}
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="filter-section">
                                    <div class="filter-title" onclick="toggleSection(this)">
                                        Sizes <span>+</span>
                                    </div>
                                    <div class="filter-options">
                                        @foreach($variations as $variation)
                                        <label class="custom-checkbox">
                                            <input type="checkbox" name="sizes[]" value="{{ $variation->size_label }}"
                                                {{ (is_array(request('sizes')) && in_array($variation->size_label, request('sizes'))) ? 'checked' : '' }}>
                                            <span class="checkmark"></span>
                                            {{ $variation->size_label }}
                                        </label>
                                        @endforeach
                                    </div>

                                </div>
                                <div class="filter-section">
                                    <div class="filter-title" onclick="toggleSection(this)">
                                        Colors <span>+</span>
                                    </div>
                                    <div class="filter-options">
                                        @foreach($colors as $color)
                                        <label class="custom-checkbox" style="color: {{ $color->hex_code }}">
                                            <input type="checkbox" name="colors[]" value="{{ $color->id }}"
                                                {{ (is_array(request('colors')) && in_array($color->id, request('colors'))) ? 'checked' : '' }}>
                                            <span class="checkmark"></span>
                                            {{ $color->name }}
                                        </label>
                                        @endforeach
                                    </div>

                                </div>
                                <div id="boxesFilterWrapper">
                                    @if(isset($boxes) && $boxes->count() > 0)
                                    <div class="filter-section" id="boxes-filter">
                                        <div class="filter-title" onclick="toggleSection(this)">
                                            Boxes <span>+</span>
                                        </div>
                                        <div class="filter-options">
                                            @foreach($boxes as $box)
                                            <label class="custom-checkbox">
                                                <input type="checkbox" name="boxes[]" value="{{ $box->id }}"
                                                    {{ (is_array(request('boxes')) && in_array($box->id, request('boxes'))) ? 'checked' : '' }}>
                                                <span class="checkmark"></span>
                                                {{ $box->name }}
                                            </label>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                </div>



                            </div>

                            <!-- Filter overlay for mobile -->
                            <div class="filter-overlay" id="filterOverlay"></div>

                            {{-- PRODUCTS --}}
                            <div class="earing-products">
                                <div class="sort-container">
                                    <select id="sortOptions" name="sort">
                                        <option value="default" {{ request('sort') == 'default' ? 'selected' : '' }}>Sort</option>
                                        <option value="name-asc" {{ request('sort') == 'name-asc' ? 'selected' : '' }}>Name (A-Z)</option>
                                        <option value="name-desc" {{ request('sort') == 'name-desc' ? 'selected' : '' }}>Name (Z-A)</option>
                                        <option value="price-asc" {{ request('sort') == 'price-asc' ? 'selected' : '' }}>Price (Low to High)</option>
                                        <option value="price-desc" {{ request('sort') == 'price-desc' ? 'selected' : '' }}>Price (High to Low)</option>
                                    </select>
                                    <span class="sort-icon">
                                        <img src="{{ asset('assets/images/sort.png') }}" alt="sort-icon">
                                    </span>
                                </div>

                                <div class="earing-main-grid" id="productList">

                                    <div class="no-results">Loading....</div>
                                </div>

                                <div class="load-more-container" id="loadMoreContainer" style="text-align:center; margin-top:20px;">
                                    <button id="loadMoreBtn">Load More</button>
                                </div>
                            </div>
                        </div>
                    </div> {{-- end products-pane --}}
                </div>
            </div>

            {{-- rest of the page content (Customize sections, video cards, feedback) remain unchanged --}}
            <div class="container">
                {{-- banglez box --}}
                <div class="Customize-section">
                    <div class="customize-sec-content">
                        <h1>Create bangle box for all styles</h1>
                        <p>Select pieces marked with the Complete Your Look tag to build your perfect set. Add three eligible items and unlock exclusive perks, including free styling services and more.</p>
                    </div>
                    <div class="customize-card-main video-servies">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-4 mt-3">
                                <div class="category-iner-section bg1">
                                    <div class="category-content-two">
                                        <h1>Choose your Stack</h1>
                                        <p>Pick 6 or 9 bangles from over 250 colors to create your own custom set.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 mt-3">
                                <div class="category-iner-section bg2">
                                    <div class="category-content-two">
                                        <h1>Choose your Stack</h1>
                                        <p>Pick 6 or 9 bangles from over 250 colors to create your own custom set.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 mt-3">
                                <div class="category-iner-section bg3">
                                    <div class="category-content-two">
                                        <h1>Choose your Stack</h1>
                                        <p>Pick 6 or 9 bangles from over 250 colors to create your own custom set.</p>
                                    </div>
                                </div>
                            </div>

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
                        <h1>Bundle your Look. Unlock Rewards</h1>
                        <p>Select pieces marked with the Complete Your Look tag to build your perfect set.
                            Add three eligible items and unlock exclusive perks, including free styling services and more.</p>
                    </div>
                </div>
            </div>

            {{-- video/cards section --}}
            <div class="customize-card-main video-servies">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-3 mt-3">
                        <div class="customize-card">
                            <img src="{{ asset('assets/images/browsing.png') }}" alt="">
                            <h1>Start Browsing</h1>
                            <p>Items marked with a “Excluded from Bundle + Save” tag will not count toward your reward.</p>
                            <div class="video-section">
                                <video playsinline muted preload="yes" autoplay loop id="vjs_video_1" class="video-js" data-setup='{"autoplay":"any"}'>
                                    <source src="{{ asset('assets/images/product-vid.mp4') }}" type="video/mp4">
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
                                <video playsinline muted preload="yes" autoplay loop id="vjs_video_2" class="video-js" data-setup='{"autoplay":"any"}'>
                                    <source src="{{ asset('assets/images/product-vid.mp4') }}" type="video/mp4">
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
                                <video playsinline muted preload="yes" autoplay loop id="vjs_video_3" class="video-js" data-setup='{"autoplay":"any"}'>
                                    <source src="{{ asset('assets/images/product-vid.mp4') }}" type="video/mp4">
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
                                <video playsinline muted preload="yes" autoplay loop id="vjs_video_4" class="video-js" data-setup='{"autoplay":"any"}'>
                                    <source src="{{ asset('assets/images/product-vid.mp4') }}" type="video/mp4">
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
        <script>
            // Utility: debounce (behavior unchanged)
            function debounce(fn, wait) {
                let t;
                return (...args) => {
                    clearTimeout(t);
                    t = setTimeout(() => fn.apply(this, args), wait);
                };
            }

            // Filter toggle functionality for mobile
            const filterToggleBtn = document.getElementById('filterToggleBtn');
            const filterSidebar = document.getElementById('filterSidebar');
            const filterOverlay = document.getElementById('filterOverlay');

            if (filterToggleBtn && filterSidebar && filterOverlay) {
                // Toggle filter sidebar
                filterToggleBtn.addEventListener('click', function() {
                    filterSidebar.classList.toggle('active');
                    filterOverlay.classList.toggle('active');
                });

                // Close filter when clicking overlay
                filterOverlay.addEventListener('click', function() {
                    filterSidebar.classList.remove('active');
                    filterOverlay.classList.remove('active');
                });
            }

            // Toggle filter sections
            function toggleSection(el) {
                const options = el.nextElementSibling;
                const sign = el.querySelector("span");
                if (!options) return;
                if (options.style.display === "block") {
                    options.style.display = "none";
                    sign.textContent = "+";
                } else {
                    options.style.display = "block";
                    sign.textContent = "–";
                }
            }

            // Cache some commonly used elements (safe optimization)
            const filterCheckboxes = Array.from(document.querySelectorAll('.filter-options input[type="checkbox"]'));
            const shopTabs = Array.from(document.querySelectorAll('#shopallTabs li'));
            const sortSelect = document.getElementById('sortOptions');
            const clearAllBtn = document.getElementById('clearAllBtn');
            const loadMoreEl = document.getElementById('loadMoreBtn');

            // Clear all filters
            if (clearAllBtn) {
                clearAllBtn.addEventListener('click', function() {
                    document.querySelectorAll('.filter-options input[type="checkbox"]').forEach(cb => cb.checked = false);
                    const sortEl = document.querySelector('#sortOptions');
                    if (sortEl) sortEl.value = 'default';
                    // reload products for first subcategory
                    currentPage = 1;
                    loadProducts(currentSubSlug || '', 1, false);
                });
            }

            // currentSubSlug defaults to requested subcategory if present, otherwise first subcategory slug (server-side)
            let currentSubSlug = @json(request('subcategory') ?? ($subcategories -> first() -> slug ?? ''));

            // Attach tab click handlers
            shopTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // UI active classes
                    shopTabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');

                    // set current subslug and load
                    currentSubSlug = this.dataset.subslug || '';
                    currentPage = 1;
                    fetchBoxes(currentSubSlug);
                    loadProducts(currentSubSlug, 1, false);
                });
            });

            // Sort select change (debounced) — wait preserved as in your original usage
            if (sortSelect) {
                sortSelect.addEventListener('change', debounce(function() {
                    currentPage = 1;
                    loadProducts(currentSubSlug || '', 1, false);
                }, 400));
            }

            // Filter checkboxes change (debounced)
            if (filterCheckboxes.length) {
                filterCheckboxes.forEach(cb => {
                    cb.addEventListener('change', debounce(function() {
                        currentPage = 1;
                        loadProducts(currentSubSlug || '', 1, false);
                    }, 400));
                });
            }

            // Build query string from current controls (logic unchanged)
            function buildQueryParams(page = 1, subslug = '') {
                const params = new URLSearchParams();

                if (subslug) params.set('subcategory', subslug);

                // styles
                const styles = Array.from(document.querySelectorAll('input[name="styles[]"]:checked')).map(i => i.value);
                styles.forEach(s => params.append('styles[]', s));

                // materials
                const materials = Array.from(document.querySelectorAll('input[name="materials[]"]:checked')).map(i => i.value);
                materials.forEach(m => params.append('materials[]', m));

                // hoop sizes (other filters)
                const hoops = Array.from(document.querySelectorAll('input[name="hoopsize[]"]:checked')).map(i => i.value);
                hoops.forEach(h => params.append('hoopsize[]', h));

                // sizes
                const sizes = Array.from(document.querySelectorAll('input[name="sizes[]"]:checked')).map(i => i.value);
                sizes.forEach(sz => params.append('sizes[]', sz));

                // colors (added exactly like sizes/materials)
                const colors = Array.from(document.querySelectorAll('input[name="colors[]"]:checked')).map(i => i.value);
                colors.forEach(c => params.append('colors[]', c));

                const boxes = Array.from(document.querySelectorAll('input[name="boxes[]"]:checked'))
                    .map(i => i.value);
                boxes.forEach(b => params.append('boxes[]', b));
                // sort
                const sort = (document.querySelector('#sortOptions') || {}).value;
                if (sort && sort !== 'default') params.set('sort', sort);

                if (page && page > 1) params.set('page', page);

                return params.toString();
            }

            // Base URL for AJAX calls
            const baseUrl = @json(url('shop-all/'.$category -> slug));

            // Load products via AJAX
            // append: if true, append results for Load More, otherwise replace
            async function loadProducts(subslug = '', page = 1, append = false) {
                const qs = buildQueryParams(page, subslug);
                const url = baseUrl + (qs ? ('?' + qs) : '');

                try {
                    const res = await fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    if (!res.ok) throw new Error('Network response was not ok');

                    const html = await res.text();

                    const container = document.getElementById('productList');
                    if (!container) return; // safety

                    // If appending, append; otherwise replace
                    if (append) {
                        const temp = document.createElement('div');
                        temp.innerHTML = html;
                        temp.querySelectorAll('.card').forEach(card => container.appendChild(card));
                    } else {
                        container.innerHTML = html;
                        container.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }

                    // <<< REMOVED: no history.replaceState here so URL will NOT change >>>

                    // Determine if there are more products to load:
                    const returnedCards = (new DOMParser()).parseFromString(html, 'text/html').querySelectorAll('.card').length;
                    const perPage = @json($products -> perPage() ?? 10);
                    const loadMoreBtn = document.getElementById('loadMoreBtn');
                    if (loadMoreBtn) {
                        if (!returnedCards || returnedCards < perPage) {
                            loadMoreBtn.style.display = 'none';
                        } else {
                            loadMoreBtn.style.display = 'inline-block';
                        }
                    }
                } catch (err) {
                    console.error('Failed to load products', err);
                }
            }

            // Load More button
            let currentPage = parseInt(@json(request('page') ?? 1));
            if (loadMoreEl) {
                loadMoreEl.addEventListener('click', async function() {
                    currentPage = currentPage + 1;
                    await loadProducts(currentSubSlug || '', currentPage, true);
                });
            }

            // On first load - replace server-rendered list with first subcategory products (if there are subcategories)
            (function init() {
                const hasSubcategories = @json($subcategories -> count() > 0);

                // Ensure the tab matching currentSubSlug is selected (if present), otherwise first tab remains active
                if (hasSubcategories && currentSubSlug) {
                    document.querySelectorAll('#shopallTabs li').forEach(t => {
                        t.classList.toggle('active', (t.dataset.subslug || '') === (currentSubSlug || ''));
                    });
                }

                // If there are subcategories, force load products for the first subcategory on page load.
                if (hasSubcategories && currentSubSlug) {
                    currentPage = 1;
                    loadProducts(currentSubSlug, 1, false);
                } else {
                    // no subcategories: keep server rendered list, but still handle load more visibility
                    const initialCards = document.querySelectorAll('#productList .card').length;
                    const perPage = @json($products -> perPage() ?? 10);
                    const loadMoreBtn = document.getElementById('loadMoreBtn');
                    if (loadMoreBtn && initialCards < perPage) {
                        loadMoreBtn.style.display = 'none';
                    }
                }
            })();
        </script>
        <script>
            /**
             * Fetch boxes (JSON) and render EXACTLY the same filter block.
             * Uses route template generated by Blade and replaces '__slug__' with slug.
             * Then delegates change events so dynamically inserted checkboxes trigger product reloads.
             */
            (function() {
                // route template from Blade (must exist)
                const getBoxesUrlTemplate = @json(route('categories.getBoxes.slug', ['slug' => '__slug__']));

                // HTML escaping helper
                function escapeHtml(unsafe) {
                    return String(unsafe).replace(/[&<>"']/g, function(m) {
                        return ({
                            '&': '&amp;',
                            '<': '&lt;',
                            '>': '&gt;',
                            '"': '&quot;',
                            "'": '&#39;'
                        } [m]);
                    });
                }

                // Debounced reload (calls your loadProducts function if present)
                let __filtersTimeout = null;

                function scheduleReload() {
                    if (typeof loadProducts !== 'function') {
                        // fallback: submit form or reload page if you use other method
                        // document.getElementById('filterForm')?.submit();
                        return;
                    }
                    if (__filtersTimeout) clearTimeout(__filtersTimeout);
                    __filtersTimeout = setTimeout(() => {
                        // call loadProducts (preserves current subslug via your buildQueryParams)
                        try {
                            loadProducts();
                        } catch (e) {
                            console.error(e);
                        }
                    }, 300);
                }

                // Delegated handler (attach once)
                if (!window.__filtersDelegated) {
                    document.addEventListener('change', function(e) {
                        // if any checkbox with name boxes[] changed => reload
                        if (e.target && (e.target.matches('input[name="boxes[]"]') || e.target.matches('input[name="sizes[]"]') || e.target.matches('input[name="colors[]"]'))) {
                            scheduleReload();
                        }
                    }, {
                        capture: false
                    });
                    window.__filtersDelegated = true;
                }

                // main function to fetch and render boxes
                window.fetchBoxes = async function(slug) {
                    if (!slug) return;

                    try {
                        const url = getBoxesUrlTemplate.replace('__slug__', slug);
                        const res = await fetch(url, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        if (!res.ok) throw new Error('Network response was not ok');

                        // response is JSON array: [{id, name}, ...]
                        const boxes = await res.json();
                        const wrapper = document.getElementById('boxesFilterWrapper');
                        if (!wrapper) return;

                        // parse selected boxes from URL (supports boxes[] or boxes)
                        const params = new URLSearchParams(window.location.search);
                        const selectedQS = params.getAll('boxes[]').concat(params.getAll('boxes'));
                        const selectedSet = new Set(selectedQS.map(String));

                        // Also include any currently checked checkboxes on page before overwrite
                        document.querySelectorAll('input[name="boxes[]"]:checked').forEach(el => {
                            if (el.value) selectedSet.add(String(el.value));
                        });

                        if (Array.isArray(boxes) && boxes.length > 0) {
                            // build HTML identical to your Blade markup
                            let html = '<div class="filter-section" id="boxes-filter">';
                            html += '<div class="filter-title" onclick="toggleSection(this)">Boxes <span>+</span></div>';
                            html += '<div class="filter-options">';

                            boxes.forEach(box => {
                                const id = escapeHtml(box.id);
                                const name = escapeHtml(box.name);
                                const checked = selectedSet.has(String(box.id)) ? ' checked' : '';
                                html += `<label class="custom-checkbox">
                                <input type="checkbox" name="boxes[]" value="${id}"${checked}>
                                <span class="checkmark"></span>
                                ${name}
                             </label>`;
                            });

                            html += '</div></div>';

                            wrapper.innerHTML = html;
                            wrapper.style.display = 'block';
                        } else {
                            // no boxes => clear/hide
                            wrapper.innerHTML = '';
                            wrapper.style.display = 'none';
                        }
                    } catch (err) {
                        console.error('Failed to fetch boxes:', err);
                    }
                };

                // Optional: if you want to auto-load boxes for the first tab on page load,
                // call fetchBoxes(initialSlug) here (if initialSlug available)
            })();
        </script>


        </script>

    </x-slot>

</x-layouts.user-default>