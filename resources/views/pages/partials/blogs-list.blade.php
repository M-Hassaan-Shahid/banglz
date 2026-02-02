@php
    use Illuminate\Support\Str;

    // helper: build image URL from filename stored in DB
    function blog_image_url($image) {
        return $image ? asset('assets/images/blogs/' . $image) : asset('assets/images/default.png');
    }
@endphp

@if($blogs && $blogs->count() > 0)
    @foreach($blogs as $blog)
        <div class="card">
            <img src="{{ blog_image_url($blog->image) }}" alt="{{ $blog->title }}">
            <div class="card-content">
                <h4>{{ Str::limit($blog->title, 60) }}</h4>
                <p><small>{{ $blog->created_at ? $blog->created_at->format('F j, Y') : '' }} | {{ $blog->author }}</small></p>
                <p>{!! Str::limit(strip_tags($blog->short_description ?? $blog->content), 120) !!}</p>

                <div class="add-action-buttons read-more-btn">
                    <!-- Keep button markup so styling remains identical -->
                    <button type="button"
                            class="add-to-bundle"
                            data-url="{{ route('blog.show', $blog->slug ?? $blog->slug) }}">
                        Read More..
                    </button>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="no-blogs-found" style="padding:20px; text-align:center; width:100%;">
        <p>No blogs found.</p>
    </div>
@endif

