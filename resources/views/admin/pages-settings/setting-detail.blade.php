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
    .page-image-main {
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
        <a href="{{ route('admin.page-setting') }}">
            <button class="backButton">Back to Page Settings</button>
        </a>

        <div class="row">
            <!-- Page Details -->
            <div class="col-md-7">
                <div class="detail-card">
                    <h4>{{ $page->heading ?? '-' }}</h4>
                    {{-- <p><strong>Sub Heading:</strong> {{ $page->sub_heading ?? '-' }}</p> --}}
                    <p><strong>Page Name:</strong> {{ $page->page_name ?? '-' }}</p>
                    <p><strong>Description:</strong></p>
                    <div>{!! nl2br(e($page->description ?? '-')) !!}</div>
                </div>
            </div>

            <!-- Image -->
            <div class="col-md-5 text-center">
                @php
                    $fallback = asset('images/no-image.png');
                    $mainImage = $page->image ? asset('assets/images/pages/' . $page->image) : $fallback;
                @endphp

                <img src="{{ $mainImage }}" class="page-image-main" alt="Page Image">
            </div>
        </div>
    </div>
</main>
@endsection

@section('admininsertjavascript')
<script>
    $('body').addClass('bg-clr');
    $('.sidenav li').removeClass('active');
    // Example: $('.sidenav li:nth-of-type(7)').addClass('active'); // adjust to highlight menu
</script>
@endsection
