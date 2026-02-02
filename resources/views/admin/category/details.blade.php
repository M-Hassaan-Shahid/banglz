@extends('components.layouts.admin-default')

@section('content')
@include('components.includes.admin.navbar')

<style>
    .backButton {
        background: #6cc2b6;
        width: 160px;
        height: 40px;
        margin-bottom: 20px;
        border: none;
        border-radius: 5px;
        color: white;
    }
    .collection-image-thumb {
        width: 60px;
        height: 60px;
        object-fit: cover;
        margin: 5px;
        cursor: pointer;
        border: 2px solid transparent;
        border-radius: 5px;
    }
    .collection-image-thumb.active {
        border-color: #6cc2b6;
    }
    .collection-image-main {
        width: 100%;
        max-height: 400px;
        object-fit: contain;
        border-radius: 5px;
        margin-bottom: 10px;
        background: #fff;
    }
    .detail-card {
        background: #fff;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.06);
    }
</style>

<main class="content-wrapper">
    <div class="container mt-4">
        <a href="{{ route('admin.category') }}"><button class="backButton">Back to Categories</button></a>

        <div class="row">
            <div class="col-md-7">
                <div class="detail-card">
                    <h4>{{ $category->name ?? '-' }}</h4>
                     <p><strong>Parent Category:</strong> {{ $category->parent_name ?? '-' }}</p>
                    <p><strong>Slug:</strong> {{ $category->slug ?? '-' }}</p>
                    <p><strong>Status:</strong>
                        @if($category->status)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </p>
                    <p><strong>Top Listed:</strong>
                        @if($category->top_listed)
                            <span class="badge bg-success">Yes</span>
                        @else
                            <span class="badge bg-danger">No</span>
                        @endif
                    </p>
                    <p><strong>Is Featured:</strong>
                        @if($category->is_featured)
                            <span class="badge bg-success">Yes</span>
                        @else
                            <span class="badge bg-danger">No</span>
                        @endif
                    </p>
                    <p><strong>Description:</strong></p>
                    <div>{!! nl2br(e($category->description ?? '-')) !!}</div>

                    <hr>

                   
                </div>
            </div>

            <div class="col-md-5 text-center">
                @php
                    // fallback image path
                    $fallback = asset('images/no-image.png');
                    $mainImage = count($images) ? asset('assets/images/categories/' . $images[0]) : $fallback;
                @endphp

                <img id="mainCollectionImage" src="{{ $mainImage }}" class="collection-image-main" alt="Main Image">

                <div class="d-flex justify-content-center flex-wrap">
                    @if(count($images))
                        @foreach($images as $key => $img)
                            <img src="{{ asset('assets/images/categories/' . $img) }}"
                                 class="collection-image-thumb {{ $key == 0 ? 'active' : '' }}"
                                 onclick="changeMainImage(this)">
                        @endforeach
                    @else
                        <img src="{{ $fallback }}" class="collection-image-thumb active" style="width:120px;height:120px;">
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('admininsertjavascript')
<script>
    $('body').addClass('bg-clr');
    // highlight correct menu item if needed
    $('.sidenav li').removeClass('active');
    // example: $('.sidenav li:nth-of-type(4)').addClass('active');

    function changeMainImage(el) {
        document.getElementById('mainCollectionImage').src = el.src;
        document.querySelectorAll('.collection-image-thumb').forEach(img => img.classList.remove('active'));
        el.classList.add('active');
    }
</script>
@endsection
