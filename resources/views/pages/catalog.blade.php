<x-layouts.user-default>
    <x-slot name="insertstyle">
    </x-slot>
    <x-slot name="content">
        <div class="product-detail-main-wrapper top-paddings-set">
            <div class="catalog-hero-section">
                <div class="catalog-hero-content">
                    <div class="catalog-left">
                        <h1>
                            {{ $collection->name ?? 'Catalog' }}
                        </h1>
                        <!-- <h1>MOTHER’S
                            <br>
                            DAY
                            <br>
                            GUIDE</h1> -->
                    </div>
                    <div class="catelog-right">
                        <img src="{{ asset('assets/images/collections/'.($collection->images[0] ?? 'default.jpg')) }}" alt="missing"/>
                    </div>
                </div>
            </div>

            {{-- detail about us --}}
            <div class="catalog-tabs">
                    <ul id="catologTabs" class="custom-tabs catalog-ul ">
                        <li class="active" data-tab="BANGLES">BANGLES</li>
                        <li data-tab="NECKLACES">NECKLACES</li>
                        <li data-tab="EARRINGS">EARRINGS</li>
                        <li data-tab="MOST-GIFTED">MOST GIFTED</li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-main tab-pane catalog-pane active" id="BANGLES">
                             <div class="tabs-main-content container">
                                {{-- <div class="tabs-head-content">
                                    <h2>BANGLES FOR MOM</h2>
                                </div> --}}
                                <div class="custom-slider">
                                    <!-- Half height card -->
                                    <div class="card half-card">
                                        <div class="img-wrap">
                                            <img src="{{asset('assets/images/6.jpg')}}" alt="Gift">
                                            <button class="gift-btn"><img src="{{asset('assets/images/gift.png')}}" alt="mising icon"/></button>
                                        </div>
                                        {{-- <div class="caption-btn">
                                            <a href="#">SHOP PERSONALIZED GIFTS <img src="{{asset('assets/images/right-b-arrow.png')}}" alt="mising icon"/></a>
                                        </div> --}}
                                    </div>

                                    <!-- Full height cards -->
                                    <div class="card tall-card">
                                        <img src="{{asset('assets/images/banglz-1.jpg')}}" alt="Model 1">
                                        <button class="gift-btn"><i class="fas fa-gift"></i></button>
                                    </div>

                                    <div class="card tall-card">
                                        <img src="{{asset('assets/images/banglz-2.jpg')}}" alt="Model 2">
                                        <button class="gift-btn"><i class="fas fa-gift"></i></button>
                                    </div>

                                    <div class="card tall-card">
                                        <img src="{{asset('assets/images/earings.jpg')}}" alt="Model 3">
                                        <button class="gift-btn"><i class="fas fa-gift"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane catalog-pane" id="NECKLACES">
                             <div class="tabs-main-content container">
                                {{-- <div class="tabs-head-content">
                                    <h2>NECKLACES FOR MOM</h2>
                                </div> --}}
                                <div class="custom-slider">
                                    <!-- Half height card -->
                                    <div class="card half-card">
                                        <div class="img-wrap">
                                            <img src="{{asset('assets/images/earings.jpg')}}" alt="Gift">
                                            <button class="gift-btn"><img src="{{asset('assets/images/gift.png')}}" alt="mising icon"/></button>
                                        </div>
                                        {{-- <div class="caption-btn">
                                            <a href="#">SHOP PERSONALIZED GIFTS <img src="{{asset('assets/images/right-b-arrow.png')}}" alt="mising icon"/></a>
                                        </div> --}}
                                    </div>

                                    <!-- Full height cards -->
                                    <div class="card tall-card">
                                        <img src="{{asset('assets/images/earings.jpg')}}" alt="Model 1">
                                        <button class="gift-btn"><i class="fas fa-gift"></i></button>
                                    </div>

                                    <div class="card tall-card">
                                        <img src="{{asset('assets/images/earings.jpg')}}" alt="Model 2">
                                        <button class="gift-btn"><i class="fas fa-gift"></i></button>
                                    </div>

                                    <div class="card tall-card">
                                        <img src="{{asset('assets/images/earings.jpg')}}" alt="Model 3">
                                        <button class="gift-btn"><i class="fas fa-gift"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane catalog-pane" id="EARRINGS">
                               <div class="tabs-main-content container">
                                {{-- <div class="tabs-head-content">
                                    <h2>BANGLES FOR MOM</h2>
                                </div> --}}
                                <div class="custom-slider">
                                    <!-- Half height card -->
                                    <div class="card half-card">
                                        <div class="img-wrap">
                                            <img src="{{asset('assets/images/6.jpg')}}" alt="Gift">
                                            <button class="gift-btn"><img src="{{asset('assets/images/gift.png')}}" alt="mising icon"/></button>
                                        </div>
                                        {{-- <div class="caption-btn">
                                            <a href="#">SHOP PERSONALIZED GIFTS <img src="{{asset('assets/images/right-b-arrow.png')}}" alt="mising icon"/></a>
                                        </div> --}}
                                    </div>

                                    <!-- Full height cards -->
                                    <div class="card tall-card">
                                        <img src="{{asset('assets/images/earing-1.jpg')}}" alt="Model 1">
                                        <button class="gift-btn"><i class="fas fa-gift"></i></button>
                                    </div>

                                    <div class="card tall-card">
                                        <img src="{{asset('assets/images/earing-2.jpg')}}" alt="Model 2">
                                        <button class="gift-btn"><i class="fas fa-gift"></i></button>
                                    </div>

                                    <div class="card tall-card">
                                        <img src="{{asset('assets/images/earing-3.jpg')}}" alt="Model 3">
                                        <button class="gift-btn"><i class="fas fa-gift"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane catalog-pane" id="MOST-GIFTED">
                             <div class="tabs-main-content container">
                                <div class="tabs-head-content">
                                    <h1>THE GIFT GUIDE</h1>
                                    <p>She does it all and she deserves it all.Find the perfect gift for Mom.</p>
                                    {{-- <h2>PERSONALIZED GIFTS</h2> --}}
                                </div>
                                <div class="custom-slider">
                                    <!-- Half height card -->
                                    <div class="card half-card">
                                        <div class="img-wrap">
                                            <img src="{{asset('assets/images/earings.jpg')}}" alt="Gift">
                                            <button class="gift-btn"><img src="{{asset('assets/images/gift.png')}}" alt="mising icon"/></button>
                                        </div>
                                        {{-- <div class="caption-btn">
                                            <a href="#">SHOP PERSONALIZED GIFTS <img src="{{asset('assets/images/right-b-arrow.png')}}" alt="mising icon"/></a>
                                        </div> --}}
                                    </div>

                                    <!-- Full height cards -->
                                    <div class="card tall-card">
                                        <img src="{{asset('assets/images/earings.jpg')}}" alt="Model 1">
                                        <button class="gift-btn"><i class="fas fa-gift"></i></button>
                                    </div>

                                    <div class="card tall-card">
                                        <img src="{{asset('assets/images/earings.jpg')}}" alt="Model 2">
                                        <button class="gift-btn"><i class="fas fa-gift"></i></button>
                                    </div>

                                    <div class="card tall-card">
                                        <img src="{{asset('assets/images/earings.jpg')}}" alt="Model 3">
                                        <button class="gift-btn"><i class="fas fa-gift"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
            </div>

                <div class="product-slider container">
                    <div class="product-card-catalog">
                        <div class="product-image">
                            <img src="{{asset('assets/images/be9af623f2068f7262d4b022188caa43b3d4f8c3.jpg')}}" alt="Product">
                            <span class="gift-tag">
                            <img src="{{asset('assets/images/bag.png')}}" alt="icon-missing"/> Mothers Day Gift
                            </span>
                        </div>
                        <div class="product-info">
                            <h4 class="product-name">Product name</h4>
                            <p class="product-variant">Variant</p>
                            <span class="product-price">$55</span>
                            <button class="add-to-cart">Add to Bundle</button>
                        </div>
                    </div>

                    <div class="product-card-catalog">
                        <div class="product-image">
                            <img src="{{asset('assets/images/ec6f85d0c5c133647cca00068fd77b532178ec32.jpg')}}" alt="Product">
                        </div>
                        <div class="product-info">
                            <h4 class="product-name">Product name</h4>
                            <p class="product-variant">Variant</p>
                            <span class="product-price">$55</span>
                            <button class="add-to-cart">Add to Bundle</button>
                        </div>
                    </div>

                    <div class="product-card-catalog">
                        <div class="product-image">
                            <img src="{{asset('assets/images/ear.jpg')}}" alt="Product">
                           <span class="gift-tag">
                            <img src="{{asset('assets/images/bag.png')}}" alt="icon-missing"/> Mothers Day Gift
                            </span>
                        </div>
                        <div class="product-info">
                            <h4 class="product-name">Product name</h4>
                            <p class="product-variant">Variant</p>
                            <span class="product-price">$55</span>
                            <button class="add-to-cart">Add to Bundle</button>
                        </div>
                    </div>

                    <div class="product-card-catalog">
                        <div class="product-image">
                            <img src="{{asset('assets/images/4863bef462845299a1f43c2cbb3d808ded4c062d.jpg')}}" alt="Product">
                           <span class="gift-tag">
                            <img src="{{asset('assets/images/bag.png')}}" alt="icon-missing"/> Mothers Day Gift
                            </span>
                        </div>
                        <div class="product-info">
                            <h4 class="product-name">Product name</h4>
                            <p class="product-variant">Variant</p>
                            <span class="product-price">$55</span>
                            <button class="add-to-cart">Add to Bundle</button>
                        </div>
                    </div>

                    <div class="product-card-catalog">
                        <div class="product-image">
                            <img src="{{asset('assets/images/earings.jpg')}}" alt="Product">
                        </div>
                        <div class="product-info">
                            <h4 class="product-name">Product name</h4>
                            <p class="product-variant">Variant</p>
                            <span class="product-price">$55</span>
                            <button class="add-to-cart">Add to Bundle</button>
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







        </div>
    </x-slot>
    <x-slot name="insertjavascript">
        <script>
            document.querySelectorAll('.custom-tabs li').forEach(tab => {
                tab.addEventListener('click', function() {
                // Remove active from all tabs
                document.querySelectorAll('.custom-tabs li').forEach(t => t.classList.remove('active'));
                // Remove active from all panes
                document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));

                // Activate the clicked tab
                this.classList.add('active');
                // Show the related pane
                document.getElementById(this.dataset.tab).classList.add('active');
                });
            });
            </script>
            <script>
                function toggleSection(el) {
                    const options = el.nextElementSibling;
                    const sign = el.querySelector("span");
                    if (options.style.display === "block") {
                        options.style.display = "none";
                        sign.textContent = "+";
                    } else {
                        options.style.display = "block";
                        sign.textContent = "–";
                    }
                }

                function clearAll() {
                    document.querySelectorAll('.filter-options input[type="checkbox"]').forEach(cb => cb.checked = false);
                }
            </script>

    </x-slot>
</x-layouts.user-default>
</html>
