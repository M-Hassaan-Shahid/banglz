@extends('components.layouts.admin-default')

@section('content')
@include('components.includes.admin.navbar')

<style>
    /* --- Timeline Section --- */
.timeline-body {
    background: #fff;
}

.timeline-input textarea {
    border-radius: 8px;
    resize: none;
}

.timeline-list {
    border-left: 2px solid #e5e7eb;
    margin-left: 1rem;
    padding-left: 1rem;
}

.timeline-item {
    position: relative;
    margin-bottom: 1.5rem;
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-dot {
    position: absolute;
    left: -1.3rem;
    top: 0.35rem;
    width: 10px;
    height: 10px;
    border-radius: 50%;
}

.timeline-content p {
    margin-bottom: 0.25rem;
}

.timeline-content small {
    font-size: 12px;
}

    /* --- Shopify-Like Clean Layout + tweaks to match screenshot --- */
    body {
        background-color: #f4f6f8;
    }

    .content-wrapper {
        padding: 18px 0;
    }

    .order-top {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .order-top-left {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .order-meta-line {
        color: #6c757d;
        font-size: 0.95rem;
        margin-top: 6px;
    }

    .order-container {
    display: flex;
    gap: 1.5rem;
    align-items: stretch; /* <-- stretch children to same height */
}

/* keep main flexible */
.order-main {
    flex: 1 1 auto;
    min-width: 520px; /* allow main to shrink a bit on small screens */
}

/* make sidebar a bit narrower and a vertical flex column */
.order-sidebar {
    flex: 0 0 260px;   /* fixed-ish width (smaller than before) */
    max-width: 260px;
    min-width: 200px;
    display: flex;
    flex-direction: column;
}
.order-sidebar .info-block {
    margin-bottom: 12px;
}

/* flexible spacer so sidebar content fills height and avoids empty space at bottom */
.order-sidebar::after {
    content: "";
    display: block;
    flex: 1 1 auto;
}
    .card {
        border: 0;
        border-radius: 15px;
        box-shadow: 0 1px 6px rgba(16, 24, 40, 0.06);
        background: #fff;
    }

    .card-header {
        background: #fff;
        border-bottom: 1px solid #efefef;
        padding: 0.75rem 1rem;
        font-weight: 600;
    }

    .card-body {
        padding: 1rem;
    }

    /* Badges */
    .badge-unfulfilled {
        background-color: #fff3cd;
        color: #856404;
        border: 1px solid rgba(0, 0, 0, 0.04);
    }

    .badge-fulfilled {
        background-color: #d1e7dd;
        color: #0f5132;
        border: 1px solid rgba(0, 0, 0, 0.04);
    }

    .badge-paid {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid rgba(0, 0, 0, 0.04);
    }

    .badge-unpaid {
        background-color: #e9ecef;
        color: #495057;
        border: 1px solid rgba(0, 0, 0, 0.04);
    }

    /* Main fulfillment header inside left card */
    .fulfillment-header {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
        justify-content: space-between;
        padding: 12px;
        border: 1px solid #f0f0f0;
        border-radius: 8px;
        background: #fff;
        margin-bottom: 12px;
    }

    .fulfillment-left {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .shipping-method {
        color: #6c757d;
        background: transparent;
        font-size: 0.95rem;
        display: inline-flex;
        align-items: center;
    }

    .shipping-method svg {
        width: 14px;
        height: 14px;
        margin-right: 6px;
        color: #6c757d;
    }

    /* Horizontal Product Rows */
    .product-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        border: 1px solid #f0f0f0;
        border-radius: 8px;
        margin-bottom: 8px;
        background: #fff;
    }

    .product-thumb {
        width: 64px;
        height: 64px;
        border-radius: 8px;
        border: 1px solid #ececec;
        object-fit: contain;
        background: #fff;
    }

    .product-main {
        flex: 1 1 auto;
    }

    .product-title {
        font-weight: 600;
        margin: 0;
        font-size: 14px;
        display: flex;
        gap: 8px;
        align-items: center;
        flex-wrap: wrap;
    }

    .product-variant {
        font-size: 13px;
        color: #6c757d;
        margin-top: 4px;
        display: block;
    }

    .product-sku {
        font-size: 12px;
        color: #9098a0;
        margin-top: 4px;
    }

    .product-price-col {
        text-align: right;
        min-width: 160px;
    }

    .product-price-col .line {
        font-size: 14px;
        color: #6c757d;
    }

    .product-price-col .total {
        font-weight: 600;
        margin-top: 6px;
        display: block;
    }

    .qty-pill {
        display: inline-block;
        min-width: 36px;
        text-align: center;
        border-radius: 16px;
        padding: 4px 8px;
        background: #f1f3f5;
        color: #495057;
        font-weight: 600;
        font-size: 13px;
        margin-left: 6px;
    }

    /* Buttons */
    .order-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        margin-top: 12px;
    }

    .btn-fulfill {
        background: #fff3cd;
        color: #856404;
        border: 1px solid rgba(0, 0, 0, 0.06);
    }

    .btn-fulfill:hover {
        filter: brightness(0.98);
    }

    .btn-shipping {
        background: #111827;
        color: #fff;
        border: 0;
    }

    .btn-disabled {
        opacity: 0.6;
        pointer-events: none;
    }

    /* Amount card */
    .amount-card {
        border-radius: 8px;
        border: 1px solid #efefef;
        padding: 12px;
        background: #fff;
        margin-top: 0;
    }

    .amount-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px dashed #f1f1f1;
        font-size: 14px;
    }

    .amount-row:last-child {
        border-bottom: 0;
    }

    .amount-row .label {
        color: #6c757d;
    }

    .amount-row .value {
        font-weight: 600;
    }

    .amount-card .heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
    }

    .amount-card .small-muted {
        color: #6c757d;
        font-size: 13px;
    }

    /* Order summary */
    .order-summary {
        border-top: 1px solid #efefef;
        margin-top: 12px;
        padding-top: 12px;
    }

    /* Right column small cards */
    .info-block+.info-block {
        margin-top: 12px;
    }

    /* responsive tweaks */
    @media (max-width: 992px) {
        .order-main {
            min-width: 100%;
        }

        .order-sidebar {
            min-width: 100%;
        }
    }
</style>

<main class="content-wrapper">
    <div class="container-fluid">

        {{-- Top header: Order #, payment badge, fulfillment badge --}}
        <div class="order-top">
            <div class="order-top-left">
                <h4 class="mb-0">#{{ $order->order_id }}</h4>

                {{-- Payment status badge logic (try multiple common keys) --}}
                @php
                $paymentStatus = $order->payment_status ?? ($order->is_paid ?? null);
                $isPaid = false;
                if (is_string($paymentStatus)) {
                $isPaid = strtolower($paymentStatus) === 'paid' || strtolower($paymentStatus) === 'completed' || strtolower($paymentStatus) === 'true';
                } elseif (is_bool($paymentStatus)) {
                $isPaid = $paymentStatus === true;
                } elseif (is_int($paymentStatus)) {
                $isPaid = $paymentStatus === 1;
                }
                $fulfillmentBadgeClass = 'badge-unfulfilled';
                $fulfillmentText = ucfirst($order->status ?? 'pending');

                if (($order->status ?? '') === 'pending') {
                $fulfillmentBadgeClass = 'badge-unfulfilled';
                $fulfillmentText = 'Unfulfilled';
                } elseif (($order->status ?? '') === 'completed') {
                $fulfillmentBadgeClass = 'badge-fulfilled';
                $fulfillmentText = 'Fulfilled';
                } else {
                // other states keep neutral
                $fulfillmentBadgeClass = 'badge-unpaid';
                $fulfillmentText = ucfirst($order->status ?? 'Unknown');
                }
                @endphp

                @if($isPaid)
                <span class="badge badge-paid ms-2">Paid</span>
                @else
                <span class="badge badge-unpaid ms-2">Unpaid</span>
                @endif

                <span class="badge {{ $fulfillmentBadgeClass }} ms-2">{{ $fulfillmentText }}</span>
            </div>

            {{-- Right side top actions placeholder (we removed refund/edit/print per instruction) --}}
            <div class="order-top-right text-end">
                {{-- optional future controls --}}
            </div>
        </div>

        {{-- Order meta line: date and source --}}
        <div class="order-meta-line mb-3">
            @php
            // human readable date
            $orderDate = optional($order->created_at)->format('F j, Y \a\t g:i a') ?? '';
            // order source / channel fallback
            $orderSource = $order->source ?? $order->channel ?? 'Online Store';
            @endphp
            {{ $orderDate }} @if($orderDate) from @endif {{ $orderSource }}
        </div>

        <div class="order-container">

            {{-- LEFT: Main card with fulfillment header, shipping method, products --}}
            <div class="order-main">
                <div class="card mb-4">
                    <div class="card-header"></div>
                    <div class="card-body">

                        {{-- Fulfillment header --}}
                        @php
                        $productsCount = 0;
                        if (!empty($productsMetaData['Products'])) {
                        $productsCount += count($productsMetaData['Products']);
                        }
                        if (!empty($productsMetaData['Bundle'])) {
                        $productsCount += count($productsMetaData['Bundle']);
                        }
                        $shippingTitle = $order->shipping_title ?? $order->shipping_method ?? $order->shipping_service ?? ($order->shipping_name ?? 'Banglez Online Shipping');
                        @endphp

                        <div class="fulfillment-header">
                            <div class="fulfillment-left">
                                <span class="badge {{ $fulfillmentBadgeClass }}">{{ $fulfillmentText }} ({{ $productsCount }})</span>

                                <span class="shipping-method">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                                        <path d="M8 0a5 5 0 0 0-5 5c0 3.75 5 11 5 11s5-7.25 5-11a5 5 0 0 0-5-5zm0 7.5A2.5 2.5 0 1 1 8 2.5a2.5 2.5 0 0 1 0 5z" />
                                    </svg>
                                    {{ $shippingTitle }}
                                </span>
                            </div>
                            <div class="text-end"></div>
                        </div>

                        {{-- Shipping method (one-line) --}}
                        <div class="mb-3">
                            <i class="bi bi-truck" aria-hidden="true"></i>
                            <span class="ms-2 text-muted">{{ $order->shipping_description ?? ($order->shipping_title ?? 'Free Standard Shipping') }}</span>
                        </div>

                       {{-- Product list: single products --}}
@if(!empty($productsMetaData['Products']))
    @foreach($productsMetaData['Products'] as $item)
        @php
            $product = $item['product'] ?? [];
            $imageFile = $product['images'][0] ?? 'default.jpg';
            $image = asset('assets/images/products/' . $imageFile);

            // Variation fallback logic
            $variation = $item['variation'] ?? null;
            $size = $variation['size'] ?? $product['size'] ?? null;
            $colorId = $variation['color_id'] ?? $product['color_id'] ?? null;

            // Resolve color model
            $colorName = null;
            $colorHex = null;
            if (!empty($colorId)) {
                try {
                    $colorModel = \App\Models\ProductColor::find($colorId);
                    if ($colorModel) {
                        $colorName = $colorModel->name;
                        $colorHex = $colorModel->hex_code;
                    }
                } catch (\Throwable $e) {
                    // silent
                }
            }

            // Build variant text
            $variantParts = [];
            if (!empty($size)) $variantParts[] = $size;
            if (!empty($colorName)) $variantParts[] = $colorName;
            $variantText = !empty($variantParts) ? implode(' / ', $variantParts) : ($item['variant_name'] ?? $item['variant'] ?? '');

            $sku = $item['sku'] ?? $product['sku'] ?? ($item['product_sku'] ?? '');
            $qty = $item['qty'] ?? ($item['quantity'] ?? 1);
            $price = $item['final_price'] ?? ($item['price'] ?? 0);
            $lineTotal = $item['line_total'] ?? ($qty * $price);
        @endphp

        <div class="product-row">
            <img src="{{ $image }}" alt="thumb" class="product-thumb">

            <div class="product-main">
                <p class="product-title">
                    {{ $product['name'] ?? 'Product' }}
                </p>

                @if(!empty($variantText))
                    <span class="product-variant">
                        {{-- color dot if hex available --}}
                        @if(!empty($colorHex))
                            <span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:{{ $colorHex }};margin-right:6px;vertical-align:middle; border:1px solid rgba(0,0,0,0.06)"></span>
                        @endif
                        {{ $variantText }}
                    </span>
                @endif

                @if(!empty($sku))
                    <div class="product-sku">SKU: {{ $sku }}</div>
                @endif
            </div>

            <div class="product-price-col">
                <div class="line">${{ number_format((float)$price, 2) }} × {{ $qty }}</div>
                <div class="total">${{ number_format((float)$lineTotal, 2) }}</div>
            </div>
        </div>
    @endforeach
@endif


                       {{-- Bundles (keeps dropdown) --}}
@if(!empty($productsMetaData['Bundle']))
    <h6 class="fw-bold mt-3 mb-2">Bundles</h6>
    @foreach($productsMetaData['Bundle'] as $bundle)
        @php
            $firstBundleProduct = $bundle['bundle']['products'][0] ?? null;
            $firstProduct = $firstBundleProduct['product'] ?? [];
            $firstImageFile = $firstProduct['images'][0] ?? 'default.jpg';
            $firstImage = asset('assets/images/products/' . $firstImageFile);
            $firstQty = $firstBundleProduct['qty'] ?? 1;
            $firstPrice = $firstBundleProduct['price'] ?? 0;
            $bundleMeta = $bundle['bundle'] ?? [];
        @endphp

        <div class="product-row">
            <img id="bundleImage{{ $loop->index }}" src="{{ $firstImage }}" alt="bundle" class="product-thumb">

            <div class="product-main">

                <select class="form-select form-select-sm bundleProductSelect" data-index="{{ $loop->index }}" style="max-width:320px;">
                    @foreach($bundleMeta['products'] as $i => $bundleProduct)
                        @php
                            $bpProd = $bundleProduct['product'] ?? [];
                            $bpVar = $bundleProduct['variation'] ?? null;
                            $b_size = $bpVar['size'] ?? $bpProd['size'] ?? null;
                            $b_colorId = $bpVar['color_id'] ?? $bpProd['color_id'] ?? null;

                            $b_colorName = null;
                            $b_colorHex = null;
                            if (!empty($b_colorId)) {
                                try {
                                    $bColorModel = \App\Models\ProductColor::find($b_colorId);
                                    if ($bColorModel) {
                                        $b_colorName = $bColorModel->name;
                                        $b_colorHex = $bColorModel->hex_code;
                                    }
                                } catch (\Throwable $e) {
                                    // silent
                                }
                            }

                            $b_variant_parts = [];
                            if (!empty($b_size)) $b_variant_parts[] = $b_size;
                            if (!empty($b_colorName)) $b_variant_parts[] = $b_colorName;
                            $b_variant_text = !empty($b_variant_parts) ? implode(' / ', $b_variant_parts) : '';
                        @endphp

                        <option value="{{ $i }}"
                                data-image="{{ asset('assets/images/products/' . ($bpProd['images'][0] ?? 'default.jpg')) }}"
                                data-qty="{{ $bundleProduct['qty'] ?? 1 }}"
                                data-price="{{ $bundleProduct['price'] ?? 0 }}"
                                data-pre="{{ isset($bpProd['is_pre_order']) ? (int)$bpProd['is_pre_order'] : 0 }}"
                                data-size="{{ $b_size }}"
                                data-color-name="{{ $b_colorName }}"
                                data-color-hex="{{ $b_colorHex }}">
                            {{ $bpProd['name'] ?? 'Product' }}@if(!empty($b_variant_text)) — {{ $b_variant_text }}@endif
                        </option>
                    @endforeach
                </select>

                {{-- variant display for the selected product in this bundle --}}
                <div class="product-variant mt-1" id="bundleVariant{{ $loop->index }}">
                    {{-- initial text will be set by JS on change --}}
                </div>
            </div>

            <div class="product-price-col">
                <div class="line">${{ number_format((float)$firstPrice, 2) }} × {{ $firstQty }}</div>
                <div class="total">${{ number_format((float)($bundle['line_total'] ?? ($firstPrice * $firstQty)), 2) }}</div>
            </div>
        </div>
    @endforeach
@endif

<!-- {Bangle Box } -->
 @if(!empty($bangletMetaData))
    <h6 class="fw-bold mt-3 mb-2">Bangle Boxes</h6>

    @foreach($bangletMetaData as $i => $bItem)
        @php
            // each $bItem structure: cart_id, qty, final_price, line_total, bangle_box, bangle_size, colors[]
            $bangle = $bItem['bangle_box'] ?? [];
            $bangleSize = $bItem['bangle_size'] ?? [];
            $colors = $bItem['colors'] ?? [];

            // first color image and name (fallback)
            $firstColor = $colors[0]['color'] ?? $colors[0] ?? null;
            $firstImageFile = $firstColor['image'] ?? 'default.jpg';
            $firstImage = asset('assets/images/bangle-box/' . $firstImageFile);
            $firstColorName = $firstColor['color_name'] ?? $firstColor['name'] ?? '';

            $qty = $bItem['qty'] ?? 1;
            $price = $bItem['final_price'] ?? $bItem['price'] ?? 0;
            $lineTotal = $bItem['line_total'] ?? ($qty * $price);
        @endphp

        <div class="product-row">
            {{-- color image shown like product thumb --}}
            <img id="bangleImage{{ $loop->index }}" src="{{ $firstImage }}" alt="bangle" class="product-thumb">

            <div class="product-main">
                {{-- Show selected color name where bundle shows product name --}}
                <span class="product-title">
                    {{ $firstColorName ?: ('Bangle Box - Size ' . ($bangle['size'] ?? 'N/A')) }}
                </span>

                {{-- Dropdown: same classes & data attributes as bundle's select so CSS + JS behave the same --}}
                <select class="form-select form-select-sm bangleProductSelect" data-index="{{ $loop->index }}" style="max-width:320px;">
                    @foreach($colors as $ci => $c)
                        @php
                            // colors array may be nested: color => [...]
                            $color = $c['color'] ?? $c;
                            $c_name = $color['color_name'] ?? $color['name'] ?? "Color {$ci}";
                            $c_image = $color['image'] ?? 'default.jpg';
                            $c_image_url = asset('assets/images/bangle-box/' . $c_image);
                        @endphp
                        <option value="{{ $ci }}"
                                data-image="{{ $c_image_url }}"
                                data-qty="{{ $qty }}"
                                data-price="{{ $price }}"
                                data-size="{{ $bangle['size'] ?? '' }}"
                                 data-bangle-size="{{ $bangleSize['size'] ?? '' }}"
                                data-color-name="{{ $c_name }}">
                            {{ $c_name }}
                        </option>
                    @endforeach
                </select>

                {{-- variant area: we will fill/update with JS (keeps parity with bundles) --}}
                <div class="product-variant mt-1" id="bangleVariant{{ $loop->index }}">
                    {{-- initial display: size (above qty) --}}
                    <strong>Box Size:</strong> {{ $bangle['size'] ?? '-' }} Color
                    <strong>Bangle Size:</strong> {{ $bangleSize['size'] ?? '-' }}
                </div>
            </div>

            <div class="product-price-col">
                <div class="line">${{ number_format((float)$price, 2) }} × {{ $qty }}</div>
                <div class="total">${{ number_format((float)$lineTotal, 2) }}</div>
            </div>
        </div>
    @endforeach
@endif

                        {{-- Action Buttons (visual only) --}}
                        <div class="order-actions">
                            @php
                            $isFulfilled = (($order->status ?? '') === 'completed');
                            @endphp

                            <!-- <a href="#" class="btn btn-sm btn-fulfill {{ $isFulfilled ? 'btn-disabled' : '' }}">Fulfill items</a> -->
                            @if($order->status == 'pending')
                            <a href="{{ route('admin.create-label', $order->id) }}" class="btn btn-sm btn-shipping {{ $isFulfilled ? 'btn-disabled' : '' }}">Create shipping label</a>
                           @endif
                              
                              </div>

                        {{-- Status update form kept for admin usage --}}
                        <form id="updateStatusForm" class="mt-3 d-flex align-items-center gap-2">
                            @csrf
                            <label for="status" class="fw-bold mb-0">Status:</label>
                            <select name="status" id="status" class="form-select form-select-sm w-auto">
                                @foreach([
                                'pending' => 'Pending',
                                'processing' => 'Processing',
                                'on_the_way' => 'On the Way',
                                'delivered' => 'Delivered',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                                'returned' => 'Returned',
                                ] as $value => $label)
                                <option value="{{ $value }}" {{ ($order->status === $value) ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                        </form>

                    </div>
                </div>

                {{-- AMOUNT DETAILS CARD moved OUTSIDE the main products card (own card) --}}
                @php
                // Ensure helper variables exist
                $productsCount = $productsCount ?? (
                (!empty($productsMetaData['Products']) ? count($productsMetaData['Products']) : 0)
                + (!empty($productsMetaData['Bundle']) ? count($productsMetaData['Bundle']) : 0)
                );
                $isPaid = $isPaid ?? ((
                is_string($order->payment_status ?? null) && strtolower($order->payment_status) === 'paid'
                ) || ($order->is_paid ?? false));
                $paidAmount = $order->paid_amount ?? $order->paid_total ?? ($isPaid ? ($order->total_amount ?? 0) : 0);
                $shippingLabel = $order->shipping_title ?? $order->shipping_method ?? 'Free Standard Shipping';
                $shippingWeightInfo = $order->shipping_weight_info ?? $order->shipping_weight_text ?? null;
                $taxName = $order->tax_name ?? $order->tax_label ?? 'Taxes';
                $taxRate = isset($order->tax_rate) ? (float)$order->tax_rate : (isset($order->tax_percent) ? (float)$order->tax_percent : null);
                $appliedGift = $order->appliedgiftcard ?? 0;
                $appliedPoints = $order->applied_points ?? 0;
                $rewardsDiscount = $order->rewards_discount ?? 0;
                @endphp

                <div class="card mb-4">
                    <div class="card-header">Billing</div>
                    <div class="card-body">
                        <div class="amount-card">
                            <div class="heading">
                                <div>
                                    @if($isPaid)
                                    <span class="badge badge-paid">Paid</span>
                                    @else
                                    <span class="badge badge-unpaid">Unpaid</span>
                                    @endif
                                </div>
                                <div class="small-muted">Payment</div>
                            </div>

                            <div class="amount-row">
                                <div class="label">Subtotal <div class="small-muted">({{ $productsCount }} items)</div>
                                </div>
                                <div class="value">${{ number_format($order->sub_total ?? 0, 2) }}</div>
                            </div>

                            <div class="amount-row">
                                <div class="label">Shipping <div class="small-muted">
                                        {{ $shippingLabel }}
                                        @if(!empty($shippingWeightInfo))
                                        ({{ $shippingWeightInfo }})
                                        @endif
                                    </div>
                                </div>

                                <div class="value">
                                    @if( (float)($order->shipping_fee ?? 0) == 0 )
                                    Free
                                    @else
                                    ${{ number_format($order->shipping_fee, 2) }}
                                    @endif
                                </div>
                            </div>

                            <div class="amount-row">
                                <div class="label">
                                    {{ $taxName }}
                                    @if(!is_null($taxRate))
                                    <small class="small-muted"> {{ rtrim(rtrim(number_format($taxRate,2), '0'), '.') }}%</small>
                                    @endif
                                </div>
                                <div class="value">${{ number_format($order->tax ?? 0, 2) }}</div>
                            </div>

                            @if(!empty($order->us_import_duties) && (float)$order->us_import_duties > 0)
                            <div class="amount-row">
                                <div class="label">U.S Import Duties & Fees</div>
                                <div class="value">${{ number_format($order->us_import_duties, 2) }}</div>
                            </div>
                            @endif

                            @if(!empty($appliedPoints) && (float)$appliedPoints > 0)
                            <div class="amount-row">
                                <div class="label">Used Points</div>
                                <div class="value">{{ number_format($appliedPoints, 2) }}</div>
                            </div>
                            @endif

                            @if(!empty($rewardsDiscount) && (float)$rewardsDiscount > 0)
                            <div class="amount-row">
                                <div class="label">Reward Discount</div>
                                <div class="value">- ${{ number_format($rewardsDiscount, 2) }}</div>
                            </div>
                            @endif

                            @if(!empty($appliedGift) && (float)$appliedGift > 0)
                            <div class="amount-row">
                                <div class="label">Gift Card Applied</div>
                                <div class="value">- ${{ number_format($appliedGift, 2) }}</div>
                            </div>
                            @endif

                            {{-- Total --}}
                            <div style="margin-top:8px; padding-top:12px;">
                                <div style="display:flex; justify-content:space-between; align-items:center;">
                                    <div style="font-weight:700;">Total</div>
                                    <div style="font-weight:700;">${{ number_format($order->total_amount ?? 0, 2) }}</div>
                                </div>
                            </div>

                            {{-- Paid amount (with border between Total and Paid) --}}
                            <div style="border-top:1px solid #efefef; margin-top:8px; padding-top:12px;">
                                <div style="display:flex; justify-content:space-between; align-items:center;">
                                    <div style="font-weight:700;">Paid</div>
                                    <div style="font-weight:700;">${{ number_format($paidAmount ?? ($order->total_amount ?? 0), 2) }}</div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
<div class="card mb-4">
    <div class="card-header">Timeline</div>
    <div class="card-body timeline-body">
        <div class="timeline-input mb-3">
            <textarea class="form-control" rows="2" placeholder="Leave a comment..."></textarea>
            <div class="text-end mt-2">
                <button class="btn btn-sm btn-primary">Post</button>
            </div>
        </div>

        <ul class="timeline-list list-unstyled mb-0">
            <li class="timeline-item">
                <div class="timeline-dot bg-primary"></div>
                <div class="timeline-content">
                    <p class="mb-1"><strong>Order confirmation email</strong> was sent to <a href="#">angela@shop.com</a></p>
                    <small class="text-muted">Yesterday · 11:00 AM</small>
                </div>
            </li>
            <li class="timeline-item">
                <div class="timeline-dot bg-success"></div>
                <div class="timeline-content">
                    <p class="mb-1">$65.50 CAD will be added to your Oct 10, 2025 payout</p>
                    <small class="text-muted">Yesterday · 11:01 AM</small>
                </div>
            </li>
            <li class="timeline-item">
                <div class="timeline-dot bg-warning"></div>
                <div class="timeline-content">
                    <p class="mb-1">Payment was processed using Visa ending in 8375</p>
                    <small class="text-muted">Yesterday · 11:02 AM</small>
                </div>
            </li>
            <li class="timeline-item">
                <div class="timeline-dot bg-secondary"></div>
                <div class="timeline-content">
                    <p class="mb-1">David placed this order on Online Store (checkout #37946)</p>
                    <small class="text-muted">Yesterday · 11:03 AM</small>
                </div>
            </li>
        </ul>
    </div>
</div>
            </div>

            {{-- RIGHT: Customer / Notes / Shipping consolidated into one sidebar card block --}}
            <div class="order-sidebar">
                <div class="card info-block">
                    <div class="card-header d-flex align-items-center">
                        <span>Notes</span>
                        <span class="ms-auto" title="Edit (no action)">
                            <!-- Pencil icon (inline SVG) -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                <path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-9.193 9.193a.5.5 0 0 1-.168.11l-4 1.5a.5.5 0 0 1-.65-.65l1.5-4a.5.5 0 0 1 .11-.168l9.193-9.193zM11.207 3L13 4.793 12.207 5.586 10.414 3.793 11.207 3zM4 11.5V13h1.5l7.146-7.146-1.5-1.5L4 11.5z" />
                            </svg>
                        </span>
                    </div>
                    <div class="card-body">
                        <p class="mb-0 text-muted">{{ $order->notes ?? 'No notes from customer' }}</p>
                    </div>
                </div>

                <div class="card info-block">
                    <div class="card-header">Customer</div>
                    <div class="card-body">
                        <p class="mb-1"><strong>{{ $order->user_meta_data['name'] ?? '' }} {{ $order->user_meta_data['last_name'] ?? '' }}</strong></p>

                        <p class="mb-0"><small>{{ (!empty($order->user_meta_data['order_count']) ? $order->user_meta_data['order_count'].' order(s)' : '') }}</small></p>

                        @php
                        // contact fallbacks
                        $email = $order->email ?? ($order->user_meta_data['email'] ?? null);
                        $phone = $order->user_meta_data['phone'] ?? $order->phone ?? null;
                        @endphp

                        {{-- Contact information --}}
                        <div class="mt-2 mb-1">
                            <div class="fw-bold small mb-1">Contact information</div>

                            @if(!empty($email))
                            <p class="mb-1">
                                <a href="mailto:{{ $email }}" class="text-decoration-none text-muted">
                                    {{ $email }}
                                </a>
                            </p>
                            @endif

                            @if(!empty($phone))
                            <p class="mb-0">
                                <a href="tel:{{ preg_replace('/\s+/', '', $phone) }}" class="text-decoration-none text-muted">
                                    {{ $phone }}
                                </a>
                            </p>
                            @endif
                        </div>
                    </div>

                    @if(!empty($deliverMetaData) || !empty($order->address))
                    <div class="card info-block">
                        <div class="card-header">Shipping address</div>
                        <div class="card-body">
                            @php
                            $addr = $deliverMetaData ?? ($order->address ?? []);
                            // Compose a one-line address
                            $oneLine = trim(implode(', ', array_filter([
                            $addr['address'] ?? $addr['line1'] ?? null,
                            $addr['city'] ?? null,
                            $addr['state_province'] ?? null,
                            $addr['country'] ?? null,
                            ])));
                            @endphp

                            @php
                            $addr = $deliverMetaData ?? ($order->address ?? []);
                            $oneLine = trim(implode(', ', array_filter([
                            $addr['address'] ?? $addr['line1'] ?? null,
                            $addr['city'] ?? null,
                            $addr['state_province'] ?? null,
                            $addr['country'] ?? null,
                            ])));
                            @endphp

                            {{-- One-line address --}}
                            @if(!empty($oneLine))
                            <p class="mb-2"><strong>Address:</strong> {{ $oneLine }}</p>
                            @endif

                            {{-- Country --}}
                            @if(!empty($addr['country']) || !empty($addr['country_iso']))
                            <p class="mb-2"><strong>Country:</strong> {{ $addr['country'] ?? '' }}{{ !empty($addr['country_iso']) ? ' ('.$addr['country_iso'].')' : '' }}</p>
                            @endif

                            {{-- State/Province --}}
                            @if(!empty($addr['state_province']))
                            <p class="mb-2"><strong>State/Province:</strong> {{ $addr['state_province'] }}</p>
                            @endif

                            {{-- City --}}
                            @if(!empty($addr['city']))
                            <p class="mb-2"><strong>City:</strong> {{ $addr['city'] }}</p>
                            @endif

                            <!-- {{-- Street --}}
                            @if(!empty($addr['address']) || !empty($addr['line1']))
                            <p class="mb-2"><strong>Street:</strong> {{ $addr['address'] ?? $addr['line1'] ?? '' }}</p>
                            @endif -->

                            {{-- Postcode --}}
                            @if(!empty($addr['postcode']))
                            <p class="mb-2"><strong>Postcode:</strong> {{ $addr['postcode'] }}</p>
                            @endif

                            {{-- Location (inline) --}}
                            @if(!empty($addr['latitude']) && !empty($addr['longitude']))
                            <p class="mb-2"><strong>Location:</strong>
                                <a href="https://www.google.com/maps?q={{ $addr['latitude'] }},{{ $addr['longitude'] }}" target="_blank" class="text-decoration-none">View on Map</a>
                            </p>
                            @endif

                        </div>
                        @endif
                    </div>


                </div>
            </div>
        </div>
        <!-- Timeline Section -->


</main>
@endsection

@section('admininsertjavascript')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(function() {

        // --- Order Status Update (same logic as before) ---
        $('#updateStatusForm').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);
            const url = "{{ route('admin.orders.updateStatus', $order->id) }}";

            Swal.fire({
                title: 'Update Order Status?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Update',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.showLoading();

                    $.post(url, form.serialize())
                        .done(res => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Updated',
                                text: res.message || 'Order status updated successfully!',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => location.reload());
                        })
                        .fail(xhr => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: xhr.responseJSON?.message || 'Something went wrong!'
                            });
                        });
                }
            });
        });

        // --- Bundle Dropdown Change (keeps original functionality) ---
  $('.bundleProductSelect').on('change', function() {
    const index = $(this).data('index');
    const opt = $(this).find('option:selected');

    // update image
    $('#bundleImage' + index).attr('src', opt.data('image'));

    // update details block if you still use it
    $('#bundleDetails' + index)?.html(`
        <p class="mb-1"><strong>Qty:</strong> ${opt.data('qty')}</p>
        <p class="mb-0"><strong>Price:</strong> $${parseFloat(opt.data('price')).toFixed(2)}</p>
    `);

    // pre-order badge
    if (parseInt(opt.data('pre')) === 1) {
        $('#bundlePrebadge' + index).html('<span class="badge bg-warning text-dark">Pre-order</span>');
    } else {
        $('#bundlePrebadge' + index).html('');
    }

    // update price/qty display in the row
    const price = parseFloat(opt.data('price') || 0).toFixed(2);
    const qty = parseInt(opt.data('qty') || 1);
    const total = (price * qty).toFixed(2);
    $('#bundleImage' + index).closest('.product-row').find('.product-price-col .line').text(`$${price} × ${qty}`);
    $('#bundleImage' + index).closest('.product-row').find('.product-price-col .total').text(`$${total}`);

    // update variant display (size / color name) and color dot if hex present
    const size = opt.data('size') || '';
    const colorName = opt.data('color-name') || '';
    const colorHex = opt.data('color-hex') || '';
    const parts = [];
    if (size) parts.push(size);
    if (colorName) parts.push(colorName);
    const variantText = parts.join(' / ');
    const variantEl = $('#bundleVariant' + index);

    if (variantText) {
        if (colorHex) {
            variantEl.html(`<span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:${colorHex};margin-right:6px;vertical-align:middle;border:1px solid rgba(0,0,0,0.06)"></span> ${variantText}`);
        } else {
            variantEl.text(variantText);
        }
    } else {
        // fallback to empty or existing inline text
        variantEl.text('');
    }
}).trigger('change');
// --- Bangle Dropdown Change (parity with bundle behavior) ---
$('.bangleProductSelect').on('change', function() {
    const $sel = $(this);
    const index = $sel.data('index');
    const $opt = $sel.find('option:selected');

    // update image
    const newImg = $opt.data('image') || '';
    if (newImg) {
        $('#bangleImage' + index).attr('src', newImg);
    }

    // update product title to show color name (where bundles show product name)
    const colorName = $opt.data('color-name') || '';
    const $row = $('#bangleImage' + index).closest('.product-row');
    if ($row.length) {
        const $title = $row.find('.product-title').first();
        if ($title.length) {
            if (colorName) {
                $title.text(colorName);
            } else {
                // fallback to size text if no color name
                const sizeFallback = $opt.data('size') || '';
                $title.text(sizeFallback ? ('Bangle Box - Size ' + sizeFallback) : 'Bangle Box');
            }
        }
    }

    // update variant display (size) - placed above qty per your Blade
 // update variant display (Box Size / Color / Bangle Size) - placed above qty per your Blade
const boxSize = $opt.data('size') || '';
const bangleSize = $opt.data('bangle-size') || '';
const $variantEl = $('#bangleVariant' + index);

if ($variantEl.length) {
    // Build the HTML once
    const html = `
        <strong>Box Size:</strong> ${boxSize || '-'} Color
        <br>
        <strong>Bangle Size:</strong> ${bangleSize || '-'}
    `;
    $variantEl.html(html);
}


    // update price/qty display in the row
    const price = parseFloat($opt.data('price') || 0);
    const qty = parseInt($opt.data('qty') || 1, 10);
    const total = (price * qty);

    // ensure formatted strings like your bundle code
    const priceStr = price.toFixed(2);
    const totalStr = total.toFixed(2);

    if ($row.length) {
        $row.find('.product-price-col .line').text(`$${priceStr} × ${qty}`);
        $row.find('.product-price-col .total').text(`$${totalStr}`);
    }
});

// trigger initial state for all bangle selects so UI is correct on load
$('.bangleProductSelect').each(function() {
    $(this).trigger('change');
});

    });
</script>
@endsection