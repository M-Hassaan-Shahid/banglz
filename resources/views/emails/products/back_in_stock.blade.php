<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Back in Stock</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e5e5e5;
        }
        .header {
            background-color: #28a745;
            padding: 20px;
            text-align: center;
            color: #fff;
            font-size: 20px;
            font-weight: bold;
        }
        .content {
            padding: 30px;
            text-align: center;
        }
        .content img {
            max-width: 200px;
            border-radius: 6px;
        }
        .product-name {
            font-size: 22px;
            font-weight: bold;
            margin: 20px 0 10px;
        }
        .variation {
            font-size: 16px;
            color: #666;
            margin-bottom: 10px;
        }
        .price {
            font-size: 18px;
            font-weight: bold;
            color: #28a745;
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            padding: 12px 25px;
            background-color: #28a745;
            color: #fff !important;
            text-decoration: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
        }
        .footer {
            background: #f1f1f1;
            padding: 15px;
            font-size: 12px;
            text-align: center;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            🎉 Good News – Product Back in Stock!
        </div>

        <div class="content">
         @php
    $images = $product->images ?? [];
    $firstImage = $images[0] ?? 'default.png';
@endphp

<img src="{{ asset('assets/images/products/' . $firstImage) }}" alt="{{ $product->name }}">
            <div class="product-name">{{ $product->name }}</div>
            
            @if($variation)
                <div class="variation">Variation
                    Size : <strong>{{ $variation->size }}
                    Color : <strong>{{ $variation->color->name }}
                     </strong></div>
           
                @endif

            <div class="price">
                Price: {{ number_format($variation->price ?? $product->price, 2) }} {{ config('app.currency', 'PKR') }}
            </div>

            <a href="{{ route('product.detail', $product->slug) }}" class="btn">
                🛒 Shop Now
            </a>
        </div>

        <div class="footer">
            You’re receiving this email because you subscribed to get updates.<br>
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>
</html>
