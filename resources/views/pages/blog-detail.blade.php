<x-layouts.user-default>
    <x-slot name="insertstyle">
  <style>
.blog-detail-content img,
.blog-content-body img {
    max-width: 100%;
    height: auto;
    max-height: 600px;
    object-fit: contain;
    display: block;
    margin: 16px auto;
}

</style>
    </x-slot>
    <x-slot name="content">
        <div class="product-detail-main-wrapper">
            <div class="about-hero-section blog-detail-hearo">
                <h1>Welcome To Blogs</h1>
            </div>
<div class="container">
    <div class="blog-detal-main-wrapper">
        <div class="back-button">
            <img src="{{ asset('assets/images/slide-left.png') }}" alt="missing">
            <a href="{{ url('about-us') }}?tab=blogs">Back</a>
        </div>

        <div class="blog-detal-img">
            <img
                src="{{ $blog && $blog->image ? asset('assets/images/blogs/' . $blog->image) : asset('assets/images/diwali-2020.jpg') }}"
                alt="{{ $blog->title ?? 'missing image' }}">
        </div>

        <div class="blog-detail-content">
            <h1>{{ $blog->title }}</h1>
            <p>
                <small>
                    {{ $blog->created_at ? $blog->created_at->format('F j, Y') : '' }}
                    @if(!empty($blog->author)) | {{ $blog->author }} @endif
                </small>
            </p>

            <div class="blog-content-body">
                {!! $blog->content !!}
            </div>
        </div>
    </div>

    {{-- If you intentionally want a second block like your original markup, uncomment and use the same data or render additional sections --}}
    {{-- 
    <div class="blog-detail-main-wrapper">
        <div class="blog-detal-img">
            <img src="{{ $blog && $blog->image ? asset('assets/images/blogs/' . $blog->image) : asset('assets/images/diwali-2020.jpg') }}" alt="missing image">
        </div>
        <div class="blog-detail-content">
            <h1>{{ $blog->title }}</h1>
            <p><small>{{ $blog->created_at ? $blog->created_at->format('F j, Y') : '' }} | {{ $blog->author }}</small></p>
            <div class="blog-content-body">
                {!! $blog->content !!}
            </div>
        </div>
    </div>
    --}}

    <div class="back-button" style="margin-top:20px;">
        <a href="{{ url('about-us') }}?tab=blogs">Next</a>
        <img src="{{ asset('assets/images/slide-right.png') }}" alt="missing">
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


    </x-slot>
</x-layouts.user-default>

</html>
