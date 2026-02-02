<x-layouts.user-default>
    <x-slot name="insertstyle">
        <style>
            .search-results-header {
                padding: 40px 0 20px;
                text-align: center;
            }
            .search-results-header h1 {
                font-size: 2rem;
                color: #333;
                margin-bottom: 10px;
            }
            .search-results-header p {
                color: #666;
                font-size: 1.1rem;
            }
            .no-results {
                text-align: center;
                padding: 60px 20px;
            }
            .no-results h2 {
                font-size: 1.5rem;
                color: #666;
                margin-bottom: 20px;
            }
            .no-results p {
                color: #999;
                margin-bottom: 30px;
            }
            .back-home-btn {
                display: inline-block;
                padding: 12px 30px;
                background: #a47764;
                color: white;
                text-decoration: none;
                border-radius: 5px;
                transition: background 0.3s;
            }
            .back-home-btn:hover {
                background: #8d6552;
                color: white;
            }
        </style>
    </x-slot>

    <x-slot name="content">
        <div class="product-detail-main-wrapper">
            <div class="container">
                <div class="search-results-header">
                    <h1>Search Results for "{{ $query }}"</h1>
                    <p>Found {{ $products->total() }} {{ Str::plural('product', $products->total()) }}</p>
                </div>

                @if($products->count() > 0)
                    <div class="row">
                        @foreach($products as $product)
                            <div class="col-6 col-md-4 col-lg-3 mb-4">
                                <div class="product-card">
                                    <a href="{{ route('product.detail', $product->slug) }}">
                                        <div class="product-image">
                                            @php
                                                $firstImage = $product->images[0] ?? 'default.jpg';
                                            @endphp
                                            <img src="{{ asset('assets/images/products/' . $firstImage) }}" 
                                                 alt="{{ $product->name }}"
                                                 style="width: 100%; height: 300px; object-fit: cover;">
                                        </div>
                                        <div class="product-info" style="padding: 15px;">
                                            <h4 class="product-name" style="font-size: 1rem; margin-bottom: 5px;">
                                                {{ $product->name }}
                                            </h4>
                                            @if($product->category)
                                                <p class="product-category" style="color: #999; font-size: 0.9rem; margin-bottom: 10px;">
                                                    {{ $product->category->name }}
                                                </p>
                                            @endif
                                            <div class="product-price" style="font-weight: bold; color: #a47764;">
                                                @if(Auth::check() && $product->member_price)
                                                    <span style="color: #a47764;">${{ number_format($product->member_price, 2) }}</span>
                                                    @if($product->price)
                                                        <span style="text-decoration: line-through; color: #999; margin-left: 5px; font-size: 0.9rem;">
                                                            ${{ number_format($product->price, 2) }}
                                                        </span>
                                                    @endif
                                                @elseif($product->compare_price && $product->compare_price > $product->price)
                                                    <span style="color: #a47764;">${{ number_format($product->price, 2) }}</span>
                                                    <span style="text-decoration: line-through; color: #999; margin-left: 5px; font-size: 0.9rem;">
                                                        ${{ number_format($product->compare_price, 2) }}
                                                    </span>
                                                @else
                                                    <span style="color: #a47764;">${{ number_format($product->price, 2) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="pagination-wrapper" style="margin-top: 40px; text-align: center;">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="no-results">
                        <h2>No products found</h2>
                        <p>We couldn't find any products matching "{{ $query }}"</p>
                        <p>Try searching with different keywords or browse our categories</p>
                        <a href="{{ route('home') }}" class="back-home-btn">Back to Home</a>
                    </div>
                @endif
            </div>
        </div>
    </x-slot>

    <x-slot name="insertjavascript">
    </x-slot>
</x-layouts.user-default>
