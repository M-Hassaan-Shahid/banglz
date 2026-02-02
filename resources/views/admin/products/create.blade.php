@extends('components.layouts.admin-default')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<!-- Croppie (replacement for CropperJS) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" />

<style>
    #is_pre_order {
    display: none !important;
}
label[for="is_pre_order"] {
    display: none !important;
}

    .edit-image-btn {
        bottom: 35px !important;
        left: 67px !important;
    }

    /* =======================
   Bangles rows — COMPLETE
   ======================= */

    /* Container spacing: horizontal breathing room */
    #bangles_rows_container {
        padding-left: 1rem;
        padding-right: 1rem;
        box-sizing: border-box;
    }

    /* Row base: 4 columns first row, remaining on second row */
    .bangles_row {
        display: grid !important;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.5rem;
        align-items: center;
        position: relative !important;
        /* positioning context for absolute button */
        overflow: visible !important;
        /* ensure absolutely positioned button is not clipped */
        /* Reserve left padding so button doesn't overlap the first control */
        padding: 0.9rem 1rem 0.6rem 0.75rem;
        /* top right bottom left */
        margin: 0 0.75rem 0.75rem;
        /* horizontal spacing from container edges */
        border: 1px solid #e9ecef;
        border-radius: 8px;
        background: #f7f7f8;
        box-sizing: border-box;
    }

    /* Ensure bootstrap .col-* children behave inside the grid */
    .bangles_row>[class*="col-"] {
        width: 100%;
        min-width: 0;
        /* prevent overflow of long values */
    }

    /* Form controls fill the grid cell */
    .bangles_row .form-control {
        width: 100%;
        box-sizing: border-box;
    }

    /* If the remove button is inside the wrapper with d-flex align-items-center
   (your markup uses: <div class="col-md-1 d-flex align-items-center">),
   remove that wrapper from the grid flow and pin it top-left */
    .bangles_row>.d-flex.align-items-center {
        position: absolute !important;
        left: 12px !important;
        top: 12px !important;
        width: 34px !important;
        height: 34px !important;
        padding: 0 !important;
        margin: 0 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        z-index: 9999 !important;
        pointer-events: auto !important;
        background: transparent !important;
        box-sizing: content-box !important;
    }

    .bangles_row {
        position: relative;
        /* make this the anchor */
    }

    /* Style the actual remove button (keeps btn-danger but forces size/shape) */
    .bangles_row .remove-bangle-row {
        position: absolute !important;
        /* required */
        bottom: 20px;
        /* always stick to top */
        left: 1032px;
        /* always stick to left */

        width: 34px !important;
        height: 34px !important;
        padding: 0 !important;
        border-radius: 50% !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        line-height: 1 !important;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06) !important;
        cursor: pointer !important;
        border: none !important;
    }


    /* Fallback: if the button exists but is NOT inside the wrapper above,
   position the button itself in top-left */
    .bangles_row .remove-bangle-row:not([style]) {
        position: relative;
    }


    /* Icon sizing and FA fallback:
   - If Font Awesome is loaded, the <i class="fa fa-times"> will show.
   - If FA isn't loaded, we provide a text fallback '×' via pseudo-element. */
    .bangles_row .remove-bangle-row i {
        margin: 0 !important;
        font-size: 14px !important;
        line-height: 1 !important;
        display: inline-block !important;
    }



    /* Optional helper: floating/outside-button variant to slightly overlap the border */
    .bangles_row.outside-button {
        padding-left: 1.25rem;
        /* a bit less inner padding when button floats outside */
    }

    .bangles_row.outside-button>.d-flex.align-items-center {
        left: -10px !important;
        top: -10px !important;
    }

    /* Responsive: collapse to single column on small screens and keep space for the button */
    @media (max-width: 767px) {
        #bangles_rows_container {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }

        .bangles_row {
            grid-template-columns: 1fr;
            /* single column layout on small screens */
            padding: 0.8rem 0.9rem 0.5rem 3.5rem;
            /* keep left reserved for button */
            margin: 0 0.5rem 0.6rem;
        }

        .bangles_row>.d-flex.align-items-center {
            left: 8px !important;
            top: 8px !important;
            width: 32px !important;
            height: 32px !important;
        }

        .bangles_row .remove-bangle-row {
            width: 100% !important;
            height: 100% !important;
        }

        .bangles_row .remove-bangle-row i,
        .bangles_row .remove-bangle-row:empty::after {
            font-size: 13px !important;
        }
    }

    /* Small polish: subtle hover to emphasize row */
    .bangles_row:hover {
        box-shadow: 0 4px 12px rgba(18, 38, 63, 0.04);
    }

    /* Accessibility: ensure button states are visible (outline on focus) */
    .bangles_row .remove-bangle-row:focus {
        outline: 2px solid rgba(33, 150, 243, 0.25);
        outline-offset: 2px;
    }


    .select2-container--bootstrap-5 .select2-selection {
        min-height: 38px;
    }

    #drop-area {
        border: 2px dashed #ccc;
        border-radius: 8px;
        cursor: pointer;
    }

    #drop-area.dragging {
        border-color: #007bff;
    }

    .existing-image,
    .new-image-preview {
        position: relative;
        display: inline-block;
        margin-right: 8px;
    }

    .existing-image img,
    .new-image-preview img {
        height: 100px;
        width: 100px;
        object-fit: cover;
        border-radius: 5px;
        display: block;
        user-select: none;
        -webkit-user-drag: none;
    }

    .existing-image .remove-existing,
    .new-image-preview .remove-new-image,
    .existing-image .edit-image-btn,
    .new-image-preview .edit-image-btn {
        position: absolute;
        z-index: 10;
    }

    .existing-image .remove-existing,
    .new-image-preview .remove-new-image {
        top: 4px;
        right: 4px;
    }

    .existing-image .edit-image-btn,
    .new-image-preview .edit-image-btn {
        bottom: 4px;
        left: 4px;
    }

    /* Modal - keep white panel and make image large (fills most of viewport) */
    #imageEditorModal .modal-content {
        background: #fff;
        color: #000;
        max-height: 100vh;
        overflow: hidden;
    }

    #imageEditorModal .modal-body {
        text-align: center;
        padding: 0;
        overflow: auto;
    }

    /* editor-stage uses viewport height so the image area is large for editing */
    .editor-stage {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 75vh;
        /* increased so editor is noticeably larger */
        padding: 12px;
        background: #fff;
        width: 100%;
        overflow: hidden;
    }

    /* Croppie container sizing: boundary large, viewport >= 700x700 */
    #croppieContainer {
        width: 100%;
        max-width: 1800px;
        margin: 0 auto;
    }

    /* override croppie inner boundary to keep large */
    .croppie-container .cr-boundary {
        width: 1100px !important;
        /* increased boundary width */
        height: 900px !important;
        /* increased boundary height */
        max-width: 75vw;
        max-height: 75vh;
        margin: 0 auto;
        overflow: hidden;
    }

    .croppie-container .cr-viewport {
        margin: 0 auto;
        width: 700px !important;
        /* viewport width (editable area) >= 700 */
        height: 700px !important;
        /* viewport height (editable area) >= 700 */
    }

    /* Controls */
    #imageEditorModal .controls {
        background: #f8f9fa;
        padding: 12px;
    }

    #imageEditorModal .controls .btn {
        min-width: 110px;
    }

    /* ensure preview container wraps nicely */
    #image-preview-container,
    #existing-image-container {
        min-height: 110px;
    }

    /* ensure nothing bleeds */
    .croppie-container,
    .cr-boundary,
    .cr-viewport {
        box-sizing: border-box;
    }

    /* modal size tuning */
    .modal-dialog.modal-xl {
        max-width: 1400px;
        /* desktop width for the modal */
        margin: 1rem auto;
    }

    /* fullscreen on small screens */
    @media (max-width: 1200px) {
        .croppie-container .cr-boundary {
            width: 95vw !important;
            height: 70vh !important;
        }

        .croppie-container .cr-viewport {
            width: min(80vw, 560px) !important;
            height: min(80vw, 560px) !important;
        }
    }

    @media (max-width: 767.98px) {
        .modal-dialog.modal-xl {
            max-width: 95% !important;
            margin: 0.5rem auto;
        }

        .editor-stage {
            min-height: 60vh;
        }

        .croppie-container .cr-viewport {
            width: 320px !important;
            height: 320px !important;
        }
    }

    .hide-btn {
        display: none !important;
    }
</style>

<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">

@section('content')
@include('components.includes.admin.navbar')

<main class="content-wrapper">
    <div class="container-fluid py-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>{{ isset($product) ? 'Edit Product' : 'Add New Product' }}</h2>
            <a href="{{ route('admin.products') }}" class="btn text-white" style="background-color: #6cc2b6; border-color: #6cc2b6;">← Back</a>
        </div>

        <form id="productForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $product->id ?? '' }}">

            <!-- Row 1: Name + SKU -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Product Name</label>
                    <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" class="form-control">
                </div>

                <div class="col-md-6">
                    <label>SKU</label>
                    <input type="text" name="sku" value="{{ old('sku', $product->sku ?? '') }}" class="form-control">
                </div>
            </div>

            <!-- Care / Sustainability -->
            <div class="row mb-3">
                <div class="col-md-6"> <label>Care</label> <textarea name="care" rows="4" class="form-control">{{ old('care', $product->care ?? 'Keep your pieces shining by cleaning them after wear and storing them dry. Avoid water, harsh chemicals, and sleeping with jewelry on to prevent damage. Store items separately to prevent tangling or scratches.') }}</textarea> </div>
                <div class="col-md-6"> <label>Sustainability</label> <textarea name="sustainability" rows="4" class="form-control">{{ old('sustainability', $product->sustainability ?? 'Banglez emphasizes conscious production: long-lasting plating, minimizing waste, and thoughtful material sourcing. Each piece is designed to be timeless, for wear over seasons rather than fleeting trends, and packaging is reusable and minimal in environmental impact.') }}</textarea> </div>
            </div>

            <!-- Shipping / Returns -->
            <div class="row mb-3">
                <div class="col-md-6"> <label>Shipping</label> <textarea name="shipping" rows="4" class="form-control">{{ old('shipping', $product->shipping ?? 'Orders are usually shipped within 1–3 business days (Tue–Fri). Free standard shipping is available when orders exceed $80 CAD (members) or when rewards from bundles are redeemed. International shipping is offered; delivery times vary by location. Tracking information will be provided by email once your order ships.') }}</textarea> </div>
                <div class="col-md-6"> <label>Returns</label> <textarea name="returns" rows="4" class="form-control">{{ old('returns', $product->returns ?? 'Returns for online orders are accepted within 15 days of ship date for North American customers, and within 30 days for international orders. Items must be unused, in original packaging, and with tags/barcodes intact. A 10% restocking fee may apply. Clearance sale items, gift cards, bangle boxes, sleeves, and Bridal Choora sets are final sale, with no exchanges or refunds.') }}</textarea> </div>
            </div>

            <!-- Materials / Styles -->
            <div class="row mb-3">
                <div class="col-md-6 ">
                    <label for="collection" class="form-label">Material</label>
                    <select class="form-select" id="material" name="material[]" multiple>
                        <option value="">None</option>
                        @foreach($materials as $material)
                        <option value="{{ $material['id'] }}" {{ in_array($material['id'], old('material', $selectedMaterialIds ?? [])) ? 'selected' : '' }}>
                            {{ $material['name'] }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 ">
                    <label for="collection" class="form-label">Style</label>
                    <select class="form-select" id="style" name="style[]" multiple>
                        <option value="">None</option>
                        @foreach($styles as $style)
                        <option value="{{ $style['id'] }}" {{ in_array($style['id'], old('style', $selectedStyleIds ?? [])) ? 'selected' : '' }}>
                            {{ $style['name'] }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Catalogs / Parent category -->
            <input type="hidden" id="allow_size" value="0">

            <div class="row mb-3">
                <div class="col-md-6 ">
                    <label for="collection" class="form-label">Catalogs</label>
                    <select class="form-select" id="collections" name="collections[]" multiple>
                        <option value="">None</option>
                        @foreach($collections as $collection)
                        <option value="{{ $collection['id'] }}" {{ in_array($collection['id'], old('collections', $selectedCollectionIds ?? [])) ? 'selected' : '' }}>
                            {{ $collection['name'] }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Parent Category</label>
                    <select id="parent_category" class="form-control" name="parent_category">
                        <option value="">Select Parent Category</option>
                        @foreach($parentCategories as $category)
                        <option value="{{ $category->id }}" {{ (old('parent_category') ?? ($product->category->parent_id ?? $product->category->id ?? '')) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Child category (optional) -->
            <div class="row mb-3">
                <div class="col-md-6" style="{{ (isset($product) && $product->category && $product->category->parent_id) ? 'display:block;' : 'display:none;' }}" id="child_category_div">
                    <label>Child Category (Optional)</label>
                    <select id="child_category" name="category" class="form-control">
                        <option value="">Select Child (Optional)</option>
                    </select>
                </div>
                <!-- Category Box -->
                <div class="col-md-6" id="category_box_div">
                    <label>Type Box</label>
                    <select id="category_box" name="category_box_id" class="form-control">
                        <option value="">Select Box</option>
                    </select>
                </div>
            </div>

            <!-- Description -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <label>Description</label>
                    <textarea id="description" name="description" rows="4" class="form-control">{{ old('description', $product->description ?? '') }}</textarea>
                </div>
            </div>

            <!-- Is Feature checkbox -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="is_feature"
                                id="is_feature"
                                value="1"
                                {{ old('is_feature', $product->is_featured ?? 0) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_feature">Is Feature</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="is_top_listed"
                                id="is_top_listed"
                                value="1"
                                {{ old('is_top_listed', $product->is_top_listed ?? 0) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_top_listed">Is Top Seller</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="is_pre_order"
                                id="is_pre_order"
                                value="1"
                                {{ old('is_pre_order', $product->is_pre_order ?? 0) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_pre_order">Is Pre-Order</label>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bangles checkbox + variations area (keeps your original behavior) -->
            <!-- <div class="row mb-3" style="display: none;">
                <div class="col-md-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_bangles" name="has_bangles" {{ (old('bangles') || (isset($product) && $product->variations->count())) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_bangles">Product Variations</label>
                    </div>
                </div>
            </div>

            <div class="row mb-12" id="default_price_qty" style="{{ (isset($product) && $product->variations->count()) ? 'display:none;' : '' }}">
                <div class="col-md-2">
                    <label>Quantity</label>
                    <input type="number" name="quantity" value="{{ old('quantity', $product->quantity ?? 0) }}" class="form-control">
                </div>
                <div class="col-md-2">
                    <label>Unavailable Quantity</label>
                    <input type="number" name="unavailable_quantity" value="{{ old('unavailable_quantity', $product->unavailable_quantity ?? 0) }}" class="form-control">
                </div>
                <div class="col-md-2">
                    <label>Price</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $product->price ?? '') }}" class="form-control">
                </div>
                <div id="compare_price_div" class="col-md-3" style="{{ (isset($product) && $product->variations->count()) ? 'display:none;' : '' }}">
                    <label>Discount Price</label>
                    <input type="number" step="0.01" name="compare_price" value="{{ old('compare_price', $product->compare_price ?? '') }}" class="form-control">
                </div>
                <div id="member_price_div" class="col-md-3" style="{{ (isset($product) && $product->variations->count()) ? 'display:none;' : '' }}">
                    <label>Member Discount Price</label>
                    <input type="number" step="0.01" name="member_price" value="{{ old('member_price', $product->member_price ?? '') }}" class="form-control">
                </div>

            </div> -->

            <div id="bangles_rows_container">
                @if(isset($product) && $product->variations->count())
                @foreach($product->variations as $i => $var)


                <div class="row mb-2 bangles_row">
                    <input type="hidden" name="bangles[{{ $i }}][id]" value="{{ $var->id }}">
                    <div class="col-md-4">
                        <select name="bangles[{{ $i }}][color_id]" class="form-control">
                            <option value="">Select Color</option>
                            @foreach($colors as $color)
                            <option value="{{ $color->id }}" {{ $var->color_id == $color->id ? 'selected' : '' }}>
                                {{ $color->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="bangles[{{ $i }}][size]" class="form-control" placeholder="Size" value="{{ $var->size }}">
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="bangles[{{ $i }}][quantity]" class="form-control" placeholder="Quantity" value="{{ $var->quantity ?: 0  }}">
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="bangles[{{ $i }}][unavailable_quantity]" class="form-control" placeholder="Unavailable Quantity" value="{{ $var->unavailable_quantity ?: 0 }}">
                    </div>
                    <div class="col-md-2">
                        <input type="number" step="0.01" name="bangles[{{ $i }}][price]" class="form-control" placeholder="Price" value="{{ $var->price }}">
                    </div>
                    <div class="col-md-2">
                        <input type="number" step="0.01" name="bangles[{{ $i }}][compare_price]" class="form-control" placeholder="Discount Price" value="{{ $var->compare_price }}">
                    </div>
                    <div class="col-md-2">
                        <input type="number" step="0.01" name="bangles[{{ $i }}][member_price]" class="form-control" placeholder="Member Discount Price" value="{{ $var->member_price }}">
                    </div>
                    <div>
                        <input type="text" name="bangles[{{ $i }}][weight]" class="form-control" placeholder="weight" value="{{ $var->weight }}">
                    </div>
                    <div class="col-md-1 d-flex align-items-center">
                        <button type="button" class="btn btn-danger remove-bangle-row"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                @endforeach
                @endif

            </div>
            <button type="button" class="btn btn-primary mb-3" id="add_bangle_row">Add More</button>
            <!-- meta title and meta description  -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Meta Title</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title', $product->meta_title ?? '') }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label>Meta Description</label>
                    <input type="text" name="meta_description" value="{{ old('meta_description', $product->meta_description ?? '') }}" class="form-control">
                </div>
            </div>
            <!-- Images (At the bottom) -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <label class="form-label noToolTip m-0">Images</label>
                    </div>

                    <div id="drop-area" class="custom-file-input-wrapper border p-5 text-center mt-2" style="cursor: pointer; border-radius: 15px;">
                        <p>Drag & Drop images here or click to select</p>
                    </div>

                    <input type="file" class="d-none exclude_validation" id="images" accept="image/*" multiple>
                    <div id="image-preview-container" class="d-flex flex-wrap mt-3 gap-2"></div>

                    {{-- existing images preview --}}
                   <div id="existing-image-container" class="d-flex flex-wrap mt-3 gap-2">
    @php
        $existingImages = !empty($product->images_details) 
            ? $product->images_details 
            : array_map(fn($img) => ['name' => $img, 'alt' => ''], $product->images ?? []);
    @endphp

    @foreach($existingImages as $detail)
        <div class="existing-image" data-existing-filename="{{ $detail['name'] }}">
            <img 
                src="{{ asset('assets/images/products/' . ($detail['name'] ?? 'default.jpg')) }}"
                alt="{{ $detail['alt'] ?? '' }}" 
                draggable="false">

            <button type="button" class="btn btn-sm btn-danger remove-existing" title="Remove">
                <i class="fa fa-times"></i>
            </button>
            <button type="button" class="btn btn-sm btn-secondary edit-image-btn" title="Edit">
                <i class="fa fa-crop"></i>
            </button>

            {{-- keep hidden input for backend --}}
            <input type="hidden" name="existing_images[]" value="{{ $detail['name'] ?? 'default.jpg' }}">

            {{-- alt input --}}
            <input type="text"
                name="existing_image_alts[{{ $detail['name'] ?? 'default.jpg' }}]"
                value="{{ $detail['alt'] ?? '' }}"
                class="form-control form-control-sm mt-1"
                placeholder="Image Alt"
                style="width:100px;">
        </div>
    @endforeach
</div>

                </div>
            </div>

            <button type="submit" class="btn" style="background-color:#6cc2b6;color:white;">Save Product</button>
        </form>
    </div>

    <!-- Image Editor Modal (uses Croppie) - made larger (modal-xl + fullscreen-md-down) -->
    <div class="modal fade" id="imageEditorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-fullscreen-md-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-0">
                    <div class="editor-stage">
                        <!-- Croppie will render inside this container -->
                        <div id="croppieContainer"></div>
                    </div>

                    <div class="controls text-center">
                        <div class="d-flex flex-wrap justify-content-center gap-2 mb-2">
                            <button type="button" class="btn btn-outline-secondary" id="zoomInBtn">Zoom In</button>
                            <button type="button" class="btn btn-outline-secondary" id="zoomOutBtn">Zoom Out</button>
                            <button type="button" class="btn btn-outline-secondary" id="rotateLeftBtn">Rotate Left</button>
                            <button type="button" class="btn btn-outline-secondary" id="rotateRightBtn">Rotate Right</button>
                            <button type="button" class="btn btn-outline-secondary" id="resetCropBtn">Reset</button>
                            <button type="button" class="btn btn-outline-secondary" id="fitBtn">Fit</button>
                        </div>
                        <p class="text-muted mb-0">Tip: drag/pan the image to position it inside the crop area; use mouse wheel or the Zoom buttons to zoom.</p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="applyCropBtn">Apply</button>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@section('admininsertjavascript')
<!-- libraries you already had -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

<!-- Croppie -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>

<script>
    // Initialize CKEditor on description
    ClassicEditor
        .create(document.querySelector('#description'), {
            toolbar: [
                'heading', '|',
                'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                'undo', 'redo'
            ]
        })
        .catch(error => {
            console.error(error);
        });
</script>

<script>
/* -------------------- Server data -------------------- */
const SERVER_PRODUCT = @json($product ?? null);

// Normalize attributes (same as before)
let SERVER_ATTRIBUTES_RAW = SERVER_PRODUCT && SERVER_PRODUCT.attributes ? SERVER_PRODUCT.attributes : null;
let SERVER_ATTRIBUTES = {};
if (typeof SERVER_ATTRIBUTES_RAW === 'string') {
    try {
        SERVER_ATTRIBUTES = JSON.parse(SERVER_ATTRIBUTES_RAW) || {};
    } catch (e) {
        SERVER_ATTRIBUTES = {};
    }
} else {
    SERVER_ATTRIBUTES = SERVER_ATTRIBUTES_RAW || {};
}

/* -------------------- route templates -------------------- */
const childrenRouteTemplate = "{{ route('categories.children', ['parentId' => ':id']) }}";
const productStoreRoute = "{{ route('admin.products.store') }}";
const productsIndexRoute = "{{ route('admin.products') }}";

/* -------------------- Helper DOM refs -------------------- */
const parentSelectEl = document.getElementById('parent_category');
const childSelectEl = document.getElementById('child_category');
const childWrapEl = document.getElementById('child_category_div');

const dropArea = document.getElementById('drop-area');
const fileInput = document.getElementById('images');
const previewContainer = document.getElementById('image-preview-container');
const existingContainer = document.getElementById('existing-image-container');

const defaultPriceQty = document.getElementById('default_price_qty');
const comparePrice = document.getElementById('compare_price_div');
const memberPrice = document.getElementById('member_price_div');

/* -------------------- Images state -------------------- */
let droppedFiles = []; // {id, file, originalName, edited}
let removedExisting = [];
let fileIdCounter = 1;
function genFileId(){ return 'f' + (fileIdCounter++) + '_' + Date.now(); }

/* -------------------- Category children loader -------------------- */
if (parentSelectEl) {
    $(parentSelectEl).on('change', function() {
        const parentId = this.value;
        if (!childSelectEl || !childWrapEl) return;
        if (!parentId) {
            childSelectEl.innerHTML = '<option value="">Select Child (Optional)</option>';
            childWrapEl.style.display = 'none';
            return;
        }
            fetchAndApplyCategoryDetails(parentId,'parent');
        const url = String(childrenRouteTemplate).replace(':id', parentId);
        childSelectEl.innerHTML = '<option>Loading...</option>';
        childSelectEl.disabled = true;
        $.ajax({ url: url, method: 'GET', dataType: 'json' })
        .done(function(data) {
            let options = '<option value="">Select Child (Optional)</option>';
            if (Array.isArray(data) && data.length > 0) {
                childWrapEl.style.display = 'block';
                data.forEach(child => options += `<option value="${child.id}">${child.name}</option>`);
            } else {
                options = '<option disabled>No child categories</option>';
                childWrapEl.style.display = 'block';
            }
            childSelectEl.innerHTML = options;
            childSelectEl.disabled = false;
                            fetchAndApplyCategoryDetails(childSelectEl.value,'child');
// Auto-select Pre-Order checkbox based on child name
$(childSelectEl).off('change.preorder').on('change.preorder', function() {
    const selectedOption = this.options[this.selectedIndex];
    if (!selectedOption) return;

    // Normalize name (remove spaces, slashes, hyphens, and lowercase)
    const normalizedName = selectedOption.text
        .toLowerCase()
        .replace(/[\s\/-]+/g, '');

    // Get the checkbox
    const preOrderCheckbox = document.getElementById('is_pre_order');
    
    // Check if name contains 'preorder'
    if (normalizedName.includes('preorder')) {
        preOrderCheckbox.checked = true;
    } else {
        preOrderCheckbox.checked = false;
    }
});

            if (SERVER_PRODUCT && SERVER_PRODUCT.category) {
                const childId = (SERVER_PRODUCT.category.parent_id) ? SERVER_PRODUCT.category.id : '';
                if (childId) {
                    childSelectEl.value = childId;
                            fetchAndApplyCategoryDetails(childSelectEl.value,'child');

                }
            }
        })
        .fail(function(xhr) {
            console.error('Failed to load children:', xhr);
            childSelectEl.innerHTML = '<option disabled>Error loading</option>';
            childSelectEl.disabled = true;
            childWrapEl.style.display = 'block';
        });
    });
}
window.addEventListener('DOMContentLoaded', function() {
    if (parentSelectEl && SERVER_PRODUCT && SERVER_PRODUCT.category) {
        const parentId = SERVER_PRODUCT.category.parent_id ? SERVER_PRODUCT.category.parent_id : SERVER_PRODUCT.category.id;
        if (parentId) {
            parentSelectEl.value = parentId;
            $(parentSelectEl).trigger('change');
        }
                            fetchAndApplyCategoryDetails(SERVER_PRODUCT.category.id,'selected');


    }
});

/* -------------------- Drag/drop + previews -------------------- */
if (dropArea) dropArea.addEventListener('click', () => fileInput && fileInput.click());

['dragenter','dragover'].forEach(ev => { dropArea && dropArea.addEventListener(ev, e => { e.preventDefault(); dropArea.classList.add('dragging'); }); });
['dragleave','drop'].forEach(ev => { dropArea && dropArea.addEventListener(ev, e => { e.preventDefault(); dropArea.classList.remove('dragging'); }); });

dropArea && dropArea.addEventListener('drop', e => {
    e.preventDefault();
    const files = Array.from(e.dataTransfer.files || []).filter(f => f.type && f.type.startsWith('image/'));
    files.forEach(file => {
        if (!droppedFiles.some(f => f.file.name === file.name && f.file.size === file.size)) {
            const id = genFileId();
            droppedFiles.push({ id: id, file: file, originalName: file.name, edited: false });
            renderPreviewForFileId(id);
        }
    });
});
fileInput && fileInput.addEventListener('change', e => {
    const files = Array.from(e.target.files || []).filter(f => f.type && f.type.startsWith('image/'));
    files.forEach(file => {
        if (!droppedFiles.some(f => f.file.name === file.name && f.file.size === file.size)) {
            const id = genFileId();
            droppedFiles.push({ id: id, file: file, originalName: file.name, edited: false });
            renderPreviewForFileId(id);
        }
    });
    fileInput.value = '';
});

function renderPreviewForFileId(fileId) {
    const item = droppedFiles.find(it => it.id === fileId);
    if (!item) return;

    const wrapper = document.createElement('div');
    wrapper.classList.add('new-image-preview');
    wrapper.style.display = 'inline-block';
    wrapper.style.position = 'relative';
    wrapper.style.marginRight = '10px';
    wrapper.style.textAlign = 'center';
    wrapper.dataset.fileId = item.id;

    const img = document.createElement('img');
    img.src = URL.createObjectURL(item.file);
    img.alt = 'img';
    img.style.width = '100px';
    img.style.height = '100px';
    img.style.objectFit = 'cover';
    img.style.borderRadius = '5px';
    img.draggable = false;

    const btn = document.createElement('button');
    btn.type = 'button';
    btn.classList.add('btn','btn-sm','btn-danger','remove-new-image');
    btn.style.position = 'absolute';
    btn.style.top = '0';
    btn.style.right = '0';
    btn.innerHTML = '<i class="fa fa-times"></i>';

    const editBtn = document.createElement('button');
    editBtn.type = 'button';
    editBtn.classList.add('btn','btn-sm','btn-secondary','edit-image-btn');
    editBtn.style.position = 'absolute';
    editBtn.style.bottom = '4px';
    editBtn.style.left = '4px';
    editBtn.innerHTML = '<i class="fa fa-crop"></i>';

    editBtn.addEventListener('click', () => {
        openEditorWithFile(item.file, item.id, wrapper);
    });

    btn.addEventListener('click', () => {
        const idx = droppedFiles.indexOf(item);
        if (idx !== -1) droppedFiles.splice(idx, 1);
        try { URL.revokeObjectURL(img.src); } catch(_) {}
        wrapper.remove();
    });

    // ✅ Image Alt input
    const altInput = document.createElement('input');
    altInput.type = 'text';
    altInput.placeholder = 'Image Alt';
    altInput.classList.add('form-control','form-control-sm','mt-1');
    altInput.style.width = '100px';
    altInput.addEventListener('input', () => {
        item.alt = altInput.value; // store alt inside droppedFiles
    });

    wrapper.appendChild(img);
    wrapper.appendChild(editBtn);
    wrapper.appendChild(btn);
    wrapper.appendChild(altInput);

    const container = document.getElementById('existing-image-container');
    container.appendChild(wrapper);
}


/* -------------------- Existing image handlers -------------------- */
if (existingContainer) {
    existingContainer.addEventListener('click', function(e) {
        const remBtn = e.target.closest('.remove-existing');
        if (remBtn) {
            const wrapper = remBtn.closest('.existing-image');
            if (!wrapper) return;
            const filename = wrapper.getAttribute('data-existing-filename');
            if (filename) removedExisting.push(filename);
            wrapper.remove();
            return;
        }
        const editBtn = e.target.closest('.edit-image-btn');
        if (editBtn) {
            const wrapper = editBtn.closest('.existing-image');
            if (!wrapper) return;
            const imgEl = wrapper.querySelector('img');
            if (!imgEl) return;
            const filename = wrapper.getAttribute('data-existing-filename') || null;
            openEditorWithUrl(imgEl.src, null, wrapper, true, filename);
            return;
        }
    });
}

/* expose helpers for server submit logic */
window.getRemovedImages = () => removedExisting;
window.getRemainingImages = () => droppedFiles;
window.getRemovedExisting = () => removedExisting;

/* -------------------- Bangles/Materials/Styles (unchanged behavior) -------------------- */
let banglesIndex = (SERVER_PRODUCT && SERVER_PRODUCT.variations) ? SERVER_PRODUCT.variations.length : 0;
function updateBangleDeleteButtons() {
    const rows = document.querySelectorAll('#bangles_rows_container .bangles_row');
    // rows.forEach(row => {
    //     const btn = row.querySelector('.remove-bangle-row');
    //     if (btn) btn.style.display = rows.length === 1 ? btn.classList.add('hide-btn') : 'inline-flex';
    // });
    rows.forEach(row => {
    const btn = row.querySelector('.remove-bangle-row');
    if (btn) {
        if (rows.length === 1) {
            btn.classList.add('hide-btn');
        } else {
            btn.classList.remove('hide-btn');
        }
    }
});

}
const isBanglesCheckbox = document.getElementById('is_bangles');
if (isBanglesCheckbox) {
    isBanglesCheckbox.addEventListener('change', function() {
        const container = document.getElementById('bangles_rows_container');
        const addBtn = document.getElementById('add_bangle_row');
        if (!container || !addBtn) return;
        if (this.checked) {
            container.style.display = 'block';
            addBtn.style.display = 'inline-block';
            defaultPriceQty && (defaultPriceQty.style.display = 'none');
            comparePrice && (comparePrice.style.display = 'none');
            memberPrice && (memberPrice.style.display = 'none');
            if (container.children.length === 0) addBangleRow();
        }
         else {
            container.style.display = 'none';
            addBtn.style.display = 'none';
            defaultPriceQty && (defaultPriceQty.style.display = 'flex');
            comparePrice && (comparePrice.style.display = 'block');
            memberPrice && (memberPrice.style.display = 'block');
            container.innerHTML = '';
            banglesIndex = 0;
        }
    });
}
function addBangleRow(size = '', qty = 0, price = '', compare = '', member_price = '', colorId = '', unavailable_quantity = 0, id = ''  , weight = '', weight_unit = '' ,allowSize = null) {
    
    if (allowSize == null) {
        const allowSizeInput = document.getElementById('allow_size');
        allowSize = allowSizeInput ? parseInt(allowSizeInput.value, 10) || 0 : 0;
    }
    const container = document.getElementById('bangles_rows_container');
    if (!container) return;
    const row = document.createElement('div');
    row.classList.add('row', 'mb-2', 'bangles_row');

    row.innerHTML = `
            <input type="hidden" name="bangles[${banglesIndex}][id]" value="${id}">
        <div class="col-md-2">
            <select name="bangles[${banglesIndex}][color_id]" class="form-control">
                <option value="">Select Color</option>
                ${colorsOptions(colorId)}
            </select>
        </div>
       ${allowSize == 1 ? `
    <div class="col-md-2 bangle-size-col">
        <input type="text" name="bangles[${banglesIndex}][size]" class="form-control" placeholder="Size" value="${size}">
    </div>
` : `
    <div class="col-md-2 bangle-size-col" style="display:none;">
        <input type="text" name="bangles[${banglesIndex}][size]" class="form-control" placeholder="Size" value="${size}" disabled>
    </div>
`}

        <input type="number" name="bangles[${banglesIndex}][quantity]" class="form-control" placeholder="Quantity" value="${qty && qty !== '' ? qty : 0}">
        </div>
        <div class="col-md-2">
        <input type="number" name="bangles[${banglesIndex}][unavailable_quantity]" class="form-control" placeholder="Unavailable Quantity" value="${unavailable_quantity && unavailable_quantity !== '' ? unavailable_quantity : 0}">
        </div>
        <div class="col-md-2"><input type="number" step="0.01" name="bangles[${banglesIndex}][price]" class="form-control" placeholder="Price" value="${price}"></div>
        <div class="col-md-2"><input type="number" step="0.01" name="bangles[${banglesIndex}][compare_price]" class="form-control" placeholder="Discount Price" value="${compare}"></div>
        <div class="col-md-1"><input type="number" step="0.01" name="bangles[${banglesIndex}][member_price]" class="form-control" placeholder="Member Discount Price" value="${member_price}"></div>
 <div class="col-md-2">
    <div class="input-group">
        <input 
            type="number" 
            step="0.01" 
            name="bangles[${banglesIndex}][weight]" 
            class="form-control" 
            placeholder="Weight" 
            value="${weight}"
        >
        <select 
            name="bangles[${banglesIndex}][weight_unit]" 
            class="form-select" 
            style="max-width: 70px;"
        >
            <option value="g" ${!weight_unit || weight_unit === 'g' ? 'selected' : ''}>g</option>
            <option value="kg" ${weight_unit === 'kg' ? 'selected' : ''}>kg</option>
            <option value="lb" ${weight_unit === 'lb' ? 'selected' : ''}>lb</option>
            <option value="oz" ${weight_unit === 'oz' ? 'selected' : ''}>oz</option>
        </select>
    </div>
</div>

        <div class="col-md-1 d-flex align-items-center"><button type="button" class="btn btn-danger remove-bangle-row"><i class="fa fa-times"></i></button></div>
    `;
    container.appendChild(row);
    banglesIndex++;
    updateBangleDeleteButtons();
}

function colorsOptions(selectedId = '') {
    const colors = @json($colors); // 👈 inject from controller
    return colors.map(c => 
        `<option value="${c.id}" ${c.id == selectedId ? 'selected' : ''}>${c.name}</option>`
    ).join('');
}

document.addEventListener('click', function(e) {
    const rem = e.target.closest('.remove-bangle-row');
    if (rem) {
        const row = rem.closest('.bangles_row');
        row && row.remove();
        updateBangleDeleteButtons();
    }
});
const addBangleBtn = document.getElementById('add_bangle_row');
addBangleBtn && addBangleBtn.addEventListener('click', () => addBangleRow());

/* Materials */
let materialsIndex = 0;
function addMaterialRow(value = '') {
    const container = document.getElementById('material_rows_container');
    if (!container) return;
    const row = document.createElement('div');
    row.classList.add('row', 'mb-2', 'material_row');
    row.innerHTML = `<div class="col-md-6"><input type="text" name="materials[${materialsIndex}][name]" class="form-control" placeholder="Material Name" value="${value}"></div><div class="col-md-1 d-flex align-items-center"><button type="button" class="btn btn-danger remove-material-row"><i class="fa fa-times"></i></button></div>`;
    container.appendChild(row);
    materialsIndex++;
    updateMaterialDeleteButtons();
}
function updateMaterialDeleteButtons() {
    const rows = document.querySelectorAll('#material_rows_container .material_row');
    rows.forEach(row => {
        const btn = row.querySelector('.remove-material-row');
        if (btn) btn.style.display = rows.length === 1 ? 'none' : 'inline-flex';
    });
}
const isMaterialCheckbox = document.getElementById('is_material');
isMaterialCheckbox && isMaterialCheckbox.addEventListener('change', function() {
    const container = document.getElementById('material_rows_container');
    const addBtn = document.getElementById('add_material_row');
    if (!container || !addBtn) return;
    if (this.checked) {
        container.style.display = 'block';
        addBtn.style.display = 'inline-block';
        if (container.children.length === 0) addMaterialRow();
    } else {
        container.style.display = 'none';
        addBtn.style.display = 'none';
        container.innerHTML = '';
        materialsIndex = 0;
    }
});
document.addEventListener('click', function(e) {
    if (e.target.closest('.remove-material-row')) {
        e.target.closest('.material_row').remove();
        updateMaterialDeleteButtons();
    }
});
document.getElementById('add_material_row') && document.getElementById('add_material_row').addEventListener('click', () => addMaterialRow(''));

/* Styles */
let stylesIndex = 0;
function addStyleRow(value = '') {
    const container = document.getElementById('style_rows_container');
    if (!container) return;
    const row = document.createElement('div');
    row.classList.add('row', 'mb-2', 'style_row');
    row.innerHTML = `<div class="col-md-6"><input type="text" name="styles[${stylesIndex}][name]" class="form-control" placeholder="Style Name" value="${value}"></div><div class="col-md-1 d-flex align-items-center"><button type="button" class="btn btn-danger remove-style-row"><i class="fa fa-times"></i></button></div>`;
    container.appendChild(row);
    stylesIndex++;
    updateStyleRemoveButtons();
}
function updateStyleRemoveButtons() {
    const rows = document.querySelectorAll('.style_row');
    if (rows.length === 0) return;
    if (rows.length === 1) {
        const btn = rows[0].querySelector('.remove-style-row');
        if (btn) btn.style.display = 'none';
    } else {
        rows.forEach(r => {
            const btn = r.querySelector('.remove-style-row');
            if (btn) btn.style.display = 'flex';
        });
    }
}
const isStyleCheckbox = document.getElementById('is_style');
isStyleCheckbox && isStyleCheckbox.addEventListener('change', function() {
    const container = document.getElementById('style_rows_container');
    const addBtn = document.getElementById('add_style_row');
    if (!container || !addBtn) return;
    if (this.checked) {
        container.style.display = 'block';
        addBtn.style.display = 'inline-block';
        if (container.children.length === 0) addStyleRow();
    } else {
        container.style.display = 'none';
        addBtn.style.display = 'none';
        container.innerHTML = '';
        stylesIndex = 0;
    }
});
document.addEventListener('click', function(e) {
    if (e.target.closest('.remove-style-row')) {
        e.target.closest('.style_row').remove();
        updateStyleRemoveButtons();
    }
});
document.getElementById('add_style_row') && document.getElementById('add_style_row').addEventListener('click', () => addStyleRow(''));

/* Populate initial data (variations/materials/styles) */
window.addEventListener('DOMContentLoaded', () => {
    if (SERVER_PRODUCT && Array.isArray(SERVER_PRODUCT.variations) && SERVER_PRODUCT.variations.length) {
        const isB = document.getElementById('is_bangles');
        const container = document.getElementById('bangles_rows_container');
        const addBtn = document.getElementById('add_bangle_row');
        if (isB) isB.checked = true;
        if (container) container.style.display = 'block';
        if (addBtn) addBtn.style.display = 'inline-block';
        if (container) container.innerHTML = '';
        SERVER_PRODUCT.variations.forEach(v => addBangleRow(v.size || '', v.quantity || '', v.price || '', v.compare_price || '' || '', v.member_price || '', v.color_id || '' , v.unavailable_quantity || '', v.id || '', v.weight || '', v.weight_unit || ''));
    }
    else if (SERVER_PRODUCT) {
    addBangleRow(
        SERVER_PRODUCT.size || '',
        SERVER_PRODUCT.quantity || '',
        SERVER_PRODUCT.price || '',
        SERVER_PRODUCT.compare_price || '',
        SERVER_PRODUCT.member_price || '',
        SERVER_PRODUCT.color_id || '',
        SERVER_PRODUCT.unavailable_quantity || '',
        SERVER_PRODUCT.id || '',
        SERVER_PRODUCT.weight || '',
        SERVER_PRODUCT.weight_unit || ''
    );
}
else{
addBangleRow();

}
    if (SERVER_ATTRIBUTES && Array.isArray(SERVER_ATTRIBUTES.materials) && SERVER_ATTRIBUTES.materials.length) {
        const isM = document.getElementById('is_material');
        const container = document.getElementById('material_rows_container');
        const addBtn = document.getElementById('add_material_row');
        if (isM) isM.checked = true;
        if (container) container.style.display = 'block';
        if (addBtn) addBtn.style.display = 'inline-block';
        container.innerHTML = '';
        SERVER_ATTRIBUTES.materials.forEach(m => {
            const name = (typeof m === 'string') ? m : (m.name || '');
            addMaterialRow(name);
        });
    }
    if (SERVER_ATTRIBUTES && Array.isArray(SERVER_ATTRIBUTES.styles) && SERVER_ATTRIBUTES.styles.length) {
        const isS = document.getElementById('is_style');
        const container = document.getElementById('style_rows_container');
        const addBtn = document.getElementById('add_style_row');
        if (isS) isS.checked = true;
        if (container) container.style.display = 'block';
        if (addBtn) addBtn.style.display = 'inline-block';
        container.innerHTML = '';
        SERVER_ATTRIBUTES.styles.forEach(s => {
            const name = (typeof s === 'string') ? s : (s.name || '');
            addStyleRow(name);
        });
    }
});

/* -------------------- Croppie integration (new library) -------------------- */
let croppieInstance = null;
let currentEditing = { fileId: null, isExisting: false, existingFilename: null, wrapperElement: null };

// Open editor with a File instance
function openEditorWithFile(file, fileId, wrapperElement) {
    const reader = new FileReader();
    reader.onload = ev => startCroppie(ev.target.result, fileId, false, file, wrapperElement);
    reader.readAsDataURL(file);
}

// Open editor with a URL (existing image)
function openEditorWithUrl(url, fileId = null, wrapperElement = null, isExisting=false, existingFilename=null) {
    startCroppie(url, fileId, isExisting, null, wrapperElement, existingFilename);
}

function startCroppie(src, fileId, isExisting=false, originalFile=null, wrapperElement=null, existingFilename=null) {
    const croppieContainer = document.getElementById('croppieContainer');
    if (!croppieContainer) return;

    currentEditing.fileId = fileId;
    currentEditing.isExisting = isExisting;
    currentEditing.existingFilename = existingFilename || null;
    currentEditing.wrapperElement = wrapperElement || null;

    // Ensure container is empty
    croppieContainer.innerHTML = '';

    // show modal
    const bsModalEl = new bootstrap.Modal(document.getElementById('imageEditorModal'), { backdrop: 'static', keyboard: false });
    bsModalEl.show();

    // create croppie instance with larger viewport (700x700) and boundary (1100x900)
    croppieInstance = new Croppie(croppieContainer, {
        viewport: { width: 400, height: 400, type: 'square' }, // <-- viewport >= 700px
        boundary: { width: 1100, height: 900 },                 // <-- large boundary
        showZoomer: true,
        enableOrientation: true,
        enforceBoundary: true
    });

    // bind image
    croppieInstance.bind({ url: src }).then(() => {
        // center / initial zoom if needed
    }).catch(err => {
        console.error('Croppie bind error:', err);
    });

    // Controls
    document.getElementById('zoomInBtn').onclick = () => {
        try { if (croppieInstance) croppieInstance.zoomBy(0.1); } catch(e) {}
    };
    document.getElementById('zoomOutBtn').onclick = () => {
        try { if (croppieInstance) croppieInstance.zoomBy(-0.1); } catch(e) {}
    };
    document.getElementById('rotateLeftBtn').onclick = () => {
        try { if (croppieInstance) croppieInstance.rotate(-90); } catch(e) {}
    };
    document.getElementById('rotateRightBtn').onclick = () => {
        try { if (croppieInstance) croppieInstance.rotate(90); } catch(e) {}
    };
    document.getElementById('resetCropBtn').onclick = () => {
        // destroy and recreate - simple reset approach
        try {
            if (croppieInstance) {
                croppieInstance.destroy();
                croppieInstance = new Croppie(croppieContainer, {
                    viewport: { width: 500, height: 500, type: 'square' },
                    boundary: { width: 900, height: 700 },
                    showZoomer: true,
                    enableOrientation: true,
                    enforceBoundary: true
                });
                croppieInstance.bind({ url: src });
            }
        } catch(e) { console.warn('reset failed', e); }
    };
    document.getElementById('fitBtn').onclick = () => {
        try { if (croppieInstance) croppieInstance.bind({ url: src }); } catch(e) {}
    };

    // Apply crop
    document.getElementById('applyCropBtn').onclick = function applyHandler() {
        if (!croppieInstance) return;
        croppieInstance.result({ type: 'blob', size: 'viewport', format: 'jpeg', quality: 0.9 }).then(function(blob) {
            const timestamp = Date.now();
            const ext = 'jpg';
            const newFileName = currentEditing.isExisting ? ('edited_' + (currentEditing.existingFilename || ('img_' + timestamp + '.' + ext))) : ('edited_' + timestamp + '.' + ext);
            const newFile = new File([blob], newFileName, { type: blob.type });

            if (currentEditing.isExisting) {
                if (currentEditing.existingFilename) removedExisting.push(currentEditing.existingFilename);
                const newId = genFileId();
                droppedFiles.push({ id: newId, file: newFile, originalName: newFileName, edited: true });
                if (currentEditing.wrapperElement) currentEditing.wrapperElement.remove();
                renderPreviewForFileId(newId);
            } else {
                const idx = droppedFiles.findIndex(it => it.id === currentEditing.fileId);
                if (idx !== -1) {
                    droppedFiles[idx].file = newFile;
                    droppedFiles[idx].originalName = newFileName;
                    droppedFiles[idx].edited = true;
                    const wrapper = document.querySelector(`[data-file-id="${currentEditing.fileId}"]`);
                    if (wrapper) {
                        const img = wrapper.querySelector('img');
                        if (img) img.src = URL.createObjectURL(newFile);
                    }
                } else {
                    const newId = genFileId();
                    droppedFiles.push({ id: newId, file: newFile, originalName: newFileName, edited: true });
                    renderPreviewForFileId(newId);
                    if (currentEditing.wrapperElement) currentEditing.wrapperElement.remove();
                }
            }

            // cleanup
            try { if (croppieInstance) { croppieInstance.destroy(); croppieInstance = null; } } catch(e) {}
            const bsModal = bootstrap.Modal.getInstance(document.getElementById('imageEditorModal'));
            bsModal.hide();
            currentEditing = { fileId: null, isExisting: false, existingFilename: null, wrapperElement: null };
        }).catch(function(err){
            console.error('Croppie result error:', err);
        });

        // avoid double-binding
        this.onclick = null;
    };

    // cleanup on modal hidden
    document.getElementById('imageEditorModal').addEventListener('hidden.bs.modal', function() {
        try { if (croppieInstance) { croppieInstance.destroy(); croppieInstance = null; } } catch(e) {}
        // clear container
        try { document.getElementById('croppieContainer').innerHTML = ''; } catch(_) {}
        currentEditing = { fileId: null, isExisting: false, existingFilename: null, wrapperElement: null };
    }, { once: true });
}

/* -------------------- AJAX submit -------------------- */
$(document).ready(function() {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val() }
    });

    $('#collections').select2({ placeholder: "Select categories", allowClear: true });
    $('#material').select2({ placeholder: "Select Materials", allowClear: true });
    $('#style').select2({ placeholder: "Select styles", allowClear: true });

    $('#productForm').on('submit', function(e) {
        e.preventDefault();
        document.querySelectorAll('.bangle-size-col input[disabled]').forEach(inp => {
        inp.disabled = false;
        inp.value = ''; // 👈 force null
    });
        const $form = $(this);
        const formData = new FormData(this);
        droppedFiles.forEach(item => {
    if (item && item.file) {
        formData.append('images[]', item.file, item.originalName || item.file.name);
    }
});

// Removed images
formData.append('removed_existing_images', JSON.stringify(removedExisting || []));

// Build details (use originalName for new files, real filename for existing)
const imagesDetails = [];

// existing
document.querySelectorAll('#existing-image-container .existing-image').forEach(wrapper => {
    const name = wrapper.dataset.existingFilename;
    const alt = wrapper.querySelector('input[type=text]')?.value || '';
    if (name && !removedExisting.includes(name)) {
        imagesDetails.push({ name, alt, isNew: false });
    }
});

// new
droppedFiles.forEach(item => {
    imagesDetails.push({
        name: item.originalName || item.file.name,
        alt: item.alt || '',
        isNew: true
    });
});

formData.append('images_details', JSON.stringify(imagesDetails));
        // droppedFiles.forEach(item => {
        //     if (item && item.file) formData.append('images[]', item.file, item.originalName || item.file.name);
        // });
        // formData.append('removed_existing_images', JSON.stringify(removedExisting || []));
        const submitButton = $form.find('button[type="submit"]');
        submitButton.prop('disabled', true);
        Swal.fire({
            title: 'Processing...',
            text: 'Please wait while we process your request.',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });
        $.ajax({
            url: productStoreRoute,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.close();
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message || 'Item added successfully!',
                }).then(() => {
                    window.location.href = response.redirect_route || productsIndexRoute;
                });
            },
            error: function(xhr) {
                Swal.close();
                let title = 'System Error!';
                let message = 'Something went wrong! Please try again.';
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.details) {
                    title = 'Validation Error!';
                    message = JSON.stringify(xhr.responseJSON.details, null, 2);
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                Swal.fire({ icon: 'error', title: title, text: message, confirmButtonColor: '#d33' });
                submitButton.prop('disabled', false);
            }
        });
    });
});

</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    function loadBoxes(categoryId, selectedBoxId = null) {
        const boxDiv = document.getElementById("category_box_div");
        const boxDropdown = document.getElementById("category_box");

        if (!categoryId) {
            boxDiv.style.display = "none";
            boxDropdown.innerHTML = '<option value="">Select Box</option>';
            return;
        }

        // Use Laravel route with placeholder
        let url = "{{ route('categories.getBoxes', ':id') }}".replace(':id', categoryId);

        fetch(url)
            .then(response => response.json())
            .then(data => {
                boxDropdown.innerHTML = '<option value="">Select Box</option>';

                if (data.length > 0) {
                    data.forEach(box => {
                        let option = document.createElement("option");
                        option.value = box.id;
                        option.textContent = box.name;
                        if (selectedBoxId && selectedBoxId == box.id) {
                            option.selected = true;
                        }
                        boxDropdown.appendChild(option);
                    });

                    boxDiv.style.display = "block";
                } else {
                    // Only hide if no preselected box
                    if (!selectedBoxId) {
                        boxDiv.style.display = "none";
                    }
                }
            })
            .catch(error => console.error("Error loading boxes:", error));
    }

    const parentCategory = document.getElementById("parent_category");
    const childCategory = document.getElementById("child_category");

    parentCategory.addEventListener("change", function () {
        loadBoxes(this.value);
    });

    childCategory.addEventListener("change", function () {
        loadBoxes(this.value || parentCategory.value);
    });

    // Edit case (preload selected box)
    @if(isset($product) && $product->category)
        loadBoxes(
            {{ $product->category->id }},
            {!! json_encode($product->category_box_id) !!}
        );
    @endif
});
</script>
<script>
/*
  Usage:
  - Requires: jQuery (you already use it), #allow_size hidden input present,
    #parent_category and #child_category select elements present,
    addBangleRow reads $('#allow_size').val() when creating new rows.
  - Route template (Blade) below uses your named route 'category.details'.
*/

const categoryDetailsUrlTemplate = "{{ route('category.show.details', ['id' => ':id']) }}";

// Fetch category details and apply allow_size to page
function fetchAndApplyCategoryDetails(catId,type="test") {
    // no id -> disable sizes
    if (!catId) {
        $('#allow_size').val(0);
        toggleSizeForExistingRows(0);
        return $.Deferred().resolve().promise();
    }

    const url = String(categoryDetailsUrlTemplate).replace(':id', catId);

    return $.getJSON(url)
        .done(function(cat) {
            const allow = Number((cat && cat.allow_size) ? cat.allow_size : 0);
            // alert(type+' is '+allow);
            $('#allow_size').val(allow);
            toggleSizeForExistingRows(allow);
        })
        .fail(function() {
            console.error('Failed to fetch category details for id:', catId);
            $('#allow_size').val(0);
            toggleSizeForExistingRows(0);
        });
}

// Show/hide size inputs for already-rendered rows and ensure backend receives a consistent field
function toggleSizeForExistingRows(allow) {
    const allowSizeInput = document.getElementById('allow_size');
    if (allowSizeInput) {
        allowSizeInput.value = allow;  // 👈 update hidden input
    }
    const rows = document.querySelectorAll('#bangles_rows_container .bangles_row');
    rows.forEach((row, idx) => {
        let visibleSizeInput = row.querySelector('input[type="text"][name*="[size]"]');
        let hiddenFallback = row.querySelector(`input[type="hidden"][name="bangles[${idx}][size]"]`) ||
                             row.querySelector('input[type="hidden"][name$="[size]"]'); // fallback non-indexed check

  if (allow == 1) {
    if (visibleSizeInput) {
        const parentCol = visibleSizeInput.closest('[class*="col-"]');
        if (parentCol) parentCol.style.display = '';
        visibleSizeInput.disabled = false;
        if (hiddenFallback) hiddenFallback.remove();
    } else {
        const nameIndex = resolveBangleIndexForRow(row, idx);
        const inputName = `bangles[${nameIndex}][size]`;
        const wrapper = document.createElement('div');
        wrapper.className = 'col-md-2';

        // 👇 restore value from hidden input if available
        const restoreValue = hiddenFallback ? hiddenFallback.value : '';

        wrapper.innerHTML = `<input type="text" name="${inputName}" class="form-control" placeholder="Size" value="${restoreValue}">`;

        const colorSelect = row.querySelector('select[name*="[color_id]"]');
        if (colorSelect && colorSelect.parentElement) {
            colorSelect.parentElement.insertAdjacentElement('afterend', wrapper);
        } else {
            row.insertBefore(wrapper, row.firstChild);
        }

        if (hiddenFallback) hiddenFallback.remove();
    }
} else {
    // allow == 0: hide input
    if (visibleSizeInput) {
        const currentValue = visibleSizeInput.value || '';
        const parentCol = visibleSizeInput.closest('[class*="col-"]');
        if (parentCol) parentCol.remove();

        const nameIndex = resolveBangleIndexForRow(row, idx);
        const hiddenName = `bangles[${nameIndex}][size]`;

        let hidden = row.querySelector(`input[type="hidden"][name="${hiddenName}"]`);
        if (!hidden) {
            hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = hiddenName;
            row.appendChild(hidden);
        }

        hidden.value = currentValue; // 👈 preserve typed value
    }
}


    });
}

// Helper: try to determine the correct numeric index used by existing row inputs
// Fallbacks to the provided idx if unable to parse.
function toggleSizeForExistingRows(allow) {
    const rows = document.querySelectorAll('#bangles_rows_container .bangles_row');
    rows.forEach((row) => {
        let sizeCol = row.querySelector('.bangle-size-col'); // 👈 we'll add this class
        if (!sizeCol) return;

        if (allow == 1) {
            sizeCol.style.display = '';
            const input = sizeCol.querySelector('input[type="text"]');
            if (input) input.disabled = false;
        } else {
            sizeCol.style.display = 'none';
            const input = sizeCol.querySelector('input[type="text"]');
            if (input) input.disabled = true; // disable so it doesn’t get submitted
        }
    });
}


/* -------------------------
   Wire up events
   ------------------------- */


// When child changes: child always wins — fetch child details
$(document).on('change', '#child_category', function () {
    const childId = this.value || null;
    fetchAndApplyCategoryDetails(childId , 'child');
});
</script>

@endsection
