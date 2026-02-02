<x-layouts.user-default>
    <x-slot name="insertstyle">
    </x-slot>
    <x-slot name="content">
        <div class="product-detail-main-wrapper">
        @php
    $meta = $pageData && $pageData->meta_data ? (is_array($pageData->meta_data) ? $pageData->meta_data : json_decode($pageData->meta_data, true)) : [];
    $hero = $meta['sections']['hero'] ?? [];
    $images = isset($hero['images']) ? (is_array($hero['images']) ? $hero['images'] : [])
             : ($pageData && $pageData->images ? (is_array($pageData->images) ? $pageData->images : (is_string($pageData->images) ? json_decode($pageData->images, true) : [])) : []);
    $heroImageFile = $images[0]['src'] ?? ($pageData->image ?? 'about-head.jpg');
    $heroImage = asset('assets/images/pages/' . $heroImageFile);
    $heroHeading = $hero['heading'] ?? ($pageData->heading ?? 'Welcome To Banglez');
@endphp

<div class="about-hero-section position-relative" style="height: 400px; overflow:hidden;">
    {{-- Background image --}}
    <img src="{{ $heroImage }}"
         class="w-100 h-100"
         style="object-fit: cover; position:absolute; top:0; left:0; z-index:1;">

    {{-- Gradient overlay --}}
    <div style="position:absolute; inset:0; background: linear-gradient(to right, rgba(255,255,255,1) 22%, rgba(255,255,255,0) 60%); z-index:2;"></div>

    {{-- Heading --}}
    <h1 class="position-absolute"
        style="top:50%; left:10%; transform: translateY(-50%); z-index:3; color:#a47764; font-size:3.5rem; font-weight:600;">
        {{ $heroHeading }}
    </h1>
</div>


            {{-- detail about us --}}
            <div class="detai-tabs-about">
                    <ul id="myTabs" class="custom-tabs">
                        <li class="{{ $activeTab === 'About-Us' ? 'active' : '' }}" data-tab="About-Us">About Us</li>
                        <li class="{{ $activeTab === 'Size-Guide' ? 'active' : '' }}" data-tab="Size-Guide">Size Guide</li>
                        <li  class="{{ $activeTab === 'blogs' ? 'active' : '' }}" data-tab="blogs">Blogs</li>

                    </ul>

                    <div class="tab-content">
                        <div class="tab-main tab-pane active" id="About-Us">
                            <h1>About Banglez</h1>
                            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sed veniam nulla, voluptatem aperiam beatae nobis!</p>
                            <div class="tab-image-section">
                                <div class="tab-left-images">
                                    <img src="{{asset('assets/images/11.png')}}" alt="missing image">
                                    <img src="{{asset('assets/images/10.png')}}" alt="missing image">
                                </div>
                                <div class="tab-right-images">
                                    <img src="{{asset('assets/images/9.png')}}" alt="missing image">
                                </div>
                            </div>
                        </div>
                        <div class="tab-main tab-pane " id="Size-Guide">
                            <h1>Bangle Size Guide</h1>
                            <p>Measure your hand or a well-fitting bangle.</p>

                            <div class="main-side-heding-tabs">
                                <div class="side-headings-tabs">
                                    <ul id="tab-side-menu">
                                        <li data-target="hand-size" class="active">Measure your Hand</li>
                                        <li data-target="bangle-size">Measure a well-fitting bangle</li>
                                    </ul>
                                </div>
                                <div class="side-content-tabs over-flow-content" id="hand-size" >
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content">
                                            <ol>
                                                <li>Grab a ruler. Don’t have one? Download and print
                                                    <a href="https://cdn.shopify.com/s/files/1/0647/6507/files/BanglezSizeGuide.pdf" target="_blank">HERE</a>
                                                </li>
                                                <li>Make a fist.</li>
                                                <li>Measure from the mid-point of your pinky knuckle to the mid-point of your index knuckle.</li>
                                            </ol>
                                        </div>
                                        <div class="side-inner-content-img">
                                            <img src="{{asset('assets/images/hand.webp')}}" alt="Stone Bangles Set">
                                        </div>
                                    </div>
                                    <div class="side-inner-table">
                                        <table class="about-us-size-table">
                                            <tbody>
                                                <tr>
                                                    <th>Inches</th>
                                                    <th>Centimetres</th>
                                                    <th>Bangle Size</th>
                                                </tr>
                                                <tr>
                                                    <td>1.625</td>
                                                    <td>4.13</td>
                                                    <td>1.0</td>
                                                </tr>
                                                <tr>
                                                    <td>1.75</td>
                                                    <td>4.45</td>
                                                    <td>1.12</td>
                                                </tr>
                                                <tr>
                                                    <td>1.825</td>
                                                    <td>4.65</td>
                                                    <td>1.14</td>
                                                </tr>
                                                <tr>
                                                    <td>2.0</td>
                                                    <td>5.08</td>
                                                    <td>2.0</td>
                                                </tr>
                                                <tr>
                                                    <td>2.12</td>
                                                    <td>5.40</td>
                                                    <td>2.2</td>
                                                </tr>
                                                <tr>
                                                    <td>2.25</td>
                                                    <td>5.72</td>
                                                    <td>2.4</td>
                                                </tr>
                                                <tr>
                                                    <td>2.375</td>
                                                    <td>6.03</td>
                                                    <td>2.6</td>
                                                </tr>
                                                <tr>
                                                    <td>2.50</td>
                                                    <td>6.35</td>
                                                    <td>2.8</td>
                                                </tr>
                                                <tr>
                                                    <td>2.625</td>
                                                    <td>6.67</td>
                                                    <td>2.10</td>
                                                </tr>
                                                <tr>
                                                    <td>2.75</td>
                                                    <td>6.99</td>
                                                    <td>2.12</td>
                                                </tr>
                                                </tbody>
                                        </table>

                                    </div>
                                </div>
                                <div class="side-content-tabs over-flow-content" id="bangle-size" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content">
                                            <ol>
                                                <li>Grab a ruler. Don’t have one? Download and print one
                                                    <a href="https://cdn.shopify.com/s/files/1/0647/6507/files/BanglezSizeGuide.pdf" target="_blank">HERE</a>
                                                </li>
                                                <li>Measure the inner diameter of your bangle.</li>
                                            </ol>
                                        </div>
                                        <div class="side-inner-content-img">
                                            <img src="{{asset('assets/images/bangle-size.webp')}}" alt="Stone Bangles Set">
                                        </div>
                                    </div>
                                    <div class="side-inner-table">
                                        <table class="about-us-size-table">
                                          <tbody>
                                            <tr>
                                            <th>Inches</th>
                                            <th>Centimetres</th>
                                            <th>Bangle Size</th>
                                            </tr>
                                            <tr>
                                            <td>1.625</td>
                                            <td>4.13</td>
                                            <td>1.0</td>
                                            </tr>
                                            <tr>
                                            <td>1.75</td>
                                            <td>4.45</td>
                                            <td>1.12</td>
                                            </tr>
                                            <tr>
                                            <td>1.825</td>
                                            <td>4.65</td>
                                            <td>1.14</td>
                                            </tr>
                                            <tr>
                                            <td>2.0</td>
                                            <td>5.08</td>
                                            <td>2.0</td>
                                            </tr>
                                            <tr>
                                            <td>2.12</td>
                                            <td>5.40</td>
                                            <td>2.2</td>
                                            </tr>
                                            <tr>
                                            <td>2.25</td>
                                            <td>5.72</td>
                                            <td>2.4</td>
                                            </tr>
                                            <tr>
                                            <td>2.375</td>
                                            <td>6.03</td>
                                            <td>2.6</td>
                                            </tr>
                                            <tr>
                                            <td>2.50</td>
                                            <td>6.35</td>
                                            <td>2.8</td>
                                            </tr>
                                            <tr>
                                            <td>2.625</td>
                                            <td>6.67</td>
                                            <td>2.10</td>
                                            </tr>
                                            <tr>
                                            <td>2.75</td>
                                            <td>6.99</td>
                                            <td>2.12</td>
                                            </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>



                            <div class="detail-video-section">
                                <h1>Need a more detailed explanation? <br>Watch this video:
                                </h1>
                                <video controls="controls" class="sg-media" poster="https://cdn.shopify.com/s/files/1/0647/6507/files/Bangle_Size_Guide.png?v=1705457950" __idm_id__="1155073">
                                    <source class="sg-media" type="video/mp4" src="https://cdn.shopify.com/videos/c/o/v/ef9a8fb9e8a54342a4f11136c8bd63cc.mov"></video>
                            </div>

                        </div>




                    <div class="tab-main tab-pane" id="blogs">
    <h1>Blogs</h1>
    <p>Discover Our Latest Posts</p>

    <div class="blogs-wrapper-sec">
        <div class="blogs-main-grid" id="blogsGrid">
            {{-- Cards will be injected here via AJAX --}}
            {{-- Optionally show initial loader or skeleton --}}
            <div class="loading-skeleton" style="width:100%; text-align:center; padding:20px;">
                <small>Click "Blogs" to load posts...</small>
            </div>
        </div>

        <div class="load-more-container mt-4" id="loadMoreContainer" style="text-align:center; margin-top:20px; display:none;">
            <button id="loadMoreBtn" data-next-page="" class="btn">Load More</button>
        </div>
    </div>
</div>



                    </div>
            </div>



                {{-- our mission --}}

                <div class="our-mission-section">
                    <div class="mission-left-section">
                        <div class="mission-left-detail">
                            <h1>OUR MISSION</h1>
                            <p>Since 2006, we have taken pride in designing unique pieces that reflect quality craftsmanship and cultural heritage. At Banglez we believe that jewelry is more than just an accessory - it’s a reflection of who we are, where we come from and what we value and we remain committed to preserving the rich history and artistry of South Asian jewelry while adding a modern and personal touch.</p>
                        </div>
                        {{-- <a href="{{ url('about-us') }}" class="shop-now">
                            Shop Now
                        </a> --}}
                    </div>
                    <div class="mission-right-section">
                        <img src="{{asset('assets/images/12.png')}}" alt="missing image">
                    </div>

                </div>

                {{--customization Buttons --}}
               <div class="Customize-section">
                    <div class="customize-sec-content">
                        <h1>Bundle your Look. Unlock Rewards</h1>
                        <p>Select pieces marked with the Complete Your Look tag to build your perfect set.
                            Add three eligible items and unlock exclusive perks, including free styling services and more.</p>
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
        <script>


        </script>
       <script>
document.addEventListener("DOMContentLoaded", function () {
  // Handle tab switching when clicked
  document.querySelectorAll('.custom-tabs li').forEach(tab => {
    tab.addEventListener('click', function() {
      activateTab(this.dataset.tab);
    });
  });

  // Function to activate a tab + pane
  function activateTab(tabName) {
    // Remove active from all tabs
    document.querySelectorAll('.custom-tabs li').forEach(t => t.classList.remove('active'));
    // Remove active from all panes
    document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));

    // Activate the correct tab
    const activeTab = document.querySelector(`.custom-tabs li[data-tab="${tabName}"]`);
    if (activeTab) activeTab.classList.add('active');

    // Show the related pane
    const activePane = document.getElementById(tabName);
    if (activePane) activePane.classList.add('active');
  }

  // 🔑 Check URL param for tab (e.g. /about-us?tab=Size-Guide)
  const urlParams = new URLSearchParams(window.location.search);
  const defaultTab = urlParams.get('tab');
  if (defaultTab) {
    activateTab(defaultTab);
  }
});
</script>
<script>
  // Get all tab items and content divs
  const tabItems = document.querySelectorAll("#tab-side-menu li");
  const tabContents = document.querySelectorAll(".side-content-tabs");

  // Loop through each tab item
  tabItems.forEach(item => {
    item.addEventListener("click", () => {
      const targetId = item.getAttribute("data-target");

      // Remove active class from all tabs
      tabItems.forEach(tab => tab.classList.remove("active"));

      // Hide all tab contents
      tabContents.forEach(content => {
        content.style.display = "none";
      });

      // Add active class to clicked tab
      item.classList.add("active");

      // Show the clicked one
      document.getElementById(targetId).style.display = "block";
    });
  });
</script>
<script>
$.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
(function(){
var blogsLoaded=false;var loadingBlogs=false;
function fetchBlogs(page=1,append=false){
if(loadingBlogs) return;
loadingBlogs=true;
var $loadBtn=$('#loadMoreBtn');var $grid=$('#blogsGrid');var $loadContainer=$('#loadMoreContainer');
if(!append){$grid.html('<div style="padding:20px;text-align:center;">Loading blogs…</div>');}else{$loadBtn.prop('disabled',true).text('Loading...');}
$.get("{{ route('blogs.fetch') }}",{page:page})
.done(function(res){
if(!append){$grid.html(res.html);}else{$grid.append(res.html);}
if(res.next_page){$loadContainer.show();$loadBtn.data('next-page',res.next_page);$loadBtn.prop('disabled',false).text('Load More');}else{$loadContainer.hide();$loadBtn.data('next-page','');}
})
.fail(function(){
if(!append){$grid.html('<div style="padding:20px;text-align:center;color:#d33;">Failed to load blogs.</div>');}else{$loadBtn.prop('disabled',false).text('Load More');alert('Failed to load more blogs. Please try again.');}
})
.always(function(){loadingBlogs=false;});
}
$(document).on('click','li[data-tab="blogs"]',function(e){e.preventDefault();if(!blogsLoaded){fetchBlogs(1,false);blogsLoaded=true;}});
$(document).on('click','#loadMoreBtn',function(e){e.preventDefault();var next=$(this).data('next-page');if(!next) return;fetchBlogs(next,true);});
$(document).on('click','.add-to-bundle',function(e){var url=$(this).data('url');if(url){window.location.href=url;}});
$(document).ready(function(){try{var params=new URLSearchParams(window.location.search);var tab=params.get('tab');if(tab&&tab.toLowerCase()==='blogs'){var $tabLi=$('li[data-tab="blogs"]');if($tabLi.length){$tabLi.trigger('click');}else{if(!blogsLoaded){fetchBlogs(1,false);blogsLoaded=true;}}}}catch(err){}});
})();
</script>

    </x-slot>
</x-layouts.user-default>

</html>
