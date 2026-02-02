@extends('components.layouts.admin-default')

<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">

@section('content')
@include('components.includes.admin.navbar')

<style>
    .backButton {
        background: #6cc2b6;
        width: 130px;
        height: 40px;
        margin-bottom: 20px;
        border: none;
        border-radius: 5px;
        color: white;
    }
    .product-image-thumb {
        width: 60px;
        height: 60px;
        object-fit: cover;
        margin: 5px;
        cursor: pointer;
        border: 2px solid transparent;
        border-radius: 5px;
    }
    .product-image-thumb.active {
        border-color: #6cc2b6;
    }
    .product-image-main {
        width: 100%;
        max-height: 400px;
        object-fit: contain;
        border-radius: 5px;
        margin-bottom: 10px;
    }
    .detail-card {
        background: #fff;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    .detail-card h5 {
        font-weight: bold;
        margin-bottom: 10px;
    }
    .detail-card p {
        margin-bottom: 5px;
    }
    .attributes p {
        margin: 0;
    }

    /* Styling for rendered rich HTML content */
    .rich-content {
        border-radius: 4px;
        border: 1px solid #e9ecef;
        padding: 12px;
        min-height: 60px;
        background: #fafafa;
    }

    /* Make images inside rich content responsive */
    .rich-content img {
        max-width: 100%;
        height: auto;
    }
</style>

<main class="content-wrapper">
    <div class="container mt-4">
        <a href="{{ route('admin.products') }}"><button class="backButton">Back to Products</button></a>

        {{-- Top Row: Details & Images --}}
        <div class="row">
            {{-- Product Details --}}
            <div class="col-md-7">
                <div class="detail-card">
                    <h5>Product Details</h5>
                    <p><strong>Name:</strong> {{ $product->name ?? '-' }}</p>
                    @if(isset($product->price))<p><strong>Price:</strong> ${{ $product->price }}</p>@endif
                    @if(isset($product->quantity))<p><strong>Quantity:</strong> {{ $product->quantity }}</p>@endif
                    @if(isset($product->compare_price))<p><strong>Compare Price:</strong> {{ $product->compare_price }}</p>@endif
                    <p><strong>Category:</strong> {{ $product->category->name ?? '-' }}</p>
                    <p><strong>Featured:</strong> {{ $product->is_featured ? 'Yes' : 'No' }}</p>

                    @if($product->collection && $product->collection->isNotEmpty())
                        <p><strong>Collections:</strong>
                            @foreach($product->collection as $collection)
                                <span class="badge bg-primary me-1">{{ $collection->name }}</span>
                            @endforeach
                        </p>
                    @endif
                </div>

                {{-- Attributes (from tags with 'type' column) --}}
                @php
                    $tagsByType = collect($product->tags ?? [])->groupBy('type');
                @endphp

                @if($tagsByType->isNotEmpty())
                <div class="detail-card attributes">
                    <h5>Attributes</h5>

                    @if($tagsByType->has('material') && $tagsByType['material']->isNotEmpty())
                        <p><strong>Materials:</strong>
                            {{ $tagsByType['material']->pluck('name')->implode(', ') }}
                        </p>
                    @endif

                    @if($tagsByType->has('style') && $tagsByType['style']->isNotEmpty())
                        <p><strong>Styles:</strong>
                            {{ $tagsByType['style']->pluck('name')->implode(', ') }}
                        </p>
                    @endif

                    @foreach($tagsByType as $type => $tags)
                        @if(!in_array($type, ['material','style']))
                            <p><strong>{{ ucfirst($type) }}:</strong> {{ $tags->pluck('name')->implode(', ') }}</p>
                        @endif
                    @endforeach
                </div>
                @endif

                {{-- Description & other rendered fields (read-only) --}}
                <div class="detail-card">
                    <h5>Description & Details</h5>

                    <div class="mb-3">
                        <label class="d-block"><strong>Description</strong></label>
                        <div class="rich-content">
                            {!! $product->description ?? '-' !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="d-block"><strong>Care</strong></label>
                            <div class="rich-content">
                                {!! $product->care ?? '-' !!}
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="d-block"><strong>Sustainability</strong></label>
                            <div class="rich-content">
                                {!! $product->sustainability ?? '-' !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="d-block"><strong>Shipping</strong></label>
                            <div class="rich-content">
                                {!! $product->shipping ?? '-' !!}
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="d-block"><strong>Returns</strong></label>
                            <div class="rich-content">
                                {!! $product->returns ?? '-' !!}
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Images Slider --}}
            <div class="col-md-5 text-center">
                @php
                    $images = is_array($product->images) ? $product->images : (json_decode($product->images ?? '[]', true) ?: []);
                    $mainSrc = !empty($images) ? asset('assets/images/products/' . $images[0]) : asset('images/no-image.png');
                @endphp

                <img id="mainProductImage" src="{{ $mainSrc }}" class="product-image-main" alt="Main Image">

                <div class="d-flex justify-content-center flex-wrap">
                    @foreach($images as $key => $img)
                        <img src="{{ asset('assets/images/products/' . $img) }}" class="product-image-thumb {{ $key == 0 ? 'active' : '' }}" onclick="changeMainImage(this)">
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Bottom Row: Variations --}}
        @if(!empty($product->variations) && count($product->variations) > 0)
        <div class="row mt-4">
            <div class="col-12">
                <div class="detail-card">
                    <h5>Variations</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Size</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Compare Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($product->variations as $variation)
                            <tr>
                                <td>{{ $variation['size'] ?? '-' }}</td>
                                <td>{{ $variation['quantity'] ?? '-' }}</td>
                                <td>{{ $variation['price'] ?? '-' }}</td>
                                <td>{{ $variation['compare_price'] ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</main>

@endsection

@section('admininsertjavascript')
<script>
    $('body').addClass('bg-clr');
    $('.sidenav li:nth-of-type(2)').addClass('active');

    function changeMainImage(el) {
        document.getElementById('mainProductImage').src = el.src;
        document.querySelectorAll('.product-image-thumb').forEach(img => img.classList.remove('active'));
        el.classList.add('active');
    }
</script>
@endsection
