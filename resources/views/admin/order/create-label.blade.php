{{-- resources/views/admin/order/create-label.blade.php --}}
@extends('components.layouts.admin-default')

@section('content')
@include('components.includes.admin.navbar')
<style>
    .pac-container {
        z-index: 2000 !important;
    }

    .shipping-service-card .card-header {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .shipping-service-card .ss-header-left {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .shipping-service-card .ss-title {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
    }

    .shipping-service-card .ss-sub {
        font-size: 13px;
        color: #6b7280;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .shipping-service-card .ss-selected-by {
        background: #f6f8fa;
        border-radius: 8px;
        padding: 10px 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
        color: #374151;
        font-size: 13px;
    }

    .ss-options {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: 4px;
    }

    .ss-option {
        display: block;
        width: 100%;
        text-align: left;
        padding: 12px;
        border-radius: 8px;
        border: 1px solid rgba(15, 23, 42, 0.06);
        background: white;
        cursor: pointer;
        transition: box-shadow .12s ease, transform .06s ease, border-color .12s ease;
        position: relative;
    }

    .ss-option:focus {
        outline: 3px solid rgba(59, 130, 246, 0.12);
        outline-offset: 2px;
    }

    .ss-option:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.04);
    }

    /* Selected style: thicker border like your screenshot */
    .ss-option.ss-selected {
        border: 2px solid rgba(17, 24, 39, 0.95);
        box-shadow: 0 8px 24px rgba(17, 24, 39, 0.06);
        background: #fff;
    }

    /* small check marker at top-right for selected */
    /* .ss-option.ss-selected::after{
    content: "✔";
    position:absolute;
    right:12px;
    top:12px;
    font-size:12px;
    color:#111827;
    background:transparent;
  } */

    .ss-grid {
        display: flex;
        gap: 12px;
        align-items: flex-start;
    }

    .ss-logo {
        flex: 0 0 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .ss-info-wrap {
        flex: 1;
        min-width: 0;
    }

    .ss-name-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        margin-bottom: 6px;
    }

    .ss-name {
        font-weight: 600;
        font-size: 14px;
        color: #0f172a;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .ss-price {
        font-weight: 600;
        font-size: 14px;
        color: #0f172a;
        white-space: nowrap;
        margin-left: 12px;
    }

    .ss-meta-row {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 4px;
    }

    .ss-subtext {
        color: #6b7280;
        font-size: 13px;
        line-height: 1.2;
        flex: 1 1 100%;
    }

    .ss-badge {
        display: inline-block;
        font-size: 12px;
        padding: 4px 8px;
        border-radius: 999px;
        background: #eef2ff;
        color: #3730a3;
        font-weight: 600;
        white-space: nowrap;
    }

    .ss-badge-info {
        background: #dbeafe;
        color: #1e293b;
    }

    /* Details (expand/collapse) */
    .ss-details {
        max-height: 0;
        overflow: hidden;
        transition: max-height .22s ease, opacity .18s ease;
        opacity: 0;
        margin-top: 6px;
    }

    .ss-option.ss-selected .ss-details {
        opacity: 1;
        max-height: 240px;
        /* enough for contents */
    }

    .ss-check-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 8px;
        font-size: 13px;
        color: #111827;
    }

    .ss-check-list li {
        display: flex;
        gap: 10px;
        align-items: flex-start;
    }

    .ss-checkmark {
        display: inline-flex;
        width: 20px;
        height: 20px;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: #059669;
        margin-top: 1px;
    }

    /* Responsive */
    @media (max-width:900px) {
        .ss-name {
            font-size: 13px;
        }

        .ss-price {
            font-size: 13px;
        }
    }
</style>
<style>
    /* Page layout */
    body {
        background: #f4f6f8;
    }

    .content-wrapper {
        padding: 18px 0;
    }

    .create-label-wrap {
        max-width: 1200px;
        margin: 0 auto;
    }

    .page-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
    }

    .page-top h4 {
        margin: 0;
    }

    .meta-line {
        color: #6c757d;
        font-size: 0.95rem;
        margin-top: 6px;
    }

    .layout {
        display: flex;
        gap: 18px;
        align-items: flex-start;
    }

    .left-col {
        flex: 1 1 66%;
        min-width: 520px;
    }

    .right-col {
        width: 320px;
    }

    .card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 1px 6px rgba(16, 24, 40, 0.06);
        border: 0;
        overflow: hidden;
    }

    .card+.card {
        margin-top: 18px;
    }

    .card-header {
        padding: 12px 16px;
        border-bottom: 1px solid #efefef;
        font-weight: 600;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-body {
        padding: 16px;
    }

    /* Small helper button inside headers (Add package) */
    .card-header .header-actions {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .btn-add-package {
        padding: 6px 10px;
        border-radius: 8px;
        border: 1px solid #e6e9ee;
        background: #fff;
        cursor: pointer;
        font-size: 0.85rem;
    }

    /* Shipping address card */
    .address-block p {
        margin: 0 0 6px 0;
        color: #333;
    }

    /* Items table */
    .items-table {
        border: 1px solid #eef0f2;
        border-radius: 8px;
        overflow: hidden;
        background: #fff;
    }

    .items-head {
        display: flex;
        padding: 12px 14px;
        background: #fafafa;
        border-bottom: 1px solid #eef0f2;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        color: #4b5563;
    }

    .items-head .col-prod {
        flex: 1;
    }

    .items-head .col-qty {
        width: 150px;
        text-align: center;
    }

    .items-head .col-weight {
        width: 220px;
        text-align: right;
    }

    .items-body {
        padding: 12px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .item-row {
        display: flex;
        gap: 12px;
        align-items: center;
        padding: 10px;
        border: 1px solid #f0f0f0;
        border-radius: 8px;
        background: #fff;
    }

    .item-left {
        display: flex;
        gap: 12px;
        align-items: center;
        flex: 1;
    }

    .thumb {
        width: 56px;
        height: 56px;
        border-radius: 8px;
        border: 1px solid #ececec;
        object-fit: contain;
        background: #fff;
        padding: 6px;
    }

    .prod-info {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .prod-name {
        font-weight: 600;
        font-size: 14px;
        color: #111827;
    }

    .prod-variant {
        font-size: 13px;
        color: #6b7280;
    }

    .col-qty {
        width: 150px;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* quantity: simple text that looks compact */
    .qty-text {
        font-weight: 600;
        font-size: 14px;
        color: #111827;
        padding: 6px 10px;
        border-radius: 8px;
        border: 1px solid #e6e9ee;
        background: #fff;
        min-width: 56px;
        text-align: center;
    }

    /* hide any leftover old qty-select */
    .qty-select {
        display: none !important;
    }

    .col-weight {
        width: 220px;
        text-align: right;
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }

    .weight-input {
        display: inline-flex;
        gap: 8px;
        align-items: center;
    }

    .weight-input input[type="number"] {
        width: 110px;
        padding: 8px 10px;
        border-radius: 8px;
        border: 1px solid #e6e9ee;
        background: #fff;
    }

    .weight-unit {
        padding: 8px 10px;
        border-radius: 8px;
        border: 1px solid #e6e9ee;
        background: #fff;
        cursor: pointer;
    }

    /* Package card styling that matches screenshot */
    .package-card .card-body {
        padding: 12px;
        border-radius: 12px;
        background: #fff;
        box-shadow: none;
        border: 1px solid #eef0f2;
    }

    .package-select-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .package-select {
        width: 100%;
        border-radius: 8px;
        border: 1px solid #e6e9ee;
        padding: 12px;
        background: #fff;
        display: flex;
        align-items: center;
        gap: 12px;
        cursor: pointer;
        position: relative;
    }

    .package-select .package-icon {
        width: 28px;
        height: 28px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        background: #f3f4f6;
        border: 1px solid #ececec;
        font-size: 14px;
    }

    .package-select .package-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
        min-width: 180px;
    }

    .package-select .package-title {
        font-weight: 600;
        color: #111827;
    }

    .package-select .package-desc {
        font-size: 13px;
        color: #6b7280;
    }

    /* badges */
    .pkg-badges {
        display: flex;
        gap: 8px;
        align-items: center;
        margin-left: auto;
    }

    .pkg-badge {
        font-size: 12px;
        color: #374151;
        background: #f8fafc;
        border: 1px solid #eef2f7;
        padding: 6px 8px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .package-caret {
        margin-left: 8px;
        color: #6b7280;
    }

    /* dropdown panel */
    .package-dropdown {
        position: relative;
        margin-top: 8px;
        list-style: none;
        padding: 8px;
        border-radius: 8px;
        border: 1px solid #eef0f2;
        background: #fff;
        box-shadow: 0 6px 20px rgba(16, 24, 40, 0.06);
        display: none;
        max-height: 240px;
        overflow: auto;
        z-index: 40;
    }

    .package-dropdown.open {
        display: block;
    }

    .package-option {
        display: flex;
        gap: 12px;
        align-items: center;
        padding: 10px;
        border-radius: 8px;
        cursor: pointer;
    }

    .package-option:hover {
        background: #f8fafc;
    }

    .package-option .opt-info {
        display: flex;
        flex-direction: column;
    }

    .package-option .opt-title {
        font-weight: 600;
        color: #111827;
    }

    .package-option .opt-desc {
        font-size: 13px;
        color: #6b7280;
    }

    /* Total weight card header and input */
    .total-card .card-body {
        padding: 16px;
    }

    .total-label {
        font-weight: 600;
        margin-bottom: 8px;
    }

    .total-sub {
        color: #6b7280;
        font-size: 13px;
        margin-bottom: 8px;
    }

    .total-control {
        display: flex;
        gap: 8px;
        align-items: center;
        justify-content: space-between;
    }

    .total-control .weight-input {
        width: 100%;
        display: flex;
        justify-content: flex-end;
        gap: 8px;
    }

    .total-control input[type="number"] {
        width: 220px;
        border-radius: 8px;
        padding: 10px 12px;
        border: 1px solid #e6e9ee;
    }

    .total-control .unit-select {
        width: 72px;
        border-radius: 8px;
        padding: 8px 10px;
        border: 1px solid #e6e9ee;
        background: #fff;
    }

    .small-muted {
        color: #6b7280;
        font-size: 12px;
    }

    /* Sidebar summary */
    .summary-card .card-body {
        padding: 12px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px dashed #f1f1f1;
    }

    .summary-row:last-child {
        border-bottom: 0;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        font-weight: 700;
        padding-top: 10px;
        border-top: 1px solid #efefef;
        margin-top: 8px;
    }

    .btn-buy {
        width: 100%;
        padding: 10px 12px;
        border-radius: 8px;
        background: #111827;
        color: #fff;
        border: 0;
        cursor: pointer;
    }

    .btn-buy:disabled,
    .btn-buy.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* small */
    .text-muted {
        color: #6b7280;
        font-size: 13px;
    }

    /* responsive */
    @media (max-width: 992px) {
        .layout {
            flex-direction: column;
        }

        .right-col {
            width: auto;
        }
    }

    /* Total weight input styling to match screenshot */
    .total-card .card-body {
        padding: 16px;
    }

    .total-label {
        font-weight: 600;
        margin-bottom: 8px;
    }

    .total-sub {
        color: #6b7280;
        font-size: 13px;
        margin-bottom: 8px;
    }

    /* wrapper that looks like Shopify input with unit on right */
    .total-input-wrap {
        display: flex;
        align-items: center;
        gap: 8px;
        border: 1px solid #e6e9ee;
        padding: 6px 8px;
        border-radius: 8px;
        background: #fff;
        max-width: 100%;
        box-sizing: border-box;
    }

    /* the numeric input — visually borderless, full-width inside wrapper */
    .total-input-wrap input[type="number"] {
        border: 0;
        outline: 0;
        font-size: 14px;
        padding: 8px 6px;
        width: 100%;
        -moz-appearance: textfield;
    }

    /* remove default arrows in some browsers */
    .total-input-wrap input[type="number"]::-webkit-outer-spin-button,
    .total-input-wrap input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* unit control on right that looks like a small pill */
    .total-unit-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-left: 1px solid #eef0f2;
        padding-left: 8px;
    }

    /* style the unit select (small, transparent so it looks native inside pill) */
    .total-unit-pill .unit-select {
        border: 0;
        background: transparent;
        padding: 6px 8px;
        font-size: 13px;
        -webkit-appearance: none;
        appearance: none;
    }

    /* caret icon spacing */
    .total-unit-pill .caret {
        margin-left: 4px;
        color: #6b7280;
        font-size: 12px;
    }

    /* ensure hint is small and right aligned */
    #totalWeightHint {
        font-size: 12px;
        color: #6b7280;
        margin-top: 8px;
        text-align: right;
    }

    /* package dropdown: make the dropdown full width and positioned below the display box */
    .package-select-wrap {
        position: relative;
    }

    /* package-select is the visible box; keep it as-is (already present) */
    .package-select {
        cursor: pointer;
    }

    /* dropdown: absolute, full width of the package-select parent, drop below it */
    .package-dropdown {
        position: absolute;
        left: 0;
        top: calc(100% + 8px);
        /* sits right below display with small gap */
        width: 100%;
        /* same width as the visible box */
        list-style: none;
        margin: 0;
        padding: 8px;
        border-radius: 8px;
        border: 1px solid #eef0f2;
        background: #fff;
        box-shadow: 0 8px 20px rgba(16, 24, 40, 0.08);
        display: none;
        max-height: 280px;
        overflow: auto;
        z-index: 60;
    }

    /* open state */
    .package-dropdown.open {
        display: block;
    }

    /* package option styles */
    .package-option {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px;
        border-radius: 8px;
        cursor: pointer;
    }

    .package-option+.package-option {
        margin-top: 6px;
    }

    .package-option:hover {
        background: #f8fafc;
    }

    /* selected option highlight */
    .package-option.selected {
        background: #eef4ff;
        border: 1px solid rgba(59, 130, 246, 0.12);
    }

    /* keep badges inside options compact */
    .package-option .pkg-badge {
        font-size: 12px;
        padding: 6px 8px;
        border-radius: 8px;
        background: #f8fafc;
        border: 1px solid #eef0f2;
    }

    /* ensure caret stays visible on the visible select */
    .package-caret {
        margin-left: 8px;
        color: #6b7280;
        font-size: 14px;
    }

    /* Make the package dropdown span the full card-body width and sit under the card body */
    .package-card .card-body {
        position: relative;
    }

    /* Position dropdown absolutely relative to card-body and stretch to its width */
    .package-card .package-dropdown {
        position: absolute;
        left: 0;
        top: calc(100% + 12px);
        /* distance below the card-body content; adjust if you want smaller/larger gap */
        width: 100%;
        box-sizing: border-box;
        margin: 0;
        padding: 8px;
        border-radius: 8px;
        border: 1px solid #eef0f2;
        background: #fff;
        box-shadow: 0 8px 20px rgba(16, 24, 40, 0.08);
        display: none;
        max-height: 280px;
        overflow: auto;
        z-index: 80;
    }

    /* keep open rule */
    .package-card .package-dropdown.open {
        display: block;
    }

    /* Force package dropdown to position relative to card-body and be visible above other elements */
    .package-card .card-body {
        position: relative;
        z-index: 1;
    }

    /* Ensure wrapper allows the dropdown to overflow */
    .package-card .package-select-wrap {
        overflow: visible;
        position: relative;
        z-index: 2;
    }

    /* Stronger rule to position the dropdown across full card-body width, above everything */
    .package-card .package-dropdown {
        position: absolute !important;
        left: 0 !important;
        top: calc(100% + 12px) !important;
        /* sits right below card-body */
        width: 100% !important;
        box-sizing: border-box !important;
        margin: 0 !important;
        padding: 8px !important;
        border-radius: 8px !important;
        border: 1px solid #eef0f2 !important;
        background: #fff !important;
        box-shadow: 0 12px 30px rgba(16, 24, 40, 0.12) !important;
        display: none !important;
        max-height: 320px !important;
        overflow: auto !important;
        z-index: 9999 !important;
    }

    /* open state */
    .package-card .package-dropdown.open {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
    }

    /* allow dropdown visual style but we will position it via JS when opened */
    .package-dropdown {
        /* remove layout constraints for JS positioning */
        display: none;
        position: absolute;
        left: 0;
        top: 0;
        width: auto;
        max-height: 320px;
        overflow: auto;
        box-shadow: 0 12px 30px rgba(16, 24, 40, 0.12);
        border: 1px solid #eef0f2;
        background: #fff;
        z-index: 99999;
        border-radius: 8px;
    }

    /* visible state (JS will also set inline styles) */
    .package-dropdown.open {
        display: block;
    }

    /* visually mark selected option */
    .package-option.selected {
        background: #eef4ff;
        border: 1px solid rgba(59, 130, 246, 0.12);
    }

    .package-option {
        padding: 10px;
        min-height: 48px;
        /* ensures a predictable option size for JS */
        box-sizing: border-box;
    }

    .package-dropdown {
        overflow: auto;
        /* ensure scrolling when maxHeight reached */
    }

    /* logo sizing for image-based logos */
    .shipping-service-card .ss-logo-img {
        display: block;
        width: 28px;
        height: 20px;
        object-fit: contain;
    }
</style>

<main class="content-wrapper">
    <div class="container-fluid create-label-wrap">

        {{-- Header --}}
        <div class="page-top">
            <div>
                <h4 class="mb-0">Create shipping label</h4>
                @php
                $orderDate = optional($order->created_at)->format('M j, Y \a\t g:i a') ?? '';
                @endphp
                <div class="meta-line">Order #{{ $order->order_id }} · {{ $orderDate }}</div>
            </div>

            <div>
                <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-secondary">← Back</a>
            </div>
        </div>

        <div class="layout">
            {{-- LEFT: main flow --}}
            <div class="left-col">

                {{-- Shipping address --}}
                {{-- Shipping Address --}}
                @php
                $addr = $deliverMetaData ?? ($order->user_meta_data ?? []);
                $oneLine = trim(implode(', ', array_filter([
                $addr['address'] ?? $addr['line1'] ?? null,
                $addr['city'] ?? null,
                $addr['state_province'] ?? null,
                $addr['country'] ?? null,
                ])));

                $firstName = $order->user_meta_data['name'] ?? '';
                $lastName = $order->user_meta_data['last_name'] ?? '';
                $phone = $order->user_meta_data['phone'] ?? $order->phone ?? null;
                @endphp

                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Shipping address</span>
                        <i class="fa fa-edit text-primary"
                            style="cursor:pointer"
                            id="editAddressBtn"
                            data-bs-toggle="modal"
                            data-bs-target="#editAddressModal"
                            data-address="{{ $addr['address'] ?? '' }}"
                            data-city="{{ $addr['city'] ?? '' }}"
                            data-state="{{ $addr['state_province'] ?? '' }}"
                            data-country="{{ $addr['country'] ?? '' }}"
                            data-zip="{{ $addr['postcode'] ?? $addr['postal_code'] ?? '' }}"
                            data-first_name="{{ $firstName }}"
                            data-last_name="{{ $lastName }}"
                            data-phone="{{ $phone }}"

               data-country_iso="{{ $addr['country_iso'] ?? '' }}"
               data-state_code="{{ $addr['province_code'] ?? '' }}"
               data-formatted_address="{{ $addr['formatted_address'] ?? '' }}"
               data-latitude="{{ $addr['latitude'] ?? '' }}"
               data-longitude="{{ $addr['longitude'] ?? '' }}"
               data-place_id="{{ $addr['place_id'] ?? '' }}"
               data-area="{{ $addr['area'] ?? '' }}"
               data-sub_area="{{ $addr['sub_area'] ?? '' }}"
                            ></i>
                    </div>

                    <div class="card-body address-block">
                        @if(!empty($oneLine))
                        <p class="mb-1">{{ $oneLine }}</p>
                        @endif

                        @if(!empty($addr['address']))
                        <p class="mb-1 text-muted">{{ $addr['address'] }}</p>
                        @endif

                        @if(!empty($addr['city']))
                        <p class="mb-1 text-muted">{{ $addr['city'] }}{{ !empty($addr['state_province']) ? ', '.$addr['state_province'] : '' }}</p>
                        @endif

                        @if(!empty($addr['country'] || $addr['country_iso']))
                        <p class="mb-0 text-muted">{{ $addr['country'] ?? '' }}{{ !empty($addr['country_iso']) ? ' ('.$addr['country_iso'].')' : '' }}</p>
                        @endif

                        @if(!empty($firstName) || !empty($lastName))
                        <p class="mb-1"><strong>{{ $firstName }} {{ $lastName }}</strong></p>
                        @endif

                        @if(!empty($phone))
                        <p class="mb-0 text-muted">{{ $phone }}</p>
                        @endif
                    </div>
                </div>


                <!-- Edit Address Modal -->
                <div class="modal fade" id="editAddressModal" tabindex="-1" aria-labelledby="editAddressModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editAddressModalLabel">Edit Shipping Address</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                               <form id="editAddressForm">
    <input type="hidden" id="order_id" value="{{ $order->id ?? '' }}">
    <input type="hidden" id="latitude">
    <input type="hidden" id="longitude">
    <input type="hidden" id="place_id">
    <input type="hidden" id="area">
    <input type="hidden" id="sub_area">

    <!-- New hidden fields for codes + formatted -->
    <input type="hidden" id="country_iso">
    <input type="hidden" id="state_code">
    <input type="hidden" id="formatted_address">

    <div class="row g-3">
        <div class="col-md-6">
            <label>First Name</label>
            <input type="text" id="first_name" class="form-control" value="{{ $firstName ?? '' }}">
        </div>
        <div class="col-md-6">
            <label>Last Name</label>
            <input type="text" id="last_name" class="form-control" value="{{ $lastName ?? '' }}">
        </div>

        <div class="col-12">
            <label>Search Address</label>
            <input id="autocomplete" type="text" class="form-control" placeholder="Search your full address">
            <span id="error-autocomplete" class="text-danger small"></span>
        </div>

        <div class="col-md-6">
            <label>Country</label>
            <input type="text" id="country" class="form-control" readonly>
        </div>
        <div class="col-md-6">
            <label>State</label>
            <input type="text" id="state" class="form-control" readonly>
        </div>
        <div class="col-md-6">
            <label>City</label>
            <input type="text" id="city" class="form-control" readonly>
        </div>
        <div class="col-md-6">
            <label>ZIP Code</label>
            <input type="text" id="zip" class="form-control" readonly>
        </div>
        <div class="col-12">
            <label>Address</label>
            <input type="text" id="address" class="form-control" readonly>
        </div>
        <div class="col-12">
            <label>Phone</label>
            <input type="text" id="phone" class="form-control">
        </div>
    </div>
</form>


                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" id="saveAddressBtn">Save</button>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- Items card --}}
                <div class="card mb-3">
                    <div class="card-header">Items</div>
                    <div class="card-body">
                        {{-- Table-like head --}}
                        <div class="items-table">
                            <div class="items-head">
                                <div class="col-prod">Product</div>
                                <div class="col-qty">Quantity</div>
                                <div class="col-weight">Weight (per unit)</div>
                            </div>

                            <div class="items-body">
                                {{-- Single Products --}}
                                @if(!empty($productsMetaData['Products']))
                                @foreach($productsMetaData['Products'] as $item)
                                @php
                                $product = $item['product'] ?? [];
                                $imageFile = $product['images'][0] ?? 'default.jpg';
                                $img = asset('assets/images/products/' . $imageFile);
                                $qty = $item['qty'] ?? ($item['quantity'] ?? 1);

                                // Weight fallback — try line weight, product weight or 0
                                $weightVal = $item['weight'] ?? $product['weight'] ?? ($item['weight_in_grams'] ?? 0);
                                $weightVal = $weightVal ? (float)$weightVal : 0;
                                $unit = $item['weight_unit'] ?? $product['weight_unit'] ?? 'g';

                                // Variation fallback logic for size/color
                                $variation = $item['variation'] ?? null;
                                $size = $variation['size'] ?? $product['size'] ?? null;
                                $colorId = $variation['color_id'] ?? $product['color_id'] ?? null;

                                $colorName = null;
                                $colorHex = null;
                                if (!empty($colorId)) {
                                try {
                                $c = \App\Models\ProductColor::find($colorId);
                                if ($c) {
                                $colorName = $c->name;
                                $colorHex = $c->hex_code;
                                }
                                } catch (\Throwable $e) {
                                $colorName = null;
                                $colorHex = null;
                                }
                                }

                                $variantParts = [];
                                if (!empty($size)) $variantParts[] = $size;
                                if (!empty($colorName)) $variantParts[] = $colorName;
                                $variantText = !empty($variantParts) ? implode(' / ', $variantParts) : ($item['variant_name'] ?? $item['variant'] ?? '');
                                @endphp

                                <div class="item-row">
                                    <div class="item-left">
                                        <img src="{{ $img }}" alt="thumb" class="thumb">
                                        <div class="prod-info">
                                            <div class="prod-name">{{ $product['name'] ?? 'Product' }}</div>

                                            @if(!empty($variantText))
                                            <div class="prod-variant">
                                                @if(!empty($colorHex))
                                                <span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:{{ $colorHex }};margin-right:6px;vertical-align:middle;border:1px solid rgba(0,0,0,0.06)"></span>
                                                @endif
                                                {{ $variantText }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-qty">
                                        {{ $qty }}
                                    </div>

                                    <div class="col-weight">
                                        <div class="weight-input">
                                            <input type="number" min="0" step="1"
                                                value="{{ number_format($weightVal, 0, '.', '') }}"
                                                class="form-control form-control-sm weight-field" />
                                            <div class="weight-unit">
                                                <select class="form-select form-select-sm unit-select" style="border:0; background:transparent; padding:0;">
                                                    <option value="g" {{ $unit === 'g' ? 'selected' : '' }}>g</option>
                                                    <option value="kg" {{ $unit === 'kg' ? 'selected' : '' }}>kg</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif

                                {{-- Bundles --}}
                                @if(!empty($productsMetaData['Bundle']))
                                @foreach($productsMetaData['Bundle'] as $bundle)
                                @php
                                $bundleMeta = $bundle['bundle'] ?? [];
                                $first = $bundleMeta['products'][0] ?? null;
                                $firstProduct = $first['product'] ?? [];
                                $imageFile = $firstProduct['images'][0] ?? 'default.jpg';
                                $img = asset('assets/images/products/' . $imageFile);
                                $bundleQty = $bundle['qty'] ?? ($bundle['bundle']['qty'] ?? 1);
                                $bundleWeight = $bundle['line_weight'] ?? ($first['weight'] ?? $firstProduct['weight'] ?? 0);
                                $bundleWeight = $bundleWeight ? (float)$bundleWeight : 0;
                                @endphp

                                <div class="item-row">
                                    <div class="item-left">
                                        <img id="bundleImage{{ $loop->index }}" src="{{ $img }}" alt="bundle" class="thumb">
                                        <div class="prod-info" style="min-width:220px;">
                                            <div class="prod-name">{{ $bundleMeta['name'] ?? 'Bundle' }}</div>

                                            <div>
                                                <select class="form-select form-select-sm bundleProductSelect" data-index="{{ $loop->index }}" style="max-width:300px;">
                                                    @foreach($bundleMeta['products'] as $i => $bprod)
                                                    @php
                                                    $bp = $bprod['product'] ?? [];
                                                    $bv = $bprod['variation'] ?? null;
                                                    $b_size = $bv['size'] ?? $bp['size'] ?? null;
                                                    $b_colorId = $bv['color_id'] ?? $bp['color_id'] ?? null;

                                                    $b_colorName = null;
                                                    $b_colorHex = null;
                                                    if (!empty($b_colorId)) {
                                                    try {
                                                    $cm = \App\Models\ProductColor::find($b_colorId);
                                                    if ($cm) { $b_colorName = $cm->name; $b_colorHex = $cm->hex_code; }
                                                    } catch (\Throwable $e) {}
                                                    }

                                                    $displayText = $bp['name'] ?? 'Product';
                                                    $b_variant_parts = [];
                                                    if (!empty($b_size)) $b_variant_parts[] = $b_size;
                                                    if (!empty($b_colorName)) $b_variant_parts[] = $b_colorName;
                                                    $b_variant_text = !empty($b_variant_parts) ? ' — '.implode(' / ', $b_variant_parts) : '';
                                                    @endphp

                                                    <option value="{{ $i }}"
                                                        data-image="{{ asset('assets/images/products/' . ($bp['images'][0] ?? 'default.jpg')) }}"
                                                        data-qty="{{ $bprod['qty'] ?? 1 }}"
                                                        data-weight="{{ $bprod['weight'] ?? ($bp['weight'] ?? 0) }}"
                                                        data-size="{{ $b_size }}"
                                                        data-color-name="{{ $b_colorName }}"
                                                        data-color-hex="{{ $b_colorHex }}">
                                                        {{ $displayText }}{!! $b_variant_text !!}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="prod-variant mt-1" id="bundleVariant{{ $loop->index }}"></div>
                                        </div>
                                    </div>

                                    <div class="col-qty">
                                        {{ $bundleQty }}
                                    </div>

                                    <div class="col-weight">
                                        <div class="weight-input">
                                            <input type="number" min="0" step="1"
                                                value="{{ number_format($bundleWeight, 0, '.', '') }}"
                                                class="form-control form-control-sm bundle-weight-field" data-index="{{ $loop->index }}">
                                            <div class="weight-unit">
                                                <select class="form-select form-select-sm unit-select" style="border:0; background:transparent; padding:0;">
                                                    <option value="g" selected>g</option>
                                                    <option value="kg">kg</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif

                        {{-- 🩶 Bangle Boxes --}}
@if(!empty($bangletMetaData))
    @foreach($bangletMetaData as $i => $bItem)
        @php
            $bangleBox   = $bItem['bangle_box'] ?? [];
            $bangleSize  = $bItem['bangle_size'] ?? [];
            $colors      = $bItem['colors'] ?? [];

            // Get first color data
            $firstColor     = $colors[0]['color'] ?? $colors[0] ?? null;
            $firstImageFile = $firstColor['image'] ?? 'default.jpg';
            $firstImage     = asset('assets/images/bangle-box/' . $firstImageFile);
            $firstColorName = $firstColor['color_name'] ?? $firstColor['name'] ?? 'Default Color';

            // Quantity, Price, Weight
            $qty       = $bItem['qty'] ?? 1;
            $weight    = $bItem['line_weight'] ?? ($bangleBox['weight'] ?? 0);
            $weight    = $weight ? (float)$weight : 0;
        @endphp

        <div class="item-row">
            {{-- Left: image and dropdown --}}
            <div class="item-left">
                <img id="bangleImage{{ $loop->index }}" src="{{ $firstImage }}" alt="bangle" class="thumb">

                <div class="prod-info" style="min-width:220px;">
                    <div class="prod-name">
                        {{ $bangleBox['name'] ?? 'Bangle Box' }}
                    </div>

                    {{-- Dropdown (select color/variant) --}}
                    <div>
                        <select class="form-select form-select-sm bangleProductSelect" 
                                data-index="{{ $loop->index }}" style="max-width:300px;">
                            @foreach($colors as $ci => $colorWrap)
                                @php
                                    $color = $colorWrap['color'] ?? $colorWrap;
                                    $cName = $color['color_name'] ?? $color['name'] ?? "Color {$ci}";
                                    $cImage = $color['image'] ?? 'default.jpg';
                                    $cImageUrl = asset('assets/images/bangle-box/' . $cImage);
                                @endphp
                                <option value="{{ $ci }}"
                                    data-image="{{ $cImageUrl }}"
                                    data-qty="{{ $qty }}"
                                    data-weight="{{ $bangleBox['weight'] ?? 0 }}"
                                    data-size="{{ $bangleBox['size'] ?? '' }}"
                                    data-bangle-size="{{ $bangleSize['size'] ?? '' }}"
                                    data-color-name="{{ $cName }}">
                                    {{ $cName }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Variant details (Box Size + Bangle Size) --}}
                    <div class="prod-variant mt-1" id="bangleVariant{{ $loop->index }}">
                        <strong>Box Size:</strong> {{ $bangleBox['size'] ?? '-' }} 
                        &nbsp;|&nbsp;
                        <strong>Bangle Size:</strong> {{ $bangleSize['size'] ?? '-' }}
                    </div>
                </div>
            </div>

            {{-- Qty --}}
            <div class="col-qty">{{ $qty }}</div>

            {{-- Weight --}}
            <div class="col-weight">
                <div class="weight-input">
                    <input type="number" min="0" step="1"
                        value="{{ number_format($weight, 0, '.', '') }}"
                        class="form-control form-control-sm bangle-weight-field" 
                        data-index="{{ $loop->index }}">
                    <div class="weight-unit">
                        <select class="form-select form-select-sm unit-select" style="border:0; background:transparent; padding:0;">
                            <option value="g" selected>g</option>
                            <option value="kg">kg</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif


                            </div> {{-- .items-body --}}
                        </div> {{-- .items-table --}}
                    </div> {{-- .card-body --}}
                </div> {{-- .card (Items) --}}

                {{-- Package card (separate) --}}
                <div class="card mb-3 package-card">
                    <div class="card-header">
                        <div>Package</div>
                        <!-- <div class="header-actions">
                            <button class="btn-add-package">Add package</button>
                        </div> -->
                    </div>
                    <div class="card-body">
                        <div class="package-select-wrap" style="position:relative;">
                            <!-- visible custom select -->
                            <div id="packageSelectDisplay" class="package-select" tabindex="0" aria-haspopup="listbox" aria-expanded="false" role="button">
                                <div class="package-icon">📦</div>
                                <div class="package-info">
                                    <div id="packageTitle" class="package-title">Sample box</div>
                                    <div id="packageDesc" class="package-desc">30 × 20 × 15 cm</div>
                                </div>

                                <div class="pkg-badges" aria-hidden="true">
                                    <div id="badgeDim" class="pkg-badge">30 × 20 × 15 cm</div>
                                    <div id="badgeWt" class="pkg-badge">0.1 g</div>
                                </div>

                                <div class="package-caret">▾</div>
                            </div>

                            <!-- dropdown panel (replace existing packageDropdown) -->
                            <ul id="packageDropdown" class="package-dropdown" role="listbox" aria-labelledby="packageSelectDisplay">
                                <!-- Small flat -->
                                <li class="package-option" role="option"
                                    data-label="Small flat"
                                    data-dim="20 × 15 × 3 cm"
                                    data-weight="50 g"
                                    data-wgrams="50">
                                    <div class="package-icon">📦</div>
                                    <div class="opt-info">
                                        <div class="opt-title">Small flat</div>
                                        <div class="opt-desc">20 × 15 × 3 cm</div>
                                    </div>
                                    <div style="margin-left:auto; display:flex; gap:8px; align-items:center;">
                                        <div class="pkg-badge">20 × 15 × 3 cm</div>
                                        <div class="pkg-badge">50 g</div>
                                    </div>
                                </li>

                                <!-- Sample box -->
                                <li class="package-option" role="option"
                                    data-label="Sample box"
                                    data-dim="30 × 20 × 15 cm"
                                    data-weight="100 g"
                                    data-wgrams="100">
                                    <div class="package-icon">📦</div>
                                    <div class="opt-info">
                                        <div class="opt-title">Sample box</div>
                                        <div class="opt-desc">30 × 20 × 15 cm</div>
                                    </div>
                                    <div style="margin-left:auto; display:flex; gap:8px; align-items:center;">
                                        <div class="pkg-badge">30 × 20 × 15 cm</div>
                                        <div class="pkg-badge">100 g</div>
                                    </div>
                                </li>

                                <!-- Medium box -->
                                <li class="package-option" role="option"
                                    data-label="Medium box"
                                    data-dim="30 × 40 × 5 cm"
                                    data-weight="200 g"
                                    data-wgrams="200">
                                    <div class="package-icon">📦</div>
                                    <div class="opt-info">
                                        <div class="opt-title">Medium box</div>
                                        <div class="opt-desc">30 × 40 × 5 cm</div>
                                    </div>
                                    <div style="margin-left:auto; display:flex; gap:8px; align-items:center;">
                                        <div class="pkg-badge">30 × 40 × 5 cm</div>
                                        <div class="pkg-badge">200 g</div>
                                    </div>
                                </li>

                                <!-- Large box -->
                                <li class="package-option" role="option"
                                    data-label="Large box"
                                    data-dim="50 × 40 × 30 cm"
                                    data-weight="1500 g"
                                    data-wgrams="1500">
                                    <div class="package-icon">📦</div>
                                    <div class="opt-info">
                                        <div class="opt-title">Large box</div>
                                        <div class="opt-desc">50 × 40 × 30 cm</div>
                                    </div>
                                    <div style="margin-left:auto; display:flex; gap:8px; align-items:center;">
                                        <div class="pkg-badge">50 × 40 × 30 cm</div>
                                        <div class="pkg-badge">1500 g</div>
                                    </div>
                                </li>

                                <!-- Custom box -->
                                <li class="package-option" role="option"
                                    data-label="Custom box"
                                    data-dim="14 × 11 × 4 in"
                                    data-weight="0 g"
                                    data-wgrams="0">
                                    <div class="package-icon">📦</div>
                                    <div class="opt-info">
                                        <div class="opt-title">Custom box</div>
                                        <div class="opt-desc">14 × 11 × 4 in</div>
                                    </div>
                                    <div style="margin-left:auto; display:flex; gap:8px; align-items:center;">
                                        <div class="pkg-badge">14 × 11 × 4 in</div>
                                        <div class="pkg-badge">0 g</div>
                                    </div>
                                </li>
                            </ul>

                            <!-- hidden select (keep for compatibility) -->
                            <select id="packageSelect" name="package" style="display:none;">
                                <option value="Sample Box">Sample Box — 20 × 15 × 3 cm, 50 g</option>
                                <option value="Small flat">Small flat — 20 × 15 × 3 cm, 50 g</option>
                                <option value="Sample box">Sample box — 30 × 20 × 15 cm, 100 g</option>
                                <option value="Medium box">Medium box — 30 × 40 × 5 cm, 200 g</option>
                                <option value="Large box">Large box — 50 × 40 × 30 cm, 1500 g</option>
                                <option value="Custom box">Custom box — 14 × 11 × 4 in, 0 g</option>
                            </select>

                        </div>
                    </div>
                </div>

                <!-- Total weight card (replace your existing .total-card block with this) -->
                <div class="card mb-3 total-card">
                    <div class="card-header">Total weight</div>
                    <div class="card-body">
                        <div class="total-label">Total weight (with package)</div>

                        <div style="display:flex; align-items:center; gap:12px;">
                            <div style="flex:1;"></div>

                            <!-- visually matching input with unit pill on right -->
                            <div style="width:700px !important;">
                                <div class="total-input-wrap" role="group" aria-label="Total weight input">
                                    <input id="totalWeightInput" type="number" min="0" step="0.01"
                                        value="{{ $productsMetaData['total_weight'] ?? '' }}" aria-label="Total weight value" />

                                    <div class="total-unit-pill" aria-hidden="false">
                                        <select id="totalUnitSelect" class="unit-select" aria-label="Total weight unit">
                                            <option value="g" selected>g</option>
                                            <option value="kg">kg</option>
                                        </select>
                                        <span class="caret">▾</span>
                                    </div>
                                </div>

                                <div class="small-muted mt-2" id="totalWeightHint"></div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card mb-3 shipping-service-card">
                    <!-- <div class="card-header">
    <div class="ss-header-left">
      <h4 class="ss-title">Shipping service</h4>
      <div class="ss-sub">DDP labels remit prepaid duties to carrier <span class="ss-info" aria-hidden="true">ℹ️</span></div>
    </div>
  </div> -->

                    <div class="card-body">
                        <!-- Selected by customer box -->
                        <div class="ss-selected-by">
                            <div class="ss-sel-label">Selected by customer</div>
                            <div class="ss-sel-desc">Free Standard Shipping · $0.00 CAD</div>
                        </div>

                        <!-- Hidden input to submit selected service -->
                        <input type="hidden" id="selectedShippingService" name="shipping_service" value="Small Packet USA Air">

                        <!-- Options -->
                        <div class="ss-options" role="radiogroup" aria-label="Shipping service options">
                            <!-- Option template: note data-id/data-price -->
                            <button type="button" role="radio" aria-checked="true" class="ss-option ss-selected" data-id="small-packet" data-name="Small Packet USA Air" data-price="$23.28 CAD">
                                <div class="ss-grid">
                                    <div class="ss-logo" aria-hidden="true">
                                        <!-- Use Laravel asset() to load the SVG from public/assets/images -->
                                        <img
                                            src="{{ asset('assets/images/carrier-canada-post-BHstWYmP7K60.svg') }}"
                                            alt="DHL Express logo"
                                            class="ss-logo-img"
                                            width="28"
                                            height="20"
                                            loading="lazy" />
                                    </div>

                                    <div class="ss-info-wrap">
                                        <div class="ss-name-row">
                                            <div class="ss-name">Small Packet USA Air <span class="ss-badge ss-badge-info">Cheapest</span></div>
                                            <div class="ss-price">$23.28 CAD</div>
                                        </div>
                                        <div class="ss-meta-row">
                                            <div class="ss-subtext">Includes prepaid duties</div>
                                        </div>

                                        <!-- details: visible only when selected -->
                                        <div class="ss-details" aria-hidden="false">
                                            <ul class="ss-check-list">
                                                <li><span class="ss-checkmark">✓</span> Prepaid duties</li>
                                                <li><span class="ss-checkmark">✓</span> Fastest economical</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </button>

                            <button type="button" role="radio" aria-checked="false" class="ss-option" data-id="tracked-packet" data-name="Tracked Packet USA" data-price="$23.28 CAD">
                                <div class="ss-grid">
                                    <div class="ss-logo" aria-hidden="true">
                                        <!-- Use Laravel asset() to load the SVG from public/assets/images -->
                                        <img
                                            src="{{ asset('assets/images/carrier-canada-post-BHstWYmP7K60.svg') }}"
                                            alt="DHL Express logo"
                                            class="ss-logo-img"
                                            width="28"
                                            height="20"
                                            loading="lazy" />
                                    </div>

                                    <div class="ss-info-wrap">
                                        <div class="ss-name-row">
                                            <div class="ss-name">Tracked Packet USA</div>
                                            <div class="ss-price">$23.28 CAD</div>
                                        </div>
                                        <div class="ss-meta-row">
                                            <span class="ss-badge">7–10 business days</span>
                                            <div class="ss-subtext">Includes tracking and delivery confirmation, insurance (up to $100.00), prepaid duties</div>
                                        </div>

                                        <div class="ss-details" aria-hidden="true">
                                            <ul class="ss-check-list">
                                                <li><span class="ss-checkmark">✓</span> Tracking and delivery confirmation</li>
                                                <li><span class="ss-checkmark">✓</span> Insurance (up to $100.00)</li>
                                                <li><span class="ss-checkmark">✓</span> Prepaid duties</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </button>

                            <button type="button" role="radio" aria-checked="false" class="ss-option" data-id="expedited-parcel" data-name="Expedited Parcel USA" data-price="$30.88 CAD">
                                <div class="ss-grid">
                                    <div class="ss-logo" aria-hidden="true">
                                        <!-- Use Laravel asset() to load the SVG from public/assets/images -->
                                        <img
                                            src="{{ asset('assets/images/carrier-canada-post-BHstWYmP7K60.svg') }}"
                                            alt="DHL Express logo"
                                            class="ss-logo-img"
                                            width="28"
                                            height="20"
                                            loading="lazy" />
                                    </div>

                                    <div class="ss-info-wrap">
                                        <div class="ss-name-row">
                                            <div class="ss-name">Expedited Parcel USA</div>
                                            <div class="ss-price">$30.88 CAD</div>
                                        </div>
                                        <div class="ss-meta-row">
                                            <span class="ss-badge">4–6 business days</span>
                                            <div class="ss-subtext">Includes tracking and delivery confirmation, insurance (up to $100.00), prepaid duties</div>
                                        </div>

                                        <div class="ss-details" aria-hidden="true">
                                            <ul class="ss-check-list">
                                                <li><span class="ss-checkmark">✓</span> Tracking and delivery confirmation</li>
                                                <li><span class="ss-checkmark">✓</span> Insurance (up to $100.00)</li>
                                                <li><span class="ss-checkmark">✓</span> Prepaid duties</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </button>

                            <button type="button" role="radio" aria-checked="false" class="ss-option" data-id="dhl-express" data-name="DHL Express Worldwide" data-price="$42.29 CAD">
                                <div class="ss-grid">
                                    <div class="ss-logo" aria-hidden="true">
                                        <!-- Use Laravel asset() to load the SVG from public/assets/images -->
                                        <img
                                            src="{{ asset('assets/images/carrier-dhl-express-znDCym6OOd3q.svg') }}"
                                            alt="DHL Express logo"
                                            class="ss-logo-img"
                                            width="28"
                                            height="20"
                                            loading="lazy" />
                                    </div>
                                    <!-- <div class="ss-logo" aria-hidden="true">
                         <svg width="28" height="20" viewBox="0 0 28 20" xmlns="http://www.w3.org/2000/svg" focusable="false" aria-hidden="true">
                            <rect width="28" height="20" rx="3" fill="#FFF4E6"></rect>
                                <text x="5" y="14" font-size="9" fill="#92400E" font-family="sans-serif">DHL</text>
                                 </svg>
                                 </div> -->

                                    <div class="ss-info-wrap">
                                        <div class="ss-name-row">
                                            <div class="ss-name">DHL Express Worldwide</div>
                                            <div class="ss-price">$42.29 CAD</div>
                                        </div>
                                        <div class="ss-meta-row">
                                            <span class="ss-badge">4 business days</span>
                                            <div class="ss-subtext">Includes prepaid duties, insurance, free package pickup, signature required</div>
                                        </div>

                                        <div class="ss-details" aria-hidden="true">
                                            <ul class="ss-check-list">
                                                <li><span class="ss-checkmark">✓</span> Prepaid duties</li>
                                                <li><span class="ss-checkmark">✓</span> Insurance</li>
                                                <li><span class="ss-checkmark">✓</span> Free package pickup</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </button>

                            <button type="button" role="radio" aria-checked="false" class="ss-option" data-id="xpresspost" data-name="Xpresspost USA" data-price="$48.16 CAD">
                                <div class="ss-grid">
                                    <div class="ss-logo" aria-hidden="true">
                                        <!-- Use Laravel asset() to load the SVG from public/assets/images -->
                                        <img
                                            src="{{ asset('assets/images/carrier-canada-post-BHstWYmP7K60.svg') }}"
                                            alt="DHL Express logo"
                                            class="ss-logo-img"
                                            width="28"
                                            height="20"
                                            loading="lazy" />
                                    </div>

                                    <div class="ss-info-wrap">
                                        <div class="ss-name-row">
                                            <div class="ss-name">Xpresspost USA</div>
                                            <div class="ss-price">$48.16 CAD</div>
                                        </div>
                                        <div class="ss-meta-row">
                                            <span class="ss-badge">2–4 business days</span>
                                            <div class="ss-subtext">Includes tracking and delivery confirmation, insurance (up to $100.00), signature required, prepaid duties</div>
                                        </div>

                                        <div class="ss-details" aria-hidden="true">
                                            <ul class="ss-check-list">
                                                <li><span class="ss-checkmark">✓</span> Tracking and delivery confirmation</li>
                                                <li><span class="ss-checkmark">✓</span> Insurance (up to $100.00)</li>
                                                <li><span class="ss-checkmark">✓</span> Signature required</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT: summary --}}
            <div class="right-col">
                <div class="card summary-card">
                    <div class="card-header">Summary</div>
                    <div class="card-body">
                        <div class="summary-row">
                            <div class="text-muted">Subtotal</div>
                            <div></div>
                        </div>

                        <div class="summary-row">
                            <div class="text-muted">Total</div>
                            <div></div>
                        </div>

                        <div class="summary-row">
                            <div class="text-muted">Billing conversion</div>
                            <div class="text-muted small-muted"></div>
                        </div>

                        <!-- <div class="summary-row" style="border-bottom:0;">
                            <div>
                                <label class="small-muted">Shipping date</label>
                                <select class="form-select form-select-sm">
                                    <option>Today</option>
                                    <option>Tomorrow</option>
                                </select>
                            </div>
                        </div> -->

                        <div class="mt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="emailShipping" checked>
                                <label class="form-check-label small-muted" for="emailShipping">Email shipping information to customers now</label>
                            </div>

                            <!-- <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" id="agreeTos">
                                <label class="form-check-label small-muted" for="agreeTos">I agree to the Shopify Shipping terms of service</label>
                            </div> -->
                        </div>

                        <div class="mt-3">
                            <!-- <button class="btn-buy" disabled title="Buy shipping label (disabled)">Buy shipping label</button> -->
                                           <button type="button" class="btn-buy" onclick="buyShippingLabel()" disabled>
    Buy Shipping Label
</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</main>

@section('admininsertjavascript')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const display = document.getElementById('packageSelectDisplay');
        const dropdown = document.getElementById('packageDropdown');
        const hiddenSelect = document.getElementById('packageSelect');
        if (!display || !dropdown) return;

        const origParent = dropdown.parentNode;
        const origNext = dropdown.nextSibling;
        let isOpen = false;

        function openDropdown() {
            if (isOpen) return;
            isOpen = true;
            dropdown.classList.add('open');
            document.body.appendChild(dropdown);

            dropdown.style.display = 'block';
            // compute and set sensible maxHeight (max 4 visible options, but not exceeding viewport)
            positionDropdown(); // positionDropdown will set maxHeight before showing
            display.setAttribute('aria-expanded', 'true');
            setTimeout(() => dropdown.classList.add('visible'), 10);
        }

        function closeDropdown() {
            if (!isOpen) return;
            isOpen = false;
            dropdown.classList.remove('open', 'visible');
            if (origNext) origParent.insertBefore(dropdown, origNext);
            else origParent.appendChild(dropdown);

            dropdown.style.display = 'none';
            dropdown.style.left = '';
            dropdown.style.top = '';
            dropdown.style.width = '';
            dropdown.style.maxHeight = '';
            display.setAttribute('aria-expanded', 'false');
        }

        function positionDropdown() {
            const rect = display.getBoundingClientRect();
            const scrollX = window.scrollX || window.pageXOffset;
            const scrollY = window.scrollY || window.pageYOffset;

            // set width same as trigger
            dropdown.style.width = Math.max(rect.width, 260) + 'px';

            // Ensure dropdown is visible to measure an option
            dropdown.style.visibility = 'hidden';
            dropdown.style.display = 'block';

            // measure an option height (use first option)
            const firstOpt = dropdown.querySelector('.package-option');
            let optionHeight = 48; // fallback
            if (firstOpt) {
                const r = firstOpt.getBoundingClientRect();
                optionHeight = Math.max(Math.round(r.height), optionHeight);
            }

            // desired visible options (user request)
            const maxVisible = 4;
            const desiredHeight = (optionHeight * maxVisible) + 8; // extra padding
            const viewportAvailable = window.innerHeight - 40; // keep margin
            const finalMax = Math.min(desiredHeight, viewportAvailable);

            // apply maxHeight so dropdown will scroll if options > 4
            dropdown.style.maxHeight = finalMax + 'px';
            dropdown.style.overflow = 'auto';

            dropdown.style.visibility = '';

            // determine open below/above based on available space
            // measure dropdown actual height (bounded by maxHeight)
            const ddHeight = Math.min(dropdown.scrollHeight, finalMax);
            const spaceBelow = window.innerHeight - rect.bottom;

            if (spaceBelow > ddHeight + 12 || rect.top < ddHeight) {
                // open below
                dropdown.style.left = (rect.left + scrollX) + 'px';
                dropdown.style.top = (rect.bottom + scrollY + 8) + 'px';
            } else {
                // open above
                dropdown.style.left = (rect.left + scrollX) + 'px';
                dropdown.style.top = (rect.top + scrollY - ddHeight - 8) + 'px';
            }
        }

        display.addEventListener('click', function(e) {
            e.stopPropagation();
            if (isOpen) closeDropdown();
            else openDropdown();

        });

        display.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDropdown();
                display.focus();
            }
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                if (isOpen) closeDropdown();
                else openDropdown();
            }
        });

        document.addEventListener('click', function(e) {
            if (!isOpen) return;
            if (!display.contains(e.target) && !dropdown.contains(e.target)) {
                closeDropdown();
            }
        }, {
            capture: true
        });

        let repositionTimeout = null;
        ['scroll', 'resize'].forEach(evt => {
            window.addEventListener(evt, function() {
                if (!isOpen) return;
                clearTimeout(repositionTimeout);
                repositionTimeout = setTimeout(positionDropdown, 50);
            }, {
                passive: true
            });
        });

        dropdown.querySelectorAll('.package-option').forEach(function(opt) {
            opt.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdown.querySelectorAll('.package-option').forEach(o => o.classList.remove('selected'));
                opt.classList.add('selected');

                const label = opt.dataset.label || opt.querySelector('.opt-title')?.textContent?.trim() || '';
                const desc = opt.dataset.dim || opt.querySelector('.opt-desc')?.textContent?.trim() || '';
                const w = opt.dataset.weight || opt.dataset.wgrams || '';
                const badgeDim = document.getElementById('badgeDim');
                const badgeWt = document.getElementById('badgeWt');
                const titleEl = document.getElementById('packageTitle');
                const descEl = document.getElementById('packageDesc');

                if (titleEl) titleEl.textContent = label;
                if (descEl) descEl.textContent = desc;
                if (badgeDim) badgeDim.textContent = desc;
                if (badgeWt) badgeWt.textContent = w;

                if (hiddenSelect) {
                    for (let i = 0; i < hiddenSelect.options.length; i++) {
                        if ((hiddenSelect.options[i].text || '').indexOf(label) !== -1) {
                            hiddenSelect.selectedIndex = i;
                            break;
                        }
                    }
                }

                closeDropdown();
            requestRates();

                const ev = new Event('packageChanged', {
                    bubbles: true
                });
                display.dispatchEvent(ev);
            });
        });

        display.closePackageDropdown = closeDropdown;

        // ---------- Helpers ----------
        function getRowQty(row) {
            const qDiv = row.querySelector('.qty-text');
            if (!qDiv) return 1;
            const v = parseInt(qDiv.textContent.trim(), 10);
            return isNaN(v) ? 1 : v;
        }

        function getRowWeightGrams(row) {
            // find either weight-field (single) or bundle-weight-field
            const wField = row.querySelector('input.weight-field, input.bundle-weight-field');
            if (!wField) return 0;
            let val = parseFloat(wField.value);
            if (isNaN(val) || val < 0) val = 0;
            const unitSel = row.querySelector('select.unit-select');
            const unit = unitSel ? unitSel.value : 'g';
            return unit === 'kg' ? (val * 1000) : val;
        }

        function packageWeightGrams() {
            // first try reading dataset from our custom display
            const display = document.getElementById('packageSelectDisplay');

            const ds = display?.dataset?.wgrams;
            if (typeof ds !== 'undefined' && ds !== null) {
                let g = parseFloat(ds);
                if (!isNaN(g)) return g;
            }

            // fallback: check hidden select's selected option text for numbers (legacy)
            const sel = document.getElementById('packageSelect');
            if (!sel) return 0;
            const txt = sel.options[sel.selectedIndex].text || '';
            const m = txt.match(/([\d.,]+)\s*(kg|g)\b/i);
            if (!m) return 0;
            let num = parseFloat(m[1].replace(',', '.'));
            if (isNaN(num)) return 0;
            return (m[2].toLowerCase() === 'kg') ? (num * 1000) : num;
        }

        function formatForUnit(grams, unit) {
            if (unit === 'kg') {
                return (grams / 1000).toFixed(2);
            }
            return Math.round(grams).toString();
        }

        // ---------- Recalc ----------
        let recalcTimeout = null;

        function recalcTotalWeight() {
            clearTimeout(recalcTimeout);
            recalcTimeout = setTimeout(function() {
                const rows = document.querySelectorAll('.items-body .item-row');
                let sum = 0;
                rows.forEach(function(r) {
                    const qty = getRowQty(r) || 1;
                    const perUnitGrams = getRowWeightGrams(r) || 0;
                    sum += perUnitGrams * qty;
                });

                // add package grams
                sum += packageWeightGrams();

                const totalUnit = document.getElementById('totalUnitSelect') ? document.getElementById('totalUnitSelect').value : 'g';
                const totalInput = document.getElementById('totalWeightInput');
                if (totalInput) {
                    if (totalUnit === 'kg') {
                        totalInput.value = (sum / 1000).toFixed(2);
                    } else {
                        totalInput.value = Math.round(sum);
                    }
                }
                
                const hint = document.getElementById('totalWeightHint');
                if (hint) hint.textContent = Math.round(sum) + ' g';
            }, 80);
        }


        // ---------- Bundle dropdown handler ----------
        document.querySelectorAll('.bundleProductSelect').forEach(function(sel) {
            function handleChange() {
                const index = sel.dataset.index;
                const opt = sel.options[sel.selectedIndex];
                const img = opt.dataset.image || '';
                const weight = opt.dataset.weight || 0;
                const size = opt.dataset.size || '';
                const colorName = opt.getAttribute('data-color-name') || opt.dataset.colorName || '';
                const colorHex = opt.getAttribute('data-color-hex') || opt.dataset.colorHex || '';

                // image
                const imgEl = document.getElementById('bundleImage' + index);
                if (imgEl && img) imgEl.src = img;

                // update weight field in this row (if present)
                const wField = document.querySelector('.bundle-weight-field[data-index="' + index + '"]');
                if (wField) wField.value = parseFloat(weight || 0).toFixed(0);

                // update variant display element
                const variantEl = document.getElementById('bundleVariant' + index);
                if (variantEl) {
                    const parts = [];
                    if (size) parts.push(size);
                    if (colorName) parts.push(colorName);
                    const text = parts.join(' / ');
                    if (text) {
                        if (colorHex) {
                            variantEl.innerHTML = '<span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:' + colorHex + ';margin-right:6px;vertical-align:middle;border:1px solid rgba(0,0,0,0.06)"></span> ' + text;
                        } else {
                            variantEl.textContent = text;
                        }
                    } else {
                        variantEl.textContent = '';
                    }
                }

                // trigger a recalc (allow other handlers to run first)
                setTimeout(recalcTotalWeight, 90);
            }

            sel.addEventListener('change', handleChange);
            // initial trigger
            handleChange();
        });
// ---------- Bangle dropdown handler ----------
document.querySelectorAll('.bangleProductSelect').forEach(function(sel) {
    function handleChange() {
        const index = sel.dataset.index;
        const opt = sel.options[sel.selectedIndex];
        const img = opt.dataset.image || '';
        const weight = opt.dataset.weight || 0;
        const size = opt.dataset.size || '';
        const colorName = opt.getAttribute('data-color-name') || opt.dataset.colorName || '';
        const colorHex = opt.getAttribute('data-color-hex') || opt.dataset.colorHex || '';

        // image
        const imgEl = document.getElementById('bangleImage' + index);
        if (imgEl && img) imgEl.src = img;

        // update weight field in this row (if present)
        const wField = document.querySelector('.bangle-weight-field[data-index="' + index + '"]');
        if (wField) wField.value = parseFloat(weight || 0).toFixed(0);

        // update variant display element
        const variantEl = document.getElementById('bangleVariant' + index);
        if (variantEl) {
            const parts = [];
            if (size) parts.push(size);
            if (colorName) parts.push(colorName);
            const text = parts.join(' / ');
            if (text) {
                if (colorHex) {
                    variantEl.innerHTML = '<span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:' + colorHex + ';margin-right:6px;vertical-align:middle;border:1px solid rgba(0,0,0,0.06)"></span> ' + text;
                } else {
                    variantEl.textContent = text;
                }
            } else {
                variantEl.textContent = '';
            }
        }

        // trigger a recalc (allow other handlers to run first)
        setTimeout(recalcTotalWeight, 90);
    }

    sel.addEventListener('change', handleChange);
    // initial trigger
    handleChange();
});

        // ---------- Event wiring: item weight/unit/package changes ----------
        // Any change to weight inputs, unit selects or package select recalculates total
        document.addEventListener('input', function(e) {
            if (e.target.matches('input.weight-field, input.bundle-weight-field')) {
                recalcTotalWeight();
            }
        });
        document.addEventListener('change', function(e) {
            if (e.target.matches('select.unit-select') || e.target.matches('#packageSelect')) {
                // if hidden select changed externally, update display too
                if (e.target.matches('#packageSelect')) {
                    const val = e.target.value;
                    const matching = options.find(o => (o.getAttribute('data-label') || o.dataset.label) === val);
                    if (matching) setSelectedPackage(matching);
                }
                recalcTotalWeight();
            }
        });

        // total unit select: convert displayed value between units when toggled
        const totalUnitSel = document.getElementById('totalUnitSelect');
        if (totalUnitSel) {
            totalUnitSel.dataset.prev = totalUnitSel.value || 'g';
            totalUnitSel.addEventListener('change', function() {
                const prev = totalUnitSel.dataset.prev || 'g';
                const cur = totalUnitSel.value || 'g';
                totalUnitSel.dataset.prev = cur;
                const totalInput = document.getElementById('totalWeightInput');
                let val = parseFloat(totalInput.value);
                if (isNaN(val)) val = 0;
                if (prev === 'g' && cur === 'kg') {
                    totalInput.value = (val / 1000).toFixed(2);
                } else if (prev === 'kg' && cur === 'g') {
                    totalInput.value = Math.round(val * 1000);
                }
                recalcTotalWeight();
            });
        }

        // when user edits total manually, update hint to grams for clarity
        const totalInput = document.getElementById('totalWeightInput');
        if (totalInput) {
            totalInput.addEventListener('input', function() {
                const unit = (document.getElementById('totalUnitSelect') || {
                    value: 'g'
                }).value;
                let val = parseFloat(totalInput.value);
                if (isNaN(val)) {
                    document.getElementById('totalWeightHint').textContent = '';
                    return;
                }
                const grams = unit === 'kg' ? Math.round(val * 1000) : Math.round(val);
                const hint = document.getElementById('totalWeightHint');
                if (hint) hint.textContent = grams + ' g';
            });
        }

        // initial calculation
        recalcTotalWeight();

        // Save weight checkbox placeholder (no backend action now)
        document.getElementById('saveWeight')?.addEventListener('change', function() {
            /* no-op */
        });
    });
</script>
<script>
(function() {
    const container = document.querySelector('.shipping-service-card .ss-options');
    if (!container) return;

    const options = Array.from(container.querySelectorAll('.ss-option'));
    const hiddenInput = document.getElementById('selectedShippingService');

    // --- Summary elements ---
    const summaryCard = document.querySelector('.summary-card');
    const subtotalEl = summaryCard?.querySelector('.summary-row:nth-child(1) div:last-child');
    const totalEl = summaryCard?.querySelector('.summary-row:nth-child(2) div:last-child');
    const conversionEl = summaryCard?.querySelector('.summary-row:nth-child(3) div:last-child');
    const buyBtn = summaryCard?.querySelector('.btn-buy');

    function parseRateData(opt) {
        // You should attach full rate data in data attributes, e.g.:
        // data-rate="13.09" data-gst="0" data-pst="0" data-hst="0" data-qst="0" data-duty="0" data-duty-tax="0" data-total="13.09" data-currency="CAD"
        return {
            rate: parseFloat(opt.dataset.rate || 0),
            gst: parseFloat(opt.dataset.gst || 0),
            pst: parseFloat(opt.dataset.pst || 0),
            hst: parseFloat(opt.dataset.hst || 0),
            qst: parseFloat(opt.dataset.qst || 0),
            duty: parseFloat(opt.dataset.duty || 0),
            duty_tax: parseFloat(opt.dataset.dutyTax || 0),
            total: parseFloat(opt.dataset.total || 0),
            currency: opt.dataset.currency || "CAD",
        };
    }

    function formatCurrency(amount, currency) {
        return `${amount.toFixed(2)} ${currency}`;
    }

    function updateSummary(opt) {
        const data = parseRateData(opt);
        const {
            rate, gst, pst, hst, qst, duty, duty_tax, total, currency
        } = data;

        const taxSum = gst + pst + hst + qst + duty + duty_tax;
        const finalTotal = +(rate + taxSum).toFixed(2);

        // Update Summary Fields
        if (subtotalEl) subtotalEl.textContent = formatCurrency(rate, currency);
        if (totalEl) totalEl.textContent = formatCurrency(finalTotal, currency);
        if (conversionEl) conversionEl.textContent = formatCurrency(total, currency);

        hiddenInput.value = opt.dataset.name || "";
        if (buyBtn) buyBtn.removeAttribute('disabled');
    }

    function selectOption(opt) {
        options.forEach(o => {
            const is = o === opt;
            o.classList.toggle('ss-selected', is);
            o.setAttribute('aria-checked', is ? 'true' : 'false');
            const details = o.querySelector('.ss-details');
            if (details) details.setAttribute('aria-hidden', is ? 'false' : 'true');
        });

        updateSummary(opt);
        opt.scrollIntoView({ block: 'nearest', inline: 'nearest' });
    }

    // --- Default select first one ---
    let initially = options.find(o => o.classList.contains('ss-selected')) || options[0];
    if (initially) selectOption(initially);

    // --- Click handling ---
    container.addEventListener('click', e => {
        const btn = e.target.closest('.ss-option');
        if (!btn) return;
        selectOption(btn);
    });

    // --- Keyboard navigation ---
    container.addEventListener('keydown', e => {
        const active = document.activeElement.closest('.ss-option');
        if (!active) return;

        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            selectOption(active);
        } else if (['ArrowDown', 'ArrowRight'].includes(e.key)) {
            e.preventDefault();
            const idx = (options.indexOf(active) + 1) % options.length;
            options[idx].focus();
        } else if (['ArrowUp', 'ArrowLeft'].includes(e.key)) {
            e.preventDefault();
            const idx = (options.indexOf(active) - 1 + options.length) % options.length;
            options[idx].focus();
        }
    });

    // --- Accessibility ---
    options.forEach(o => o.setAttribute('tabindex', '0'));
})();
</script>

<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&libraries=places"></script>
<script>
(function(){
    let autocomplete;

    function getComponent(components, type, preferShort = false) {
        const comp = components.find(c => c.types.includes(type));
        if (!comp) return '';
        return preferShort && comp.short_name ? comp.short_name : (comp.long_name || comp.short_name);
    }

    function initAutocomplete() {
        const input = document.getElementById("autocomplete");
        if (!input) return;

        // prevent multiple inits
        if (autocomplete) {
            try { google.maps.event.clearInstanceListeners(autocomplete); } catch(e) {}
            autocomplete = null;
        }

        autocomplete = new google.maps.places.Autocomplete(input, {
            fields: ['address_components','formatted_address','geometry','place_id',],
        });

        autocomplete.addListener("place_changed", fillInAddress);
    }
async function fillInAddress() {
    if (!autocomplete) return;
    const place = autocomplete.getPlace();
    console.log('Selected Place:', place);
    const comp = place.address_components || [];

    // Extract main fields
    const countryLong = getComponent(comp, 'country', false);
    const countryIso = getComponent(comp, 'country', true);
    const stateLong = getComponent(comp, 'administrative_area_level_1', false);
    const stateCode = getComponent(comp, 'administrative_area_level_1', true);
    const city = getComponent(comp, 'locality', false) || getComponent(comp, 'administrative_area_level_2', false);
    
    let postal = getComponent(comp, 'postal_code', false);
console.log('Selected Adress:', comp['postal_code'] || '');
    // Fallback: get postal code by reverse geocoding if missing
  if (!postal && place.geometry) {
    const lat = place.geometry.location.lat();
    const lng = place.geometry.location.lng();

    try {
        // Try Google Reverse Geocoding first
        const googleRes = await fetch(
            `https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lng}&key={{ config('services.google.maps_api_key') }}`
        );
        const googleData = await googleRes.json();

        if (googleData.results?.length) {
            for (const r of googleData.results) {
                const postalComp = r.address_components.find(c => c.types.includes('postal_code'));
                if (postalComp) {
                    postal = postalComp.long_name;
                    console.log('✅ Found postal code via Google reverse geocoding:', postal);
                    break;
                }
            }
        }

        // 🔸 If still no postal code, use Nominatim (OpenStreetMap)
        if (!postal) {
            const nominatimRes = await fetch(
                `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`,
                { headers: { 'User-Agent': 'MyLaravelApp/1.0 (tahir@example.com)' } }
            );
            const nominatimData = await nominatimRes.json();

            if (nominatimData?.address?.postcode) {
                postal = nominatimData.address.postcode;
                console.log('✅ Found postal code via Nominatim:', postal);
            } else {
                console.warn('⚠️ No postal code found via Nominatim either.');
            }
        }
    } catch (err) {
        console.error('Postal code lookup failed:', err);
    }
}


    const finalAddress = {
        city: city || '',
        province_code: stateCode || '',
        postal_code: postal || '',
        country_code: countryIso || ''
    };
   console.log('Latitude:', place.geometry.location.lat());
    console.log('Longitude:', place.geometry.location.lng());
    console.log("📦 Final destination:", finalAddress);

    // Fill your form fields
    document.getElementById("city").value = finalAddress.city;
    document.getElementById("state_code").value = finalAddress.province_code;
    document.getElementById("zip").value = finalAddress.postal_code;
    document.getElementById("country_iso").value = finalAddress.country_code;
    document.getElementById("address").value = place.formatted_address;
    document.getElementById("latitude").value = place.geometry.location.lat();
    document.getElementById("longitude").value = place.geometry.location.lng();
    document.getElementById("country").value = countryLong;
    document.getElementById("state").value = stateLong;
    document.getElementById("autocomplete").value = place.formatted_address;
    document.getElementById("formatted_address").value = place.formatted_address;

    // (Optional) store as JSON if you need in hidden field
    const destField = document.getElementById("to_address_json");
    if (destField) destField.value = JSON.stringify(finalAddress);
}



    const editBtn = document.getElementById('editAddressBtn');
    if (editBtn) {
        editBtn.addEventListener('click', function() {
            // prefer dataset attributes if present; use getAttribute to be safe with underscores
            const fields = ['first_name','last_name','address','city','state','country','zip','phone','country_iso','state_code','formatted_address','latitude','longitude','place_id','area','sub_area'];
            fields.forEach(id => {
                const el = document.getElementById(id);
                if (!el) return;
                // try data- attribute: data-first_name etc.
                const attr = this.getAttribute('data-' + id) || this.getAttribute('data-' + id.replace('_','-')) || '';
                if (attr) el.value = attr;
                // if not, leave existing value (so previously filled values remain)
            });
            // clear autocomplete input (so place_changed triggers next time)
            const ac = document.getElementById('autocomplete');
            if (ac) ac.value = document.getElementById('formatted_address').value || document.getElementById('address').value || '';
        });
    }

    // Init Google Autocomplete on modal open
    document.addEventListener('shown.bs.modal', function(event) {
        if (event.target && event.target.id === 'editAddressModal') {
            initAutocomplete();
        }
    });

    // Save button -> AJAX
    const saveBtn = document.getElementById("saveAddressBtn");
    if (saveBtn) {
        saveBtn.addEventListener("click", function() {
            const data = {
                _token: "{{ csrf_token() }}",
                order_id: document.getElementById("order_id").value,
                first_name: document.getElementById("first_name").value,
                last_name: document.getElementById("last_name").value,
                phone: document.getElementById("phone").value,
                email: document.getElementById("email") ? document.getElementById("email").value : '',
                address: document.getElementById("address").value,
                city: document.getElementById("city").value,
                state: document.getElementById("state").value,
                state_code: document.getElementById("state_code").value || '',
                country: document.getElementById("country").value,
                country_iso: document.getElementById("country_iso").value || '',
                postal_code: document.getElementById("zip").value,
                latitude: document.getElementById("latitude").value,
                longitude: document.getElementById("longitude").value,
                place_id: document.getElementById("place_id").value,
                area: document.getElementById("area").value,
                sub_area: document.getElementById("sub_area").value,
                formatted_address: document.getElementById("formatted_address").value || ''
            };

            console.log("📤 Sending to Laravel:", data);

            $.ajax({
                url: "{{ route('update-address') }}",
                method: "POST",
                data: data,
                success: function(res) {
                    console.log("✅ Success:", res);
                    $('#editAddressModal').modal('hide');
                    document.getElementById('latitude').value = res.data.delivery_meta_data.latitude;
                    document.getElementById('longitude').value = res.data.delivery_meta_data.longitude;
                    // toastr.success(res.message);

                    const saved = res.data.delivery_meta_data || {};
                    console.log('📦 Saved Address:', saved);
                    const form = $('#editAddressForm');

                    const firstName = form.find('#first_name').val();
                    const lastName = form.find('#last_name').val();
                    const phone = form.find('#phone').val();

                    // Build one-line address
                    const oneLine = [
                        saved.address || saved.street || '',
                        saved.city || '',
                        saved.state_province || saved.state || '',
                        saved.country || ''
                    ].filter(Boolean).join(', ');

                    // --- Update the UI dynamically ---
                    const addressBlock = $('.address-block');
                    addressBlock.html(`
                        ${oneLine ? `<p class="mb-1">${oneLine}</p>` : ''}
                        ${saved.address ? `<p class="mb-1 text-muted">${saved.address}</p>` : ''}
                        ${saved.city ? `<p class="mb-1 text-muted">${saved.city}${saved.state_province ? ', ' + saved.state_province : ''}</p>` : ''}
                        ${(saved.country || saved.country_iso) ? `<p class="mb-0 text-muted">${saved.country || ''}${saved.country_iso ? ' (' + saved.country_iso + ')' : ''}</p>` : ''}
                        ${(firstName || lastName) ? `<p class="mb-1"><strong>${firstName} ${lastName}</strong></p>` : ''}
                        ${phone ? `<p class="mb-0 text-muted">${phone}</p>` : ''}
                    `);

                    // update edit button data attributes (so modal prefill works next time)
                    const eb = document.getElementById('editAddressBtn');
                    if (eb) {
                        eb.setAttribute('data-address', saved.address || saved.street || '');
                        eb.setAttribute('data-city', saved.city || '');
                        eb.setAttribute('data-state', saved.state_province || saved.state || '');
                        eb.setAttribute('data-state_code', saved.province_code || saved.state_code || '');
                        eb.setAttribute('data-country', saved.country || '');
                        eb.setAttribute('data-country_iso', saved.country_iso || '');
                        eb.setAttribute('data-zip', saved.postal_code || '');
                        eb.setAttribute('data-first_name', firstName || '');
                        eb.setAttribute('data-last_name', lastName || '');
                        eb.setAttribute('data-phone', phone || '');
                        eb.setAttribute('data-place_id', saved.place_id || '');
                        eb.setAttribute('data-area', saved.area || '');
                        eb.setAttribute('data-sub_area', saved.sub_area || '');
                        eb.setAttribute('data-formatted_address', saved.formatted_address || '');
                    }
                      requestRates();
                },

                error: function(xhr) {
                    console.error("❌ Error:", xhr.responseJSON || xhr.responseText);
                    toastr.error(xhr.responseJSON?.message || "Update failed!");
                }
            });
        });
    }
})();
</script>



<script>
    const btnLoad = document.querySelector('#loadShippingRatesBtn'); // create a button or call automatically
    const container = document.querySelector('.shipping-service-card .ss-options');
    const selDesc = document.querySelector('.ss-selected-by .ss-sel-desc');
    const hiddenInput = document.getElementById('selectedShippingService');
    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    function collectItems() {
        const rows = Array.from(document.querySelectorAll('.items-body .item-row'));
        const items = rows.map(row => {
            const desc = (row.querySelector('.prod-name') && row.querySelector('.prod-name').textContent.trim()) || 'Item';
            const qty = Number((row.querySelector('.col-qty') && row.querySelector('.col-qty').textContent.trim()) || 1);
            // weight field may be input inside .col-weight
            let weightInput = row.querySelector('.weight-field') || row.querySelector('.bundle-weight-field') || row.querySelector('.bangle-weight-field');
            let weight = weightInput ? Number(weightInput.value || 0) : 0;
            // assume currency CAD and a default value per item — ideally you have price in DOM/data attributes
            let value = Number(row.dataset.price || (row.querySelector('.prod-price') && row.querySelector('.prod-price').textContent.replace(/[^0-9.]/g,'')) || 1);

            return {
                description: desc,
                quantity: qty,
                value: value,
                currency: "{{ $order->currency ?? 'CAD' }}",
                country_of_origin: 'CA',
                hs_code: '7117907500' 
            };
        });
        return items;
    }

    function collectToAddress() {
       const name = (document.querySelector('#first_name')?.value || '{{ $firstName ?? '' }}') + ' ' + (document.querySelector('#last_name')?.value || '{{ $lastName ?? '' }}');
      console.log('{{ $addr["address"] ?? "" }}');
    //   console.log('lat:', place.geometry.location.lat());
    //   console.log('lng:', place.geometry.location.lng());
       return {
            name: name.trim(),
            address1: document.querySelector('#address')?.value || '{{ $addr["address"] ?? "" }}',
            city: document.querySelector('#city')?.value || '{{ $addr["city"] ?? "" }}',
            province_code: document.querySelector('#state_code')?.value || '{{ $addr["province_code"] ?? "" }}',
            postal_code: document.querySelector('#zip')?.value || '{{ $addr["postcode"] ?? $addr["postal_code"] ?? "" }}' ,
            country_code: document.querySelector('#country_iso')?.value || '{{ $addr["country_iso"] ?? $addr["country"] ?? "" }}',
            phone: document.querySelector('#phone')?.value || '{{ $phone ?? "" }}',
            email: '{{ $order->email ?? "" }}',
            is_residential: true,
            lat:document.querySelector('#latitude')?.value || '{{ $addr["latitude"] ?? "" }}',
            lng:document.querySelector('#longitude')?.value || '{{ $addr["longitude"] ?? "" }}'
        };
    }

function collectPackage() {
    const sel = document.querySelector('#packageDropdown .package-option[aria-selected="true"]')
        || document.querySelector('#packageDropdown .package-option.selected')
        || document.querySelector('#packageDropdown .package-option'); // fallback

    if (!sel) {
        console.warn("⚠️ No package selected");
        return { length: 9, width: 12, height: 1, size_unit: 'cm', package_type: 'Parcel' };
    }

    // Parse "30 × 20 × 15 cm" → ["30", "20", "15"]
    const dimText = sel.dataset.dim || '';
    console.log('📦 Selected Package:', dimText);
    const numbers = dimText.match(/\d+(\.\d+)?/g) || [];
    const unit = dimText.includes('in') ? 'in' : 'cm';

    const label = sel.dataset.label || '';
    const typeMap = {
        'Small flat': 'Parcel',
        'Sample box': 'Parcel',
        'Medium box': 'Parcel',
        'Large box': 'Parcel',
        'Custom box': 'Parcel'
    };

    return {
        length: Number(numbers[0] || 9),
        width: Number(numbers[1] || 12),
        height: Number(numbers[2] || 1),
        size_unit: unit,
        package_type: typeMap[label] || 'Parcel'
    };
}



 function collectWeight() {
    const selected = document.querySelector('#packageDropdown .package-option[aria-selected="true"]');
    let grams = selected ? Number(selected.dataset.wgrams || 0) : 0;

    // If no predefined package weight, fall back to manual input
    if (grams === 0) {
        const input = document.getElementById('totalWeightInput');
        const unitSelect = document.getElementById('totalUnitSelect');
        let value = Number(input?.value || 100);
        const unit = unitSelect?.value || 'g';

        // Convert manual input to grams
        if (unit === 'kg') {
            grams = value * 1000;
        } else {
            grams = value;
        }
    }

    // Convert grams → pounds (1 lb = 453.592 g)
    const lbs = +(grams / 453.592).toFixed(2);

    return { weight: lbs > 0 ? lbs : 0.5, weight_unit: 'lbs' };
}



    async function requestRates() {
    if (!container) return;
    container.innerHTML = '<div class="loading">Loading shipping options…</div>';

    const payload = {};
    payload.to_address = collectToAddress();
    payload.return_address = null;
    const pkg = collectPackage();
    const wt = collectWeight();
    payload.weight_unit = wt.weight_unit;
    payload.weight = wt.weight;
    payload.length = pkg.length;
    payload.width = pkg.width;
    payload.height = pkg.height;
    payload.size_unit = pkg.size_unit;
    payload.package_type = pkg.package_type;
    payload.items = collectItems();
    payload.signature_confirmation = false;
    payload.insured = false;
    // payload.order_id= '{{ $order->id }}';

    try {
        const res = await fetch("{{ route('shipping.rates.post') }}", {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf
            },
            body: JSON.stringify(payload)
        });

        const data = await res.json();
        if (!data.success || !data.rates?.length) {
            container.innerHTML = '<div class="error">No shipping options found.</div>';
            return;
        }

        // --- Build HTML for rates ---
        const optionsHtml = data.rates.map((rate, i) => {
            const selected = i === 0 ? 'ss-selected' : '';
            const ariaChecked = i === 0 ? 'true' : 'false';
            const detailsHidden = i === 0 ? 'false' : 'true';
            const badge = rate.delivery_days ? `<span class="ss-badge">${rate.delivery_days} days</span>` : '';

            return `
                <button type="button" role="radio" aria-checked="${ariaChecked}"
                    class="ss-option ${selected}"
                    data-id="${rate.postage_type_id || ''}"
                    data-name="${rate.postage_type || ''}"
                    data-rate="${rate.rate || 0}"
                    data-gst="${rate.gst || 0}"
                    data-pst="${rate.pst || 0}"
                    data-hst="${rate.hst || 0}"
                    data-qst="${rate.qst || 0}"
                    data-duty="${rate.duty || 0}"
                    data-duty-tax="${rate.duty_tax || 0}"
                    data-total="${rate.total || 0}"
                    data-currency="${rate.currency || 'CAD'}">
                    <div class="ss-grid">
                        <div class="ss-logo" aria-hidden="true">
                            <img src="{{ asset('assets/images/carrier-canada-post-BHstWYmP7K60.svg') }}"
                                 alt="Carrier logo" class="ss-logo-img"
                                 width="28" height="20" loading="lazy" />
                        </div>
                        <div class="ss-info-wrap">
                            <div class="ss-name-row">
                                <div class="ss-name">${rate.postage_type}</div>
                                <div class="ss-price">${rate.total.toFixed(2)} ${rate.currency}</div>
                            </div>
                            <div class="ss-meta-row">
                                ${badge}
                                <div class="ss-subtext">
                                    ${rate.trackable ? 'Includes tracking' : 'No tracking'}
                                    ${rate.add_ons?.length ? ', ' + rate.add_ons.map(a => a.name).join(', ') : ''}
                                </div>
                            </div>
                            <div class="ss-details" aria-hidden="${detailsHidden}">
                                <ul class="ss-check-list">
                                    ${rate.trackable ? '<li><span class="ss-checkmark">✓</span> Tracking</li>' : ''}
                                    ${rate.add_ons?.map(a => `<li><span class="ss-checkmark">✓</span> ${a.name}</li>`).join('') || ''}
                                </ul>
                            </div>
                        </div>
                    </div>
                </button>`;
        }).join('');

        container.innerHTML = optionsHtml;

        // --- Initialize selection + summary updates ---
        initShippingSelector();

        // --- Automatically select first rate ---
        const firstRate = data.rates[0];
        if (firstRate) {
            window.selectedRate = firstRate;
            updateSummaryCard(firstRate);
            enableBuyButton(firstRate);
        }

    } catch (err) {
        console.error(err);
        container.innerHTML = '<div class="error">Failed to load shipping options.</div>';
    }
}

/**
 * Updates the Summary Card when a rate is selected
 */
function updateSummaryCard(rate) {
    const subtotalEl = document.querySelector('.summary-row:nth-child(1) div:last-child');
    const totalEl = document.querySelector('.summary-row:nth-child(2) div:last-child');
    const billingEl = document.querySelector('.summary-row:nth-child(3) div:last-child');

    const currency = rate.currency || 'CAD';
    const subtotal = parseFloat(rate.rate || 0);
    const tax = (parseFloat(rate.gst || 0) + parseFloat(rate.pst || 0) + parseFloat(rate.hst || 0) + parseFloat(rate.qst || 0) + parseFloat(rate.duty || 0) + parseFloat(rate.duty_tax || 0));
    const total = parseFloat(rate.total || subtotal + tax);

    subtotalEl.textContent = `${subtotal.toFixed(2)} ${currency}`;
    totalEl.textContent = `${(subtotal + tax).toFixed(2)} ${currency}`;
    billingEl.textContent = `${total.toFixed(2)} ${currency}`;
}

/**
 * Enable the Buy Label button and store selected rate
 */
function enableBuyButton(rate) {
    const btn = document.querySelector('.btn-buy');
    btn.disabled = false;
    btn.title = `Buy ${rate.postage_type} Label — ${rate.total.toFixed(2)} ${rate.currency}`;
    window.selectedRate = rate;
}
document.addEventListener('DOMContentLoaded', function () {

    requestRates();
});
function initShippingSelector() {
    const container = document.querySelector('.shipping-service-card .ss-options');
    if (!container) return;

    const options = Array.from(container.querySelectorAll('.ss-option'));
    const hiddenInput = document.getElementById('selectedShippingService');

    function selectOption(opt) {
        options.forEach(o => {
            const isSelected = o === opt;
            o.classList.toggle('ss-selected', isSelected);
            o.setAttribute('aria-checked', isSelected ? 'true' : 'false');
            const details = o.querySelector('.ss-details');
            if (details) details.setAttribute('aria-hidden', isSelected ? 'false' : 'true');
        });

        // Update hidden input
        if (hiddenInput) {
            const name = opt.dataset.name || opt.getAttribute('data-name') || '';
            hiddenInput.value = name;
        }

        // 🔹 Build selected rate object from button dataset
        const selectedRate = {
            postage_type_id: opt.dataset.id,
            postage_type: opt.dataset.name,
            rate: parseFloat(opt.dataset.rate || 0),
            gst: parseFloat(opt.dataset.gst || 0),
            pst: parseFloat(opt.dataset.pst || 0),
            hst: parseFloat(opt.dataset.hst || 0),
            qst: parseFloat(opt.dataset.qst || 0),
            duty: parseFloat(opt.dataset.duty || 0),
            duty_tax: parseFloat(opt.dataset.dutyTax || 0),
            total: parseFloat(opt.dataset.total || 0),
            currency: opt.dataset.currency || 'CAD'
        };

        // 🔹 Update globals + UI
        window.selectedRate = selectedRate;
        updateSummaryCard(selectedRate);
        enableBuyButton(selectedRate);
    }

    // Default select first one
    if (options.length > 0) selectOption(options[0]);

    // Click handler
    container.addEventListener('click', e => {
        const btn = e.target.closest('.ss-option');
        if (btn) selectOption(btn);
    });

    // Keyboard navigation
    container.addEventListener('keydown', e => {
        const active = document.activeElement.closest('.ss-option');
        if (!active) return;
        const index = options.indexOf(active);
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            selectOption(active);
        } else if (['ArrowDown', 'ArrowRight'].includes(e.key)) {
            e.preventDefault();
            options[(index + 1) % options.length].focus();
        } else if (['ArrowUp', 'ArrowLeft'].includes(e.key)) {
            e.preventDefault();
            options[(index - 1 + options.length) % options.length].focus();
        }
    });

    // Make each focusable
    options.forEach(o => o.setAttribute('tabindex', '0'));
}

/**
 * Handle Buy Label button click
 */
async function buyShippingLabel() {
    const btn = document.querySelector('.btn-buy');
    if (!btn || !window.selectedRate) {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Please select a shipping service first.',
      })
        return;
    }

    btn.disabled = true;
    btn.textContent = 'Buying label...';

    try {
        // 📨 Reuse your helper functions
        const toAddr = collectToAddress();
        const pkg = collectPackage();
        const wt = collectWeight();
        const items = collectItems();

        const payload = {
            to_address: toAddr,
            weight: wt.weight,
            weight_unit: wt.weight_unit,
            length: pkg.length,
            width: pkg.width,
            height: pkg.height,
            size_unit: pkg.size_unit,
            package_type: pkg.package_type,
            package_contents: 'Jewellery',
            items: items,
            postage_type: window.selectedRate.postage_type || window.selectedRate.postage_type_id || '',
    order_id: '{{ $order->id }}'
        };

        console.log('📤 Sending BuyLabel payload:', payload);

        const res = await fetch("{{ route('buy.shipping.rates.post') }}", {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf
            },
            body: JSON.stringify(payload)
        });

        const data = await res.json();
        console.log('📦 BuyLabel response:', data);

        if (!data.success) {
            const errMsg = Array.isArray(data.errors)
                ? data.errors.join(', ')
                : (typeof data.errors === 'string' ? data.errors : 'Label creation failed');
            throw new Error(errMsg);
        }

        btn.textContent = 'Label Purchased ✅';
     Swal.fire({
    icon: 'success',
    title: 'Label Created!',
    text: '✅ Shipping label created successfully!',
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'OK'
});
} catch (err) {
    console.error('❌ BuyLabel Error:', err);
    Swal.fire({
        icon: 'error',
        title: 'Label Creation Failed',
        text: err.message || 'Something went wrong while buying the label.',
        confirmButtonColor: '#d33',
        confirmButtonText: 'Try Again'
    });
    btn.textContent = 'Buy Label';
} finally {
    btn.disabled = false;
}

}


</script>



@endsection