<x-layouts.user-default>
    <x-slot name="insertstyle">
        <!-- <span class="card-action-icon edit-card"
                                            data-id="${card.id}"
                                            data-full_name="${card.full_name ?? ''}"
                                            data-street="${card.street ?? ''}"
                                            data-apartment="${card.apartment ?? ''}"
                                            data-city="${card.city ?? ''}"
                                            data-state="${card.state ?? ''}"
                                            data-zip="${card.zip ?? ''}"
                                            data-phone="${card.phone ?? ''}"
                                            data-default="${card.is_default ?? 0}"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                    <span class="card-action-icon view-card" data-id="${card.id}" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </span> -->
        <style>
            /* Address card buttons - always visible */
            #shipping-address .address-card-wrapper .card {
                position: relative;
            }
            
            #shipping-address .address-card-actions {
                opacity: 1 !important;
                visibility: visible !important;
                display: block !important;
            }
            
            #shipping-address .address-edit-btn,
            #shipping-address .address-delete-btn {
                opacity: 1 !important;
                visibility: visible !important;
                display: inline-block !important;
                pointer-events: auto !important;
                background-color: #8d5943 !important;
                border-color: #8d5943 !important;
                color: white !important;
                transition: none !important;
            }
            
            #shipping-address .address-edit-btn:hover,
            #shipping-address .address-delete-btn:hover {
                background-color: #8d5943 !important;
                border-color: #8d5943 !important;
                color: white !important;
                opacity: 1 !important;
            }
            
            #shipping-address .card-footer {
                opacity: 1 !important;
                visibility: visible !important;
            }
            
            #shipping-address .card-footer .btn {
                opacity: 1 !important;
                visibility: visible !important;
                display: inline-block !important;
            }
            
            /* Wrap each card with breathing space */
            .giftcard-card {
                border: 1px solid #ddd;
                border-radius: 10px;
                margin: 15px 15px;
                /* adds space left/right */
                overflow: hidden;
                background: #fff;
                transition: box-shadow 0.2s ease;
            }

            /* Subtle hover shadow to show interactivity */
            .giftcard-card:hover {
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            }

            /* Header area of each card */
            .giftcard-summary {
                display: flex;
                justify-content: space-between;
                align-items: center;
                background-color: #f9f9f9;
                padding: 14px 18px;
                cursor: pointer;
                font-weight: 600;
                border-bottom: 1px solid #eee;
                transition: all 0.25s ease;
                position: relative;
            }

            /* Slight lift + color hint when hover */
            .giftcard-summary:hover {
                background-color: #f1f1f1;
                box-shadow: inset 0 0 0 1px #e0e0e0;
            }

            /* Add a subtle indicator to show it’s clickable */
            .giftcard-summary::after {
                content: "›";
                font-size: 18px;
                color: #aaa;
                transition: transform 0.3s ease, color 0.3s ease;
            }

            /* When card is open — show downward arrow */
            .giftcard-summary.open::after {
                content: "⌄";
                transform: rotate(0deg);
                color: #555;
            }


            /* Status colors */
            .giftcard-status.active {
                color: green;
            }

            .giftcard-status.used {
                color: red;
            }

            /* Details area */
            .giftcard-details {
                padding: 12px 20px 15px 20px;
                background: #fff;
                border-top: 1px solid #eee;
                transition: all 0.3s ease;
            }

            .giftcard-history {
                list-style: none;
                margin: 0;
                padding: 0;
            }

            .giftcard-history li {
                display: flex;
                justify-content: space-between;
                padding: 5px 0;
                border-bottom: 1px dashed #ddd;
                font-size: 14px;
            }

            .remaining {
                text-align: right;
                font-weight: 600;
                margin-top: 10px;
            }

            /* .giftcard-arrow {
    font-size: 18px;
    color: #aaa;
    margin-left: 8px;
    transition: transform 0.3s ease, color 0.3s ease;
}

.giftcard-summary:hover .giftcard-arrow {
    color: #555;
    transform: translateX(3px);
} */



            .purchase-item .bundle-select {
                margin-left: 0px;
                font-size: 0.95em;
                padding: 4px 6px;
                border-radius: 4px;
                width: auto;
                max-width: 230px;
            }

            li.disabled {
                pointer-events: none;
                /* disable clicking */
                font-weight: bold;
                padding: 10px;
                padding-right: 20px;
                padding-left: 30px;
            }

            .li.disabled img {
                margin-right: 10px;
            }

            li.disabled ul {
                pointer-events: auto;
                /* allow sublist items */
                margin-left: 20px;
            }

            li.disabled ul li {
                padding: 10px;
                font-weight: 400
            }

            li.disabled ul li:hover {
                background: rgb(239, 238, 238);
                border-radius: 10px;

            }

            li.disabled ul li.active {
                background: rgb(225, 225, 225);
                border: none !important;
                border-radius: 10px;
            }

            .label {
                font-size: 12px;
                text-transform: uppercase;
                color: #666;
            }

            .value {
                font-size: 16px;
                font-weight: bold;
                color: #000;
                display: inline-block;
                margin-right: 10px;
            }

            .edit-btn {
                color: #0066cc;
                cursor: pointer;
                font-size: 14px;
            }

            .edit-box input {
                width: 70%;
                padding: 8px;
                font-size: 16px;
                margin-top: 4px;
            }

            .edit-actions button {
                margin-right: 10px;
                margin-top: 8px;
            }

            .main-field {
                width: 70%;
                display: flex;
                justify-content: space-between;
            }

            .modal {
                z-index: 100000 !important;
            }

            .modal-backdrop {
                z-index: 10000 !important;
            }

            .purchase-history {
                margin: 20px 0;
                padding-left: 10px;
                padding-right: 10px;
            }

            .purchase-history-title {
                font-size: 24px;
                margin-bottom: 15px;
                font-weight: bold;
            }

            .purchase-card {
                border: 1px solid #ddd;
                margin-bottom: 10px;
                border-radius: 8px;
                overflow: hidden;
            }

            .purchase-summary {
                display: flex;
                justify-content: space-between;
                padding: 12px 16px;
                background: #f9f9f9;
                cursor: pointer;
                font-weight: 500;
            }

            .purchase-summary:hover {
                background: #f1f1f1;
            }

            .purchase-order-number {
                color: #333;
            }

            .purchase-status {
                padding: 2px 8px;
                border-radius: 4px;
                font-size: 14px;
                font-weight: bold;
            }

            .purchase-status.completed {
                background: #d1f7d1;
                color: #2a7c2a;
            }

            .purchase-status.pending {
                background: #fff3cd;
                color: #856404;
            }

            .purchase-total {
                font-weight: bold;
                color: #444;
            }

            .purchase-details {
                padding: 15px;
                display: none;
                /* hidden until expanded */
            }

            .purchase-details-title {
                font-size: 18px;
                margin-bottom: 10px;
            }

            .purchase-items {
                list-style: none;
                margin: 0;
                padding: 0;
            }

            .purchase-item {
                display: flex;
                justify-content: space-between;
                padding: 8px 0;
                border-bottom: 1px solid #eee;
            }

            .purchase-item:last-child {
                border-bottom: none;
            }

            .item-info {
                display: flex;
                flex-direction: column;
            }

            .item-name {
                font-weight: bold;
            }

            .item-qty {
                font-size: 14px;
                color: #666;
            }

            .item-price {
                font-weight: bold;
                color: #333;
            }

            .purchase-item {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px 0;
                border-bottom: 1px solid #eee;
            }

            .purchase-item:last-child {
                border-bottom: none;
            }

            .item-info {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .item-image {
                width: 50px;
                height: 50px;
                border-radius: 6px;
                object-fit: cover;
                border: 1px solid #ddd;
            }

            .item-name {
                font-weight: bold;
                display: block;
            }

            .item-qty {
                font-size: 14px;
                color: #666;
                display: block;
            }

            .item-price {
                font-weight: bold;
                color: #333;
                min-width: 70px;
                text-align: right;
            }

            .bundle-details {
                display: none;
                /* hidden until toggle */
                margin: 8px 0 8px 60px;
                /* indent under parent item */
                padding-left: 10px;
                border-left: 2px dashed #ccc;
            }

            .bundle-item {
                padding: 5px 0;
                font-size: 14px;
                color: #555;
            }

            .bundle-product-name {
                display: block;
                font-weight: 500;
            }

            .cursor-hide {
                cursor: unset;
            }

            .input-field strong {
                font-size: 12px;
            }
            
            /* Communication Preferences Toggle Switches */
            .preference-item {
                padding: 15px 0;
                border-bottom: 1px solid #eee;
            }
            
            .preference-item:last-child {
                border-bottom: none;
            }
            
            .preference-item h5 {
                font-size: 16px;
                font-weight: 600;
                margin-bottom: 4px;
            }
            
            .preference-item .text-muted {
                font-size: 14px;
                color: #666;
            }
            
            /* Custom Toggle Switch Styling */
            .toggle-switch {
                position: relative;
                display: inline-block;
                width: 50px;
                height: 26px;
            }
            
            .toggle-switch input[type="checkbox"] {
                opacity: 0;
                width: 0;
                height: 0;
            }
            
            .toggle-label {
                position: absolute;
                cursor: pointer;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: #ccc;
                transition: 0.3s;
                border-radius: 26px;
            }
            
            .toggle-label:before {
                position: absolute;
                content: "";
                height: 20px;
                width: 20px;
                left: 3px;
                bottom: 3px;
                background-color: white;
                transition: 0.3s;
                border-radius: 50%;
            }
            
            .toggle-switch input:checked + .toggle-label {
                background-color: #8d5943;
            }
            
            .toggle-switch input:checked + .toggle-label:before {
                transform: translateX(24px);
            }
            
            .toggle-switch input:focus + .toggle-label {
                box-shadow: 0 0 1px #8d5943;
            }
        </style>
    </x-slot>
    <x-slot name="content">
        <div class="product-detail-main-wrapper">
            <div class="personal-acount-main">
                <div class="main-side-heding-tabs personal-account-side-heading">
                    <div class="side-headings-tabs personal-account-side-tab">
                        <small class="side-head">Account/Home</small>
                        <ul id="tab-side-menu">
                            <li class="welcome-name" data-target="personal-information" class="active">
                                <p>Hi, <span>{{ Auth::check() ? Auth::user()->name : 'Guest' }}</span></p>

                            </li>
                            <li class="personal-list" data-target="purchase-history"><img src="{{ asset('assets/images/pay-icon.svg') }}" alt="missing">Purchase History</li>
                            <li class="personal-list" data-target="rewards"><img src="{{ asset('assets/images/shin.svg') }}" alt="missing">Points & Rewards</li>
                            <li class="personal-list" data-target="gift-card"><img src="{{ asset('assets/images/req.svg') }}" alt="missing">My Wishlist</li>
                            <li class="personal-list" data-target="gift-card-set"><img src="{{ asset('assets/images/req.svg') }}" alt="missing">Gift Cards</li>
                            <li class="disabled">
                                <img src="{{ asset('assets/images/account.svg') }}" alt="missing"> Manage Account
                                <ul>
                                    <!-- Sublist (clickable items) -->
                                    <li data-target="personal-info">Personal Information</li>
                                    <li data-target="save-card">Saved Cards</li>
                                    <li data-target="shipping-address">Shipping Address</li>
                                    <li data-target="change-password">Change Password</li>
                                    <li data-target="communication">Communication Preferences</li>
                                </ul>
                            </li>

                        </ul>
                    </div>
                    <div class="side-content-tabs" id="personal-information">
                        <div class="side-inner-content-main">
                            <div class="side-inner-content resource-content">
                                <div class="personal-inner-tabs">
                                    <div class="persnal-left">
                                        <div class="dash-card">
                                            <div class="dash-card-header">
                                                <span><img src="{{ asset('assets/images/pay-icon.svg') }}" alt="missing"> Purchase History</span>
                                                <span><img data-target="purchase-history" src="{{ asset('assets/images/slide-right.png') }}" alt="missing"></span>
                                            </div>
                                            <div class="dash-purchase-history">
                                                You have no recent orders to track.
                                            </div>

                                            {{-- if data exist --}}
                                            <div class="purchase-history">


                                            </div>

                                        </div>
                                    </div>
                                    <div class="personal-right">
                                        <div class="dash-card">
                                            <div class="dash-card-header">
                                                <span><img src="{{ asset('assets/images/shin.svg') }}" alt="missing"> Points & Rewards</span>
                                                <span><img data-target="share-info" src="{{ asset('assets/images/slide-right.png') }}" alt="missing"></span>
                                            </div>
                                            <div class="dash-rewards-status">
                                                <strong>CORE</strong> <span><img src="{{ asset('assets/images/star-s.svg') }}" alt="missing"></span> Rewards Member
                                            </div>
                                            <div class="dash-rewards-levels">
                                                <div class="dash-level dash-level-active"><img src="{{ asset('assets/images/star-s.svg') }}" alt="missing">
                                                    <p>Core</p>
                                                </div>
                                                <div class="dash-level dash-long"><img src="{{ asset('assets/images/star-l.svg') }}" alt="missing">
                                                    <p>ENTHUSIAST</p>
                                                </div>
                                                <div class="dash-level dash-long"><img src="{{ asset('assets/images/star-f.svg') }}" alt="missing">
                                                    <p>ICON</p>
                                                </div>
                                            </div>
                                            <div class="dash-rewards-box">
                                                <strong>$0</strong>
                                                <span>in rewards available.<br><small>Rewards are redeemed in checkout.</small></span>
                                            </div>
                                        </div>

                                        <!-- Rewards Credit Cards -->
                                        {{-- <div class="dash-card">
                                            <div class="dash-card-header">
                                                <span><img src="{{ asset('assets/images/req.svg') }}" alt="missing"> Rewards Credit Cards</span>
                                        <span><img src="{{ asset('assets/images/slide-right.png') }}" alt="missing"></span>
                                    </div>
                                    <div class="dash-credit-card">
                                        <p>Apply for a <strong>Gap Good Rewards Credit Card</strong> and earn 5 points per $1 spent.*</p>
                                        <br>
                                        <button class="dash-btn">APPLY</button>
                                        <p class="dash-note">*Pending approval</p>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            {{-- purchase-history Blade snippet (drop-in). NOTE: this script DOES NOT change #purchase-history display. --}}
            <div class="side-content-tabs" id="purchase-history" style="display:none">
                <div class="side-inner-content-main">
                    <div class="side-inner-content resource-content">
                        <div class="dash-card">
                            <div class="dash-card-header">
                                <span><img src="{{ asset('assets/images/pay-icon.svg') }}" alt="missing"> Purchase History</span>
                            </div>

                            {{-- Dynamic container: JavaScript will populate this .purchase-history element --}}
                            <div class="purchase-history">
                                <!-- Content injected here by JS -->
                            </div>

                            {{-- no data card (kept hidden by default). JS will show it only when there are no orders. --}}
                            <div class="not-data-card" style="display:none; margin-top:20px;">
                                <div class="no-data-head">
                                    <h1>Purchase History</h1>
                                </div>
                                <div class="no-data-body">
                                    <!-- SVG -->
                                    <svg width="135" height="120" xmlns="http://www.w3.org/2000/svg">
                                        <title>There are no orders from the past 13 months</title>
                                        <g fill="none" fill-rule="evenodd">
                                            <circle fill="#F4F4F4" cx="60" cy="60" r="60"></circle>
                                        </g>
                                    </svg>
                                </div>
                                <div class="no-data-footer">
                                    <h2>No Recent Purchases</h2>
                                    <p>Your purchase history shows all of your online purchases from the past 13 months. Purchases placed when you weren't signed in aren't included.</p>
                                </div>
                                <div class="no-data-action-sec">
                                    <p><strong>Need to look up a Guest order?</strong></p>
                                    <p class="action-guest" data-target="guest-form">Visit Guest Order Lookup</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <script>
                (function() {
                    const productImageBase = "{{ asset('assets/images/products') }}".replace(/\/$/, '');
                    const fallbackImage = "{{ asset('assets/images/about-head.jpg') }}";

                    function safeText(x, fallback = '') {
                        return (x === null || x === undefined) ? fallback : String(x);
                    }

                    function formatCurrency(value) {
                        if (value === null || value === undefined) return '$0.00';
                        const n = Number(value);
                        return isNaN(n) ? ('$' + value) : ('$' + n.toFixed(2));
                    }

                    function imgSrcForProduct(product) {
                        try {
                            if (!product) return fallbackImage;
                            if (Array.isArray(product.images) && product.images.length && product.images[0]) {
                                return productImageBase + '/' + product.images[0];
                            }
                        } catch (e) {}
                        return fallbackImage;
                    }

                    function displayPriceForProduct(product, fallbackPrice) {
                        try {
                            if (product && (product.compare_price || product.price)) {
                                return (product.compare_price || product.price).toString();
                            }
                            if (fallbackPrice != null) return fallbackPrice.toString();
                        } catch (e) {}
                        return '0.00';
                    }

                    function capitalize(s) {
                        return s ? (s.charAt(0).toUpperCase() + s.slice(1)) : '';
                    }

                    // Global toggle used by other inline usages (keeps compatibility)
                    window.toggleDetails = function(id) {
                        try {
                            const el = document.getElementById(id);
                            if (!el) return;
                            const computed = getComputedStyle(el).display;
                            if (computed === 'none') {
                                el.style.display = 'block'; // <- explicit show
                            } else {
                                el.style.display = 'none'; // <- explicit hide
                            }
                        } catch (e) {
                            console.error('toggleDetails error', e);
                        }
                    };

                    function createEl(tag, opts = {}) {
                        const el = document.createElement(tag);
                        if (opts.className) el.className = opts.className;
                        if (opts.text) el.textContent = opts.text;
                        if (opts.html) el.innerHTML = opts.html;
                        if (opts.attrs) Object.keys(opts.attrs).forEach(k => el.setAttribute(k, opts.attrs[k]));
                        return el;
                    }

                    // async function getOrders() {
                    //     try {
                    //         const resp = await fetch("{{ route('user.orders') }}", {
                    //             method: 'GET',
                    //             headers: {
                    //                 'X-Requested-With': 'XMLHttpRequest',
                    //                 'Accept': 'application/json'
                    //             },
                    //             credentials: 'include'
                    //         });
                    //         const result = await resp.json();

                    //         const fullContainer = document.querySelector("#purchase-history .purchase-history");
                    //         const noDataCard = document.querySelector("#purchase-history .not-data-card");
                    //         const previewContainer = document.querySelector(".persnal-left .dash-purchase-history");

                    //         if (!fullContainer) {
                    //             console.warn('purchase-history container not found');
                    //             return;
                    //         }

                    //         fullContainer.innerHTML = '';
                    //         if (previewContainer) previewContainer.innerHTML = '';

                    //         if (!result || !result.status || !Array.isArray(result.data) || result.data.length === 0) {
                    //             if (noDataCard) noDataCard.style.display = 'block';
                    //             fullContainer.innerHTML = '<div class="no-orders-msg">You have no recent orders to track.</div>';
                    //             return;
                    //         } else {
                    //             if (noDataCard) noDataCard.style.display = 'none';
                    //         }

                    //         const orders = result.data;

                    //         orders.forEach((order, idx) => {
                    //             try {
                    //                 const purchaseCard = createEl('div', {
                    //                     className: 'purchase-card'
                    //                 });

                    //                 const summary = createEl('div', {
                    //                     className: 'purchase-summary'
                    //                 });
                    //                 const detailsId = 'order-' + (order.id ?? idx);

                    //                 const spanOrderNumber = createEl('span', {
                    //                     className: 'purchase-order-number',
                    //                     text: `Order #${order.id ?? ''}`
                    //                 });
                    //                 const spanStatus = createEl('span', {
                    //                     className: 'purchase-status ' + (order.status ? order.status.toString().toLowerCase() : ''),
                    //                     text: capitalize(order.status) || 'Unknown'
                    //                 });
                    //                 const spanTotal = createEl('span', {
                    //                     className: 'purchase-total',
                    //                     text: formatCurrency(order.total_amount)
                    //                 });

                    //                 summary.appendChild(spanOrderNumber);
                    //                 summary.appendChild(spanStatus);
                    //                 summary.appendChild(spanTotal);

                    //                 if (summary && typeof summary.addEventListener === 'function') {
                    //                     summary.addEventListener('click', () => toggleDetails(detailsId));
                    //                 }

                    //                 const details = createEl('div', {
                    //                     className: 'purchase-details'
                    //                 });
                    //                 details.id = detailsId;
                    //                 details.style.display = 'none'; // hidden initially

                    //                 const detailsTitle = createEl('h3', {
                    //                     className: 'purchase-details-title',
                    //                     text: 'Order Details'
                    //                 });
                    //                 details.appendChild(detailsTitle);

                    //                 const itemsUl = createEl('ul', {
                    //                     className: 'purchase-items'
                    //                 });

                    //                 const bundleGroups = {};
                    //                 const singles = [];

                    //                 if (Array.isArray(order.products)) {
                    //                     order.products.forEach(pe => {
                    //                         if (!pe) return;
                    //                         if (pe.type === 'bundle') {
                    //                             const bid = String(pe.bundle_id ?? 'bundle-unknown');
                    //                             bundleGroups[bid] = bundleGroups[bid] || [];
                    //                             bundleGroups[bid].push(pe);
                    //                         } else {
                    //                             singles.push(pe);
                    //                         }
                    //                     });
                    //                 }

                    //                 singles.forEach(pe => itemsUl.appendChild(createProductListItem(pe)));

                    //                 // --- Replace the original bundle rendering loop with this block ---
                    //                 Object.keys(bundleGroups).forEach(bundleKey => {
                    //                     const group = bundleGroups[bundleKey];
                    //                     if (!group || !group.length) return;

                    //                     const firstEntry = group[0];
                    //                     const defaultProduct = firstEntry.product || {};

                    //                     const li = createEl('li', {
                    //                         className: 'purchase-item'
                    //                     });

                    //                     const itemInfo = createEl('div', {
                    //                         className: 'item-info'
                    //                     });
                    //                     itemInfo.style.cursor = 'pointer';

                    //                     const img = createEl('img', {
                    //                         className: 'item-image',
                    //                         attrs: {
                    //                             src: imgSrcForProduct(defaultProduct),
                    //                             alt: safeText(defaultProduct.name, 'Bundle')
                    //                         }
                    //                     });

                    //                     const nameDiv = createEl('div');
                    //                     const nameSpan = createEl('span', {
                    //                         className: 'item-name',
                    //                         text: safeText(defaultProduct.name, 'Bundle')
                    //                     });
                    //                     nameDiv.appendChild(nameSpan);

                    //                     itemInfo.appendChild(img);
                    //                     itemInfo.appendChild(nameDiv);

                    //                     const priceSpan = createEl('span', {
                    //                         className: 'item-price'
                    //                     });
                    //                     const qtySpan = createEl('span', {
                    //                         className: 'item-qty',
                    //                         text: `Qty: ${firstEntry.qty ?? 1} (Bundle)`
                    //                     });
                    //                     priceSpan.appendChild(qtySpan);
                    //                     priceSpan.appendChild(
                    //                         document.createTextNode(' ' + formatCurrency(firstEntry.price))
                    //                     );

                    //                     // priceSpan.appendChild(document.createTextNode(' ' + formatCurrency(displayPriceForProduct(defaultProduct, firstEntry.price))));
                    //                     // priceSpan.appendChild(
                    //                     //     document.createTextNode(' ' + formatCurrency(firstEntry.price))
                    //                     // );

                    //                     li.appendChild(itemInfo);
                    //                     li.appendChild(priceSpan);

                    //                     // ---------- NEW: dropdown for bundle children ----------
                    //                     const select = createEl('select', {
                    //                         className: 'bundle-select',
                    //                         attrs: {
                    //                             'aria-label': 'Choose item from bundle'
                    //                         }
                    //                     });

                    //                     group.forEach((childEntry, idx) => {
                    //                         const child = childEntry.product || {};
                    //                         const opt = createEl('option', {
                    //                             text: safeText(child.name, `Item ${idx + 1}`)
                    //                         });
                    //                         // store useful data on the option for quick access
                    //                         opt.value = idx;
                    //                         opt.dataset.productImage = imgSrcForProduct(child);
                    //                         opt.dataset.productName = safeText(child.name);
                    //                         opt.dataset.productPrice = displayPriceForProduct(child, childEntry.price);
                    //                         select.appendChild(opt);
                    //                     });

                    //                     // initialize with first option selected (already reflected by defaultProduct above)
                    //                     select.selectedIndex = 0;

                    //                     select.addEventListener('change', () => {
                    //                         const opt = select.options[select.selectedIndex];
                    //                         try {
                    //                             img.src = opt.dataset.productImage || fallbackImage;
                    //                             img.alt = opt.dataset.productName || img.alt;
                    //                             nameSpan.textContent = opt.dataset.productName || nameSpan.textContent;

                    //                             // update price display while keeping the qty span
                    //                             priceSpan.innerHTML = '';
                    //                             priceSpan.appendChild(qtySpan);
                    //                             priceSpan.appendChild(document.createTextNode(' ' + formatCurrency(opt.dataset.productPrice || '0.00')));

                    //                             // optionally add visual hint for chosen option (not required)
                    //                             // Array.from(select.options).forEach(o => o.removeAttribute('data-selected'));
                    //                             // select.options[select.selectedIndex].setAttribute('data-selected', '1');
                    //                         } catch (e) {
                    //                             console.error('bundle select change error', e);
                    //                         }
                    //                     });

                    //                     // append select to the name area (so dropdown appears near the name)
                    //                     nameDiv.appendChild(select);

                    //                     // if you still want to toggle something when itemInfo is clicked, keep a simple toggle:
                    //                     if (itemInfo && typeof itemInfo.addEventListener === 'function') {
                    //                         itemInfo.addEventListener('click', (ev) => {
                    //                             ev.stopPropagation();
                    //                             // no nested UL to toggle anymore; you can add custom behavior here if desired
                    //                             // e.g., focus the select when clicking the item
                    //                             try {
                    //                                 select.focus();
                    //                             } catch (e) {}
                    //                         });
                    //                     }

                    //                     itemsUl.appendChild(li);
                    //                 });
                    //                 // --- end replacement ---


                    //                 details.appendChild(itemsUl);
                    //                 purchaseCard.appendChild(summary);
                    //                 purchaseCard.appendChild(details);
                    //                 fullContainer.appendChild(purchaseCard);

                    //                 // preview logic (unchanged)
                    //                 const previewContainer = document.querySelector(".persnal-left .dash-purchase-history");
                    //                 if (previewContainer && idx < 3) {
                    //                     try {
                    //                         const pCard = createEl('div', {
                    //                             className: 'purchase-card'
                    //                         });
                    //                         const pSummary = summary.cloneNode(true);
                    //                         if (pSummary && typeof pSummary.addEventListener === 'function') {
                    //                             pSummary.addEventListener('click', () => toggleDetails(detailsId));
                    //                         } else if (pSummary) {
                    //                             pSummary.onclick = function() {
                    //                                 toggleDetails(detailsId);
                    //                             };
                    //                         }
                    //                         pCard.appendChild(pSummary);
                    //                         previewContainer.appendChild(pCard);
                    //                     } catch (e) {
                    //                         console.warn('preview append error', e);
                    //                     }
                    //                 }

                    //             } catch (renderErr) {
                    //                 console.error('Render error for order', order && order.id, renderErr);
                    //             }
                    //         });

                    //     } catch (err) {
                    //         console.error('getOrders error', err);
                    //         const fullContainer = document.querySelector("#purchase-history .purchase-history");
                    //         if (fullContainer) fullContainer.innerHTML = '<div class="error-msg">Error loading orders.</div>';
                    //     }
                    // }
                    async function getOrders() {
                        try {
                            const resp = await fetch("{{ route('user.orders') }}", {
                                method: 'GET',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json'
                                },
                                credentials: 'include'
                            });
                            const result = await resp.json();

                            const fullContainer = document.querySelector("#purchase-history .purchase-history");
                            const noDataCard = document.querySelector("#purchase-history .not-data-card");
                            const previewContainer = document.querySelector(".persnal-left .dash-purchase-history");

                            if (!fullContainer) {
                                console.warn('purchase-history container not found');
                                return;
                            }

                            fullContainer.innerHTML = '';
                            if (previewContainer) previewContainer.innerHTML = '';

                            if (!result || !result.status || !Array.isArray(result.data) || result.data.length === 0) {
                                if (noDataCard) noDataCard.style.display = 'block';
                                fullContainer.innerHTML = '<div class="no-orders-msg">You have no recent orders to track.</div>';
                                return;
                            } else {
                                if (noDataCard) noDataCard.style.display = 'none';
                            }

                            const orders = result.data;

                            // base path for bangle color images (public/assets/images/bangle-box)
                            const bangleBase = "{{ asset('assets/images/bangle-box') }}";
                            const localFallbackImage = (typeof fallbackImage !== 'undefined') ? fallbackImage : '/assets/images/default.jpg';
                            const makeBangleImg = (filename) => {
                                if (!filename) return localFallbackImage;
                                return `${bangleBase}/${encodeURIComponent(filename)}`;
                            };

                            orders.forEach((order, idx) => {
                                try {
                                    const purchaseCard = createEl('div', {
                                        className: 'purchase-card'
                                    });

                                    const summary = createEl('div', {
                                        className: 'purchase-summary'
                                    });
                                    const detailsId = 'order-' + (order.id ?? idx);

                                    const spanOrderNumber = createEl('span', {
                                        className: 'purchase-order-number',
                                        text: `Order #${order.id ?? ''}`
                                    });
                                    const spanStatus = createEl('span', {
                                        className: 'purchase-status ' + (order.status ? order.status.toString().toLowerCase() : ''),
                                        text: capitalize(order.status) || 'Unknown'
                                    });
                                    const spanTotal = createEl('span', {
                                        className: 'purchase-total',
                                        text: formatCurrency(order.total_amount)
                                    });

                                    summary.appendChild(spanOrderNumber);
                                    summary.appendChild(spanStatus);
                                    summary.appendChild(spanTotal);

                                    if (summary && typeof summary.addEventListener === 'function') {
                                        summary.addEventListener('click', () => toggleDetails(detailsId));
                                    }

                                    const details = createEl('div', {
                                        className: 'purchase-details'
                                    });
                                    details.id = detailsId;
                                    details.style.display = 'none';

                                    const detailsTitle = createEl('h3', {
                                        className: 'purchase-details-title',
                                        text: 'Order Details'
                                    });
                                    details.appendChild(detailsTitle);

                                    const itemsUl = createEl('ul', {
                                        className: 'purchase-items'
                                    });

                                    const bundleGroups = {};
                                    const bangleGroups = {};
                                    const singles = [];

                                    if (Array.isArray(order.products)) {
                                        order.products.forEach(pe => {
                                            if (!pe) return;
                                            if (pe.type === 'bundle') {
                                                const bid = String(pe.bundle_id ?? 'bundle-unknown');
                                                bundleGroups[bid] = bundleGroups[bid] || [];
                                                bundleGroups[bid].push(pe);
                                            } else if (pe.type === 'bangle_box') {
                                                const key = 'bangle-' + String(pe.cart_id ?? Math.random().toString(36).slice(2, 9));
                                                bangleGroups[key] = bangleGroups[key] || [];
                                                bangleGroups[key].push(pe);
                                            } else {
                                                singles.push(pe);
                                            }
                                        });
                                    }

                                    // render normal single products unchanged
                                    singles.forEach(pe => itemsUl.appendChild(createProductListItem(pe)));

                                    // render bundles unchanged (keeps your existing bundle UI)
                                    Object.keys(bundleGroups).forEach(bundleKey => {
                                        const group = bundleGroups[bundleKey];
                                        if (!group || !group.length) return;

                                        const firstEntry = group[0];
                                        const defaultProduct = firstEntry.product || {};

                                        const li = createEl('li', {
                                            className: 'purchase-item'
                                        });

                                        const itemInfo = createEl('div', {
                                            className: 'item-info'
                                        });
                                        itemInfo.style.cursor = 'pointer';

                                        const img = createEl('img', {
                                            className: 'item-image',
                                            attrs: {
                                                src: imgSrcForProduct(defaultProduct),
                                                alt: safeText(defaultProduct.name, 'Bundle')
                                            }
                                        });

                                        const nameDiv = createEl('div');
                                        const nameSpan = createEl('span', {
                                            className: 'item-name',
                                            text: safeText(defaultProduct.name, 'Bundle')
                                        });
                                        nameDiv.appendChild(nameSpan);

                                        itemInfo.appendChild(img);
                                        itemInfo.appendChild(nameDiv);

                                        const priceSpan = createEl('span', {
                                            className: 'item-price'
                                        });
                                        const qtySpan = createEl('span', {
                                            className: 'item-qty',
                                            text: `Qty: ${firstEntry.qty ?? 1} (Bundle)`
                                        });
                                        priceSpan.appendChild(qtySpan);
                                        priceSpan.appendChild(document.createTextNode(' ' + formatCurrency(firstEntry.price)));

                                        li.appendChild(itemInfo);
                                        li.appendChild(priceSpan);

                                        const select = createEl('select', {
                                            className: 'bundle-select',
                                            attrs: {
                                                'aria-label': 'Choose item from bundle'
                                            }
                                        });

                                        group.forEach((childEntry, ci) => {
                                            const child = childEntry.product || {};
                                            const opt = createEl('option', {
                                                text: safeText(child.name, `Item ${ci + 1}`)
                                            });
                                            opt.value = ci;
                                            opt.dataset.productImage = imgSrcForProduct(child);
                                            opt.dataset.productName = safeText(child.name);
                                            opt.dataset.productPrice = displayPriceForProduct(child, childEntry.price);
                                            select.appendChild(opt);
                                        });

                                        select.selectedIndex = 0;

                                        select.addEventListener('change', () => {
                                            const opt = select.options[select.selectedIndex];
                                            try {
                                                img.src = opt.dataset.productImage || localFallbackImage;
                                                img.alt = opt.dataset.productName || img.alt;
                                                nameSpan.textContent = opt.dataset.productName || nameSpan.textContent;
                                                priceSpan.innerHTML = '';
                                                priceSpan.appendChild(qtySpan);
                                                priceSpan.appendChild(document.createTextNode(' ' + formatCurrency(opt.dataset.productPrice || '0.00')));
                                            } catch (e) {
                                                console.error('bundle select change error', e);
                                            }
                                        });

                                        nameDiv.appendChild(select);

                                        if (itemInfo && typeof itemInfo.addEventListener === 'function') {
                                            itemInfo.addEventListener('click', (ev) => {
                                                ev.stopPropagation();
                                                try {
                                                    select.focus();
                                                } catch (e) {}
                                            });
                                        }

                                        itemsUl.appendChild(li);
                                    });

                                    // ---------- NEW: render each bangle cart item exactly like bundle UI, with color dropdown ----------
                                    // ---------- REPLACE bangle rendering: use identical DOM/classes as bundle ----------
                                    Object.keys(bangleGroups).forEach(bKey => {
                                        const group = bangleGroups[bKey];
                                        if (!group || !group.length) return;

                                        const entry = group[0];
                                        const bangle = entry.bangle_box || {};
                                        const colors = Array.isArray(entry.colors) ? entry.colors : [];

                                        // li.purchase-item (same as bundle)
                                        const li = createEl('li', {
                                            className: 'purchase-item'
                                        });

                                        // left column: item-info
                                        const itemInfo = createEl('div', {
                                            className: 'item-info'
                                        });
                                        itemInfo.style.cursor = 'pointer';

                                        // image: show the color image (instead of product image)
                                        const initialColor = colors[0] || null;
                                        const initialImg = initialColor ? makeBangleImg(initialColor.image) : localFallbackImage;
                                        const img = createEl('img', {
                                            className: 'item-image',
                                            attrs: {
                                                src: initialImg,
                                                alt: safeText(initialColor ? (initialColor.name ?? initialColor.color_name) : 'Bangle Color')
                                            }
                                        });

                                        // nameDiv: contains item-name (we'll show color name here) and then the dropdown (bundle-select)
                                        const nameDiv = createEl('div');
                                        const nameSpan = createEl('span', {
                                            className: 'item-name',
                                            // show color name here exactly where bundle shows product name
                                            text: initialColor ? safeText(initialColor.name ?? initialColor.color_name) : safeText(`Bangle Box`)
                                        });
                                        nameDiv.appendChild(nameSpan);

                                        // build select (use exact class "bundle-select" so it picks up your bundle styling)
                                        const select = createEl('select', {
                                            className: 'bundle-select bangle-color-select',
                                            attrs: {
                                                'aria-label': 'Choose bangle color'
                                            }
                                        });

                                        if (colors.length) {
                                            colors.forEach((c, i) => {
                                                const imageUrl = makeBangleImg(c.image ?? c.image);
                                                const opt = createEl('option', {
                                                    text: safeText(c.name ?? c.color_name, `Color ${i + 1}`)
                                                });
                                                // value is image URL for easier switching
                                                opt.value = imageUrl;
                                                opt.dataset.colorName = safeText(c.name ?? c.color_name ?? '');
                                                select.appendChild(opt);
                                            });
                                            // choose first by default
                                            select.selectedIndex = 0;
                                        } else {
                                            const opt = createEl('option', {
                                                text: 'No colors'
                                            });
                                            opt.value = '';
                                            select.appendChild(opt);
                                        }

                                        // append select right under the name (same place bundle puts the dropdown)
                                        nameDiv.appendChild(select);

                                        // assemble left column exactly like bundle: image then nameDiv
                                        itemInfo.appendChild(img);
                                        itemInfo.appendChild(nameDiv);

                                        // right column: item-price (same class as bundle)
                                        const priceSpan = createEl('span', {
                                            className: 'item-price'
                                        });

                                        // size label shown above quantity (we put it inside priceSpan so it sits above qty like you requested)
                                        const sizeDiv = createEl('div', {
                                            className: 'bangle-size-label',
                                            text: bangle.size ? `Box Size - ${bangle.size} Colours` : ''
                                        });
                                        // qty span (same class as bundle)
                                        const banglesize = createEl('span', {
                                            className: 'item-qty',
                                            text: `Bangle Size: ${entry.bangle_size.size ?? ''}`
                                        });
                                        const qtySpan = createEl('span', {
                                            className: 'item-qty',
                                            text: `Qty: ${entry.qty ?? 1}`
                                        });

                                        priceSpan.appendChild(sizeDiv);
                                        priceSpan.appendChild(banglesize);
                                        priceSpan.appendChild(qtySpan);

                                        priceSpan.appendChild(document.createTextNode(' ' + formatCurrency(entry.line_total)));

                                        // append left + right into li in same order bundle uses
                                        li.appendChild(itemInfo);
                                        li.appendChild(priceSpan);
                                        itemsUl.appendChild(li);

                                        // when select changes: update image + name text above (do not change size text)
                                        select.addEventListener('change', () => {
                                            try {
                                                const opt = select.options[select.selectedIndex];
                                                const newSrc = opt.value || localFallbackImage; // using value as the image URL
                                                const newName = opt.dataset.colorName || opt.textContent || '';
                                                img.src = newSrc;
                                                img.alt = newName || img.alt;
                                                // update nameSpan (color name shows in the same place bundle shows product name)
                                                nameSpan.textContent = newName || nameSpan.textContent;
                                            } catch (e) {
                                                console.error('bangle select change error', e);
                                            }
                                        });

                                        // bundle-like UX: clicking item focuses select
                                        if (itemInfo && typeof itemInfo.addEventListener === 'function') {
                                            itemInfo.addEventListener('click', (ev) => {
                                                ev.stopPropagation();
                                                try {
                                                    select.focus();
                                                } catch (e) {}
                                            });
                                        }
                                    });


                                    // append details
                                    details.appendChild(itemsUl);
                                    purchaseCard.appendChild(summary);
                                    purchaseCard.appendChild(details);
                                    fullContainer.appendChild(purchaseCard);

                                    // preview logic (unchanged)
                                    if (previewContainer && idx < 3) {
                                        try {
                                            const pCard = createEl('div', {
                                                className: 'purchase-card'
                                            });
                                            const pSummary = summary.cloneNode(true);
                                            if (pSummary && typeof pSummary.addEventListener === 'function') {
                                                pSummary.addEventListener('click', () => toggleDetails(detailsId));
                                            } else if (pSummary) {
                                                pSummary.onclick = function() {
                                                    toggleDetails(detailsId);
                                                };
                                            }
                                            pCard.appendChild(pSummary);
                                            previewContainer.appendChild(pCard);
                                        } catch (e) {
                                            console.warn('preview append error', e);
                                        }
                                    }

                                } catch (renderErr) {
                                    console.error('Render error for order', order && order.id, renderErr);
                                }
                            });

                        } catch (err) {
                            console.error('getOrders error', err);
                            const fullContainer = document.querySelector("#purchase-history .purchase-history");
                            if (fullContainer) fullContainer.innerHTML = '<div class="error-msg">Error loading orders.</div>';
                        }
                    }

                    function createProductListItem(prodEntry) {
                        const product = prodEntry.product || {};
                        const li = createEl('li', {
                            className: 'purchase-item'
                        });

                        const info = createEl('div', {
                            className: 'item-info'
                        });
                        const img = createEl('img', {
                            className: 'item-image',
                            attrs: {
                                src: imgSrcForProduct(product),
                                alt: safeText(product.name, 'product')
                            }
                        });
                        const nameWrap = createEl('div');
                        nameWrap.appendChild(createEl('span', {
                            className: 'item-name',
                            text: safeText(product.name, 'Item')
                        }));

                        info.appendChild(img);
                        info.appendChild(nameWrap);

                        const priceSpan = createEl('span', {
                            className: 'item-price'
                        });
                        priceSpan.appendChild(createEl('span', {
                            className: 'item-qty',
                            text: `Qty: ${prodEntry.qty ?? 1}`
                        }));
                        // priceSpan.appendChild(document.createTextNode(' ' + formatCurrency(displayPriceForProduct(product, prodEntry.price))));
                        priceSpan.appendChild(
                            document.createTextNode(' ' + formatCurrency(prodEntry.line_total))
                        );
                        li.appendChild(info);
                        li.appendChild(priceSpan);

                        return li;
                    }

                    function onReady(fn) {
                        if (document.readyState === 'loading') {
                            document.addEventListener('DOMContentLoaded', fn);
                        } else {
                            fn();
                        }
                    }

                    onReady(function() {
                        getOrders();
                    });
                })();
            </script>





            <div class="side-content-tabs" id="rewards" style="display:none">
                <div class="side-inner-content-main">
                    <div class="side-inner-content resource-content">
                        <div class="dash-card ">

                            <div class="dash-rewards-status width-set">
                                <h1>Start Shopping</h1>
                            </div>

                            <!-- <div class="dash-rewards-levels width-set">
                                <div class="dash-level dash-level-active"><img src="{{ asset('assets/images/star-s.svg') }}" alt="missing">
                                    <p>Core</p>
                                </div>
                                <div class="dash-level dash-long"><img src="{{ asset('assets/images/star-l.svg') }}" alt="missing">
                                    <p>ENTHUSIAST</p>
                                </div>
                                <div class="dash-level dash-long"><img src="{{ asset('assets/images/star-f.svg') }}" alt="missing">
                                    <p>ICON</p>
                                </div>
                            </div> -->
                            <div class="dash-rewards-status reward-des width-set account-chart">
                                <!-- <p>Spend $500 or become a Cardmember by the end of the year to get all the benefits of Enthusiast</p> -->
                                <progress id="file" value="32" max="100"> 32% </progress>
                                <p>$0/$500</p>
                            </div>


                            <div class="your-benifits-section">
                                <div class="benifit-head">
                                    <h1>Your Featured Benefits**</h1>
                                </div>
                                <div class="benifit-body">
                                    <div class="benifit-card" style="width: 100% important;">
                                        <div class="benifit-card-img">
                                            <img src="{{ asset('assets/images/benifit-1.svg') }}" alt="missing">
                                        </div>
                                        <div class="benifit-card-head">
                                            <p><strong>You have {{ Auth::user()->total_points ?? 0 }} rewards points</strong></p>
                                        </div>
                                        <div class="benifit-card-des">
                                            <p>100 points = $1 in rewards</p>
                                            <!-- <p>You earn across our family of brands.<br>100 points = $1 in rewards</p> -->
                                        </div>
                                    </div>

                                    <!-- <div class="benifit-card">
                                        <div class="benifit-card-img">
                                            <img src="{{ asset('assets/images/benifit-3.svg') }}" alt="missing">

                                        </div>
                                        <div class="benifit-card-head">
                                            <p><strong>FREE SHIPPING</strong></p>
                                        </div>
                                        <div class="benifit-card-des">
                                            <p>You have {{ Auth::user()->total_shippings ?? 0 }} free shippings</p>
                                        </div>
                                    </div> -->
                                    <!-- <div class="benifit-card">
                                        <div class="benifit-card-img">
                                            <img src="{{ asset('assets/images/benifit-3.svg') }}" alt="missing">
                                        </div>
                                        <div class="benifit-card-head">
                                            <p><strong>FREE SHIPPING</strong></p>
                                        </div>
                                        <div class="benifit-card-des">
                                            <p>Online orders get to you fast. Get free fast shipping on all orders $50+.</p>
                                        </div>
                                    </div> -->
                                </div>
                            </div>




                        </div>

                        {{-- <div class="not-data-card">
                                                        <div class="no-data-head">
                                                            <h1>Purchase History</h1>
                                                        </div>
                                                        <div class="no-data-body">
                                                            <svg width="135" height="120" xmlns="http://www.w3.org/2000/svg" class="mx-auto my-12 box-border h-[120px] w-[135px] max-w-full text-center text-[100%] font-normal text-[#333]"><title>There are no orders from the past 13 months</title><g fill="none" fill-rule="evenodd"><circle fill="#F4F4F4" cx="60" cy="60" r="60"></circle><path fill="#C7C7C7" d="M15 8h116v46H15z"></path><path stroke="#000" fill="#FFF" d="M19.5 6.5h115v43h-115z"></path><path stroke="#000" fill="#FFF" d="M25.5 11.5h26v32h-26z"></path><path fill-opacity=".4" fill="#D9D9D9" d="M58 11h47v4H58z"></path><path fill-opacity=".6" fill="#D9D9D9" d="M58 19h34v4H58z"></path><path fill="#D9D9D9" d="M58 34h30v4H58zM58 41h18v4H58zM111 41h18v4h-18zM111 33h18v4h-18z"></path><g><path fill="#C7C7C7" d="M15 64h116v46H15z"></path><path stroke="#000" fill="#FFF" d="M19.5 62.5h115v43h-115z"></path><path stroke="#000" fill="#FFF" d="M25.5 67.5h26v32h-26z"></path><path fill-opacity=".4" fill="#D9D9D9" d="M58 67h47v4H58z"></path><path fill-opacity=".6" fill="#D9D9D9" d="M58 75h34v4H58z"></path><path fill-opacity=".8" fill="#D9D9D9" d="M58 90h30v4H58z"></path><path fill="#D9D9D9" d="M58 97h18v4H58zM111 97h18v4h-18z"></path><path fill-opacity=".8" fill="#D9D9D9" d="M111 89h18v4h-18z"></path></g></g></svg>
                                                        </div>
                                                        <div class="no-data-footer">
                                                            <h2>No Recent Purchases</h2>
                                                            <p>Your purchase history shows all of your online purchases from the past 13 months. Purchases placed when you weren't signed in aren't included.</p>
                                                        </div>
                                                        <div class="no-data-action-sec">
                                                            <p><strong>Need to look up a Guest order?</strong></p>
                                                            <p class="action-guest" data-target="guest-form">Visit Guest Order Lookup</p>
                                                        </div>
                                            </div> --}}
                    </div>
                </div>
            </div>



            <div class="side-content-tabs" id="guest-form" style="display:none">
                <div class="side-inner-content-main">
                    <div class="side-inner-content resource-content">
                        <div class="guest-form-main">
                            <div class="guest-form-head">
                                <h1>Guest Order Lookup</h1>
                                <p><strong>Not seeing an order in your order history?</strong> Look up a single order by entering the order number and email address used to place the order.</p>
                            </div>
                            <div class="guest-form-body">
                                <form>
                                    <div class="row">
                                        <div class="col-12 mt-4">
                                            <div class="form-group">
                                                <input type="email" placeholder="Email Address">
                                            </div>
                                        </div>
                                        <div class="col-12 mt-4">
                                            <div class="form-group">
                                                <input type="number" placeholder="Order Number">
                                            </div>
                                        </div>

                                        <p class="mt-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Your order number is included in the email you received when you placed your order. If you no longer have this email, please call for assistance.">
                                            Where can I find my order number?
                                        </p>


                                    </div>
                                </form>

                            </div>
                            <div class="guest-form-footer mt-3">
                                <Button class="btn look-order-btn">
                                    Look For Order
                                </Button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="side-content-tabs" id="gift-card" style="display:none">
                <div class="side-inner-content-main">
                    <div class="side-inner-content resource-content">
                        <div class="dash-card ">
                            <!-- <div class="dash-rewards-status width-set">
                    <h1>My Wishlist</h1>
                </div> -->
                            <div class="dash-rewards-status reward-des width-set account-chart no-wishlist-message">
                                <p>Add Product in Wish List Right now No Product is Added</p>
                                <br>
                                <p>Have questions?
                                    <br> <a href="{{ url('contact-us') }}">View Frequently Asked Questions</a>
                                </p>
                            </div>
                        </div>

                        <div class="main-wishlist-section">
                            <div class="dash-rewards-status width-set mb-3">
                                <h1>My Wishlist</h1>
                            </div>
                            <div class="earing-main-grid" id="wishlist-items">
                                <!-- Products will be appended here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="side-content-tabs" id="gift-card-set" style="display:none">
                <div class="side-inner-content-main">
                    <div class="side-inner-content resource-content">
                        <div class="dash-card">
                            <div class="dash-rewards-status width-set mb-3">
                                <h1>My Gift Cards</h1>
                            </div>

                            <!-- No Data Message -->
                            <div class="dash-rewards-status reward-des width-set account-chart no-giftcard-message" style="display:none;">
                                <p>You currently have no gift cards.</p>
                            </div>

                            <!-- Gift Card List -->
                            <div class="main-giftcard-section">
                                <div class="giftcard-list" id="giftcard-items">


                                </div> <!-- end giftcard-list -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>




            <div class="side-content-tabs" id="personal-info" style="display:none">
                <div class="side-inner-content-main">
                    <div class="side-inner-content resource-content">
                        <div class="dash-card ">

                            <div class="dash-rewards-status">
                                <h1>Personal Information</h1>
                            </div>
                            @php $user = auth()->user(); @endphp

                            <meta name="csrf-token" content="{{ csrf_token() }}">

                            <div class="personal-main-fields">

                                {{-- First Name (inline editable) --}}
                                <div class="p-3 mb-4 field-row" id="firstNameRow" data-field="first_name">
                                    <div class="label">First Name</div>
                                    <div class="main-field">
                                        <span class="value" id="firstNameValue">{{ $user->first_name ?? '' }}</span>
                                        <span class="edit-btn" onclick="editField('firstName')">Edit</span>
                                    </div>
                                </div>

                                {{-- Email (opens verify modal) --}}
                                <div class="p-3 mb-4 field-row" id="emailRow" data-field="email">
                                    <div class="label">Email Address</div>
                                    <div class="main-field">
                                        <span class="value" id="emailValue">{{ $user->email ?? '' }}</span>
                                        <span class="edit-btn" data-bs-toggle="modal" data-bs-target="#verifyModal">Edit</span>
                                    </div>
                                </div>

                                {{-- Mobile (opens verify modal) --}}
                                <div class="p-3 mb-4 field-row" id="phoneRow" data-field="phone">
                                    <div class="label">Mobile Number</div>
                                    <div class="main-field">
                                        <span class="value" id="phoneValue">{{ $user->phone ? maskPhone($user->phone) : 'Add phone' }}</span>
                                        <span class="edit-btn" data-bs-toggle="modal" data-bs-target="#verifyModal">Edit</span>
                                    </div>
                                </div>

                                {{-- Birthday (inline editable, MM/DD shown) --}}
                                <div class="p-3 mb-4 field-row" id="birthdayRow" data-field="birthday">
                                    <div class="label">Birthday (MM/DD)</div>
                                    <div class="main-field">
                                        <span class="value" id="birthdayValue">
                                            {{ $user->birthday ? \Carbon\Carbon::parse($user->birthday)->format('m/d') : 'Add Birthday' }}
                                        </span>
                                        <span class="edit-btn" onclick="editField('birthday')">{{ $user->birthday ? 'Edit' : 'Add' }}</span>
                                    </div>
                                    <div class="text-muted" style="font-size:12px;">Add a birthday for redeeming points in store</div>
                                </div>

                                <div class="p-3 mb-4 text-muted" style="font-size:12px;">
                                    Some edits may require identity verification.
                                </div>

                                <!-- existing Verify modal (unchanged) -->
                                <div class="modal fade" id="verifyModal" tabindex="-1">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content p-3">
                                            <div class="modal-header border-0">
                                                <h5 class="modal-title">Identity Verification</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Please select a method to receive a verification code.</p>
                                                <button class="btn btn-outline-dark w-100 mb-2">SEND CODE BY EMAIL</button>
                                                <button class="btn btn-outline-dark w-100">SEND CODE BY TEXT</button>
                                                <p class="text-muted mt-3" style="font-size:12px;">
                                                    By choosing to send code by text you are agreeing to receive text messages via SMS.
                                                    Messages and data rates may apply.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            @php
                            function maskPhone($p){
                            if(!$p) return '';
                            $p = preg_replace('/\D+/', '', $p);
                            if(strlen($p) <= 4) return str_repeat('*', strlen($p));
                                return substr($p, 0, -4) . str_repeat('*', 4);
                                }
                                @endphp

                                </div>
                        </div>
                    </div>
                </div>




                <div class="side-content-tabs" id="save-card" style="display:none">
                    <div class="side-inner-content-main">
                        <div class="side-inner-content resource-content">

                            {{-- no data for no data case--}}

                            <div class="not-data-card">
                                <div class="no-data-head">
                                    <h1>Saved Cards</h1>
                                </div>
                                <div class="no-data-body">
                                    <img src="{{ asset('assets/images/payment-card.png') }}" alt="missing icon" />
                                </div>
                                <div class="no-data-footer">
                                    <p>You currently don't have any payment methods saved</p>
                                </div>
                                <div class="no-data-action-sec">
                                    <p class="action-guest" data-bs-toggle="modal" data-bs-target="#paymentModal"><strong>Add a credit or debit card for a faster checkout experience!</strong></p>

                                </div>
                            </div>



                            <div class="save-card-main-wrrapper" id="cardListWrapper">
                                <!-- Cards will be appended here -->
                                <button class="btn add-card mt-3" data-bs-toggle="modal" data-bs-target="#paymentModal">+ Add Card</button>
                            </div>



                            <div class="modal fade" id="paymentModal" tabindex="-1">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content p-4">

                                        <div class="modal-header border-0">
                                            <h5 class="modal-title">Credit Card Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <form id="cardForm">
                                                @csrf

                                                <!-- Card Number -->
                                                <div class="mb-3">
                                                    <div id="card-number-element" class="form-control border-0 border-bottom rounded-0 shadow-none" style="padding: 12px;"></div>
                                                    <span class="text-danger error" id="error-card-number"></span>
                                                </div>

                                                <!-- Expiry + CVC -->
                                                <div class="row mb-4">
                                                    <div class="col-6">
                                                        <div id="card-expiry-element" class="form-control border-0 border-bottom rounded-0 shadow-none" style="padding: 12px;"></div>
                                                        <span class="text-danger error" id="error-card-expiry"></span>
                                                    </div>
                                                    <div class="col-6">
                                                        <div id="card-cvc-element" class="form-control border-0 border-bottom rounded-0 shadow-none" style="padding: 12px;"></div>
                                                        <span class="text-danger error" id="error-card-cvc"></span>
                                                    </div>
                                                </div>

                                                <!-- Optional Full Name -->
                                                <div class="mb-3">
                                                    <input type="text" id="full_name" name="full_name"
                                                        class="form-control border-0 border-bottom rounded-0 shadow-none"
                                                        placeholder="Full Name (optional)">
                                                    <span class="text-danger error" id="error-full_name"></span>
                                                </div>

                                                <!-- Optional Address -->
                                                <div class="row mb-3">
                                                    <div class="col-8">
                                                        <input type="text" id="street" name="street"
                                                            class="form-control border-0 border-bottom rounded-0 shadow-none"
                                                            placeholder="Street Address (optional)">
                                                        <span class="text-danger error" id="error-street"></span>
                                                    </div>
                                                    <div class="col-4">
                                                        <input type="text" id="apartment" name="apartment"
                                                            class="form-control border-0 border-bottom rounded-0 shadow-none"
                                                            placeholder="Apt # (optional)">
                                                        <span class="text-danger error" id="error-apartment"></span>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-6">
                                                        <input type="text" id="city" name="city"
                                                            class="form-control border-0 border-bottom rounded-0 shadow-none"
                                                            placeholder="City (optional)">
                                                        <span class="text-danger error" id="error-city"></span>
                                                    </div>
                                                    <div class="col-3">
                                                        <select id="state" name="state"
                                                            class="form-select border-0 border-bottom rounded-0 shadow-none">
                                                            <option value="">State</option>
                                                            <option value="CA">CA</option>
                                                            <option value="NY">NY</option>
                                                            <option value="TX">TX</option>
                                                        </select>
                                                        <span class="text-danger error" id="error-state"></span>
                                                    </div>
                                                    <div class="col-3">
                                                        <input type="text" id="zip" name="zip"
                                                            class="form-control border-0 border-bottom rounded-0 shadow-none"
                                                            placeholder="Zip Code (optional)">
                                                        <span class="text-danger error" id="error-zip"></span>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <input type="text" id="phone" name="phone"
                                                        class="form-control border-0 border-bottom rounded-0 shadow-none"
                                                        placeholder="Phone Number (optional)">
                                                    <span class="text-danger error" id="error-phone"></span>
                                                </div>

                                                <!-- Default Checkbox -->
                                                <div class="form-check mb-4">
                                                    <input class="form-check-input" type="checkbox" id="is_default" name="is_default" value="1">
                                                    <label class="form-check-label" for="is_default">Set as default payment</label>
                                                </div>

                                                <!-- Save Button -->
                                                <button type="submit" class="btn w-100"
                                                    style="background:#333; color:#fff; padding:12px;">
                                                    SAVE CARD
                                                </button>
                                            </form>



                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>


                <div class="side-content-tabs" id="shipping-address" style="display:none">
                    <div class="side-inner-content-main">
                        <div class="side-inner-content resource-content">
                            <div class="no-data-head mb-4">
                                <h1>Shipping Addresses</h1>
                            </div>

                            @php
                                $userAddresses = Auth::user()->addresses ?? collect();
                            @endphp

                            <div id="addresses-container">
                                @if($userAddresses->isEmpty())
                                    {{-- No addresses saved --}}
                                    <div class="not-data-card" id="no-addresses-message">
                                        <div class="no-data-body">
                                            <img src="{{ asset('assets/images/address.png') }}" alt="missing icon" />
                                        </div>
                                        <div class="no-data-footer">
                                            <p>You currently don't have any addresses saved</p>
                                        </div>
                                        <div class="no-data-action-sec">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addressModal" onclick="openAddressModal('add')">
                                                Add Your First Address
                                            </button>
                                        </div>
                                    </div>
                                @else
                                    {{-- Display saved addresses --}}
                                    <div class="row" id="addresses-list">
                                        @foreach($userAddresses as $address)
                                            <div class="col-md-6 mb-4" data-address-id="{{ $address->id }}">
                                                <div class="card h-100">
                                                    <div class="card-body">
                                                        <h5 class="card-title mb-3">{{ $address->recipient_name }}</h5>
                                                        <div class="card-info-fields">
                                                            <div class="data-field mb-2">
                                                                <p><strong>Street Address:</strong></p>
                                                                <p>{{ $address->street_address }}</p>
                                                            </div>
                                                            @if($address->apartment)
                                                                <div class="data-field mb-2">
                                                                    <p><strong>Apt:</strong></p>
                                                                    <p>{{ $address->apartment }}</p>
                                                                </div>
                                                            @endif
                                                            <div class="data-field mb-2">
                                                                <p><strong>City:</strong></p>
                                                                <p>{{ $address->city }}</p>
                                                            </div>
                                                            <div class="data-field mb-2">
                                                                <p><strong>State:</strong></p>
                                                                <p>{{ $address->state }}</p>
                                                            </div>
                                                            <div class="data-field mb-2">
                                                                <p><strong>Zip Code:</strong></p>
                                                                <p>{{ $address->postal_code }}</p>
                                                            </div>
                                                            <div class="data-field mb-2">
                                                                <p><strong>Country:</strong></p>
                                                                <p>{{ $address->country }}</p>
                                                            </div>
                                                            @if($address->phone)
                                                                <div class="data-field mb-2">
                                                                    <p><strong>Phone:</strong></p>
                                                                    <p>{{ $address->phone }}</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="card-footer bg-white border-top" style="opacity: 1 !important; visibility: visible !important;">
                                                        <div class="d-flex justify-content-between gap-2">
                                                            <button type="button" class="btn btn-sm address-edit-btn" onclick="editAddress({{ $address->id }})" title="Edit Address">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-sm address-delete-btn" onclick="deleteAddress({{ $address->id }})" title="Delete Address">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    @if($userAddresses->count() < 3)
                                        <div class="text-center mt-4">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addressModal" onclick="openAddressModal('add')">
                                                Add Another Address
                                            </button>
                                        </div>
                                    @else
                                        <div class="alert alert-info text-center mt-4">
                                            You have reached the maximum of 3 saved addresses.
                                        </div>
                                    @endif
                                @endif
                            </div>

                            {{-- Address Modal --}}
                            <div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content p-4">
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title" id="addressModalLabel">Add New Address</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="addressForm">
                                                @csrf
                                                <input type="hidden" id="address_id" name="address_id" value="">
                                                <input type="hidden" id="form_method" name="_method" value="POST">
                                                
                                                <div class="mb-3">
                                                    <input type="text" class="form-control border-0 border-bottom rounded-0 shadow-none" 
                                                           id="recipient_name" name="recipient_name" placeholder="Full Name" required>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-8">
                                                        <input type="text" class="form-control border-0 border-bottom rounded-0 shadow-none" 
                                                               id="street_address" name="street_address" placeholder="Street Address" required>
                                                    </div>
                                                    <div class="col-4">
                                                        <input type="text" class="form-control border-0 border-bottom rounded-0 shadow-none" 
                                                               id="apartment" name="apartment" placeholder="Apt #">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-6">
                                                        <input type="text" class="form-control border-0 border-bottom rounded-0 shadow-none" 
                                                               id="city" name="city" placeholder="City" required>
                                                    </div>
                                                    <div class="col-3">
                                                        <input type="text" class="form-control border-0 border-bottom rounded-0 shadow-none" 
                                                               id="state" name="state" placeholder="State" required>
                                                    </div>
                                                    <div class="col-3">
                                                        <input type="text" class="form-control border-0 border-bottom rounded-0 shadow-none" 
                                                               id="postal_code" name="postal_code" placeholder="Zip Code" required>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <input type="text" class="form-control border-0 border-bottom rounded-0 shadow-none" 
                                                           id="country" name="country" placeholder="Country" value="United States" required>
                                                </div>

                                                <div class="mb-3">
                                                    <input type="tel" class="form-control border-0 border-bottom rounded-0 shadow-none" 
                                                           id="phone" name="phone" placeholder="Phone Number">
                                                </div>

                                                <button type="submit" class="btn w-100" style="background:#333; color:#fff; padding:12px;">
                                                    SAVE ADDRESS
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <script>
                    function openAddressModal(mode, addressId = null) {
                        const modal = document.getElementById('addressModal');
                        const form = document.getElementById('addressForm');
                        const modalTitle = document.getElementById('addressModalLabel');
                        
                        // Reset form
                        form.reset();
                        document.getElementById('address_id').value = '';
                        document.getElementById('form_method').value = 'POST';
                        document.getElementById('country').value = 'United States';
                        
                        if (mode === 'add') {
                            modalTitle.textContent = 'Add New Address';
                        } else if (mode === 'edit' && addressId) {
                            modalTitle.textContent = 'Edit Address';
                            document.getElementById('address_id').value = addressId;
                            document.getElementById('form_method').value = 'PUT';
                            
                            // Fetch address data and pre-fill form
                            fetch(`/addresses/${addressId}/edit`, {
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json'
                                }
                            })
                            .then(res => {
                                if (!res.ok) throw new Error('Failed to fetch address');
                                return res.json();
                            })
                            .then(data => {
                                console.log('Address data:', data); // Debug log
                                
                                // Set values with a small delay to ensure form is ready
                                setTimeout(() => {
                                    document.getElementById('recipient_name').value = data.recipient_name || '';
                                    document.getElementById('street_address').value = data.street_address || '';
                                    document.getElementById('apartment').value = data.apartment || '';
                                    document.getElementById('city').value = data.city || '';
                                    document.getElementById('state').value = data.state || '';
                                    document.getElementById('postal_code').value = data.postal_code || '';
                                    document.getElementById('country').value = data.country || 'United States';
                                    document.getElementById('phone').value = data.phone || '';
                                }, 100);
                            })
                            .catch(err => {
                                console.error('Error loading address:', err);
                                alert('Error loading address data. Please try again.');
                            });
                        }
                    }

                    function editAddress(addressId) {
                        openAddressModal('edit', addressId);
                        const modal = new bootstrap.Modal(document.getElementById('addressModal'));
                        modal.show();
                    }

                    function deleteAddress(addressId) {
                        Swal.fire({
                            title: 'Delete Address?',
                            text: "Are you sure you want to delete this address? This action cannot be undone.",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Yes, delete it',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                                
                                fetch(`/addresses/${addressId}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': csrfToken,
                                        'Accept': 'application/json',
                                        'Content-Type': 'application/json'
                                    }
                                })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire({
                                            title: 'Deleted!',
                                            text: 'Address has been deleted successfully.',
                                            icon: 'success',
                                            timer: 2000,
                                            showConfirmButton: false
                                        }).then(() => {
                                            location.reload();
                                        });
                                    } else {
                                        Swal.fire('Error!', data.message || 'Error deleting address', 'error');
                                    }
                                })
                                .catch(err => {
                                    console.error('Error:', err);
                                    Swal.fire('Error!', 'Error deleting address. Please try again.', 'error');
                                });
                            }
                        });
                    }

                    document.getElementById('addressForm').addEventListener('submit', function(e) {
                        e.preventDefault();
                        
                        const formData = new FormData(this);
                        const addressId = document.getElementById('address_id').value;
                        const method = document.getElementById('form_method').value;
                        
                        let url = '/addresses';
                        if (method === 'PUT' && addressId) {
                            url = `/addresses/${addressId}`;
                        }
                        
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        
                        fetch(url, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: formData
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                location.reload();
                            } else {
                                alert(data.message || 'Error saving address');
                            }
                        })
                        .catch(err => {
                            console.error('Error:', err);
                            alert('Error saving address');
                        });
                    });
                </script>




                <div class="side-content-tabs" id="change-password" style="display:none">
                    <div class="side-inner-content-main">
                        <div class="side-inner-content resource-content change-password-section">
                            <h2>Change Password</h2>
                            
                            <div id="password-error-message" class="alert alert-danger" style="display: none;"></div>
                            <div id="password-success-message" class="alert alert-success" style="display: none;"></div>
                            
                            <form id="changePasswordForm">
                                @csrf
                                <div class="cp-form-group">
                                    <label>Current Password</label>
                                    <input type="password" name="current_password" id="current_password" class="cp-input cp-current-password" required>
                                    <span class="cp-toggle-eye" onclick="togglePasswordVisibility('current_password')">SHOW</span>
                                </div>

                                <div class="cp-form-group">
                                    <label>New Password</label>
                                    <input type="password" name="new_password" id="new_password" class="cp-input cp-new-password" required>
                                    <span class="cp-toggle-eye" onclick="togglePasswordVisibility('new_password')">SHOW</span>
                                    <ul class="cp-requirements">
                                        <li class="cp-length">8 to 24 characters</li>
                                        <li class="cp-lowercase">A lowercase letter</li>
                                        <li class="cp-uppercase">An uppercase letter</li>
                                        <li class="cp-number">A number</li>
                                        <li class="cp-special">A special character (!@#$%^&*()_+)</li>
                                    </ul>
                                </div>

                                <div class="cp-form-group">
                                    <label>Confirm Password</label>
                                    <input type="password" name="new_password_confirmation" id="confirm_password" class="cp-input cp-confirm-password" required>
                                    <span class="cp-toggle-eye" onclick="togglePasswordVisibility('confirm_password')">SHOW</span>
                                </div>

                                <button type="submit" class="cp-btn cp-save-btn" id="savePasswordBtn">SAVE PASSWORD</button>
                            </form>

                        </div>
                    </div>
                </div>

                <script>
                    function togglePasswordVisibility(inputId) {
                        const input = document.getElementById(inputId);
                        const button = input.nextElementSibling;
                        
                        if (input.type === 'password') {
                            input.type = 'text';
                            button.textContent = 'HIDE';
                        } else {
                            input.type = 'password';
                            button.textContent = 'SHOW';
                        }
                    }

                    // Password validation
                    const newPasswordInput = document.getElementById('new_password');
                    const confirmPasswordInput = document.getElementById('confirm_password');
                    const savePasswordBtn = document.getElementById('savePasswordBtn');
                    
                    if (newPasswordInput) {
                        newPasswordInput.addEventListener('input', validatePassword);
                        confirmPasswordInput.addEventListener('input', validatePassword);
                    }

                    function validatePassword() {
                        const password = newPasswordInput.value;
                        const confirm = confirmPasswordInput.value;
                        
                        // Check requirements
                        const lengthValid = password.length >= 8 && password.length <= 24;
                        const lowercaseValid = /[a-z]/.test(password);
                        const uppercaseValid = /[A-Z]/.test(password);
                        const numberValid = /[0-9]/.test(password);
                        const specialValid = /[!@#$%^&*()_+]/.test(password);
                        
                        // Update UI
                        document.querySelector('.cp-length').style.color = lengthValid ? 'green' : '';
                        document.querySelector('.cp-lowercase').style.color = lowercaseValid ? 'green' : '';
                        document.querySelector('.cp-uppercase').style.color = uppercaseValid ? 'green' : '';
                        document.querySelector('.cp-number').style.color = numberValid ? 'green' : '';
                        document.querySelector('.cp-special').style.color = specialValid ? 'green' : '';
                        
                        // Enable/disable button
                        const allValid = lengthValid && lowercaseValid && uppercaseValid && numberValid && specialValid;
                        const passwordsMatch = password === confirm && confirm.length > 0;
                        
                        savePasswordBtn.disabled = !(allValid && passwordsMatch);
                    }

                    // Form submission
                    document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
                        e.preventDefault();
                        
                        const errorMessage = document.getElementById('password-error-message');
                        const successMessage = document.getElementById('password-success-message');
                        const submitBtn = document.getElementById('savePasswordBtn');
                        
                        errorMessage.style.display = 'none';
                        successMessage.style.display = 'none';
                        
                        const formData = new FormData(this);
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        
                        submitBtn.disabled = true;
                        submitBtn.textContent = 'SAVING...';
                        
                        fetch('{{ route("password.update") }}', {
                            method: 'PUT',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                current_password: formData.get('current_password'),
                                new_password: formData.get('new_password'),
                                new_password_confirmation: formData.get('new_password_confirmation')
                            })
                        })
                        .then(res => {
                            if (!res.ok) {
                                return res.json().then(data => {
                                    throw data;
                                });
                            }
                            return res.json();
                        })
                        .then(data => {
                            submitBtn.disabled = false;
                            submitBtn.textContent = 'SAVE PASSWORD';
                            
                            if (data.success) {
                                // Reset form
                                document.getElementById('changePasswordForm').reset();
                                
                                // Reset validation UI
                                document.querySelectorAll('.cp-requirements li').forEach(li => {
                                    li.style.color = '';
                                });
                                
                                // Show SweetAlert
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Your password has been changed successfully. A confirmation email has been sent.',
                                    icon: 'success',
                                    confirmButtonColor: '#8d5943'
                                });
                            } else {
                                errorMessage.textContent = data.message || 'Error changing password. Please check your input.';
                                errorMessage.style.display = 'block';
                            }
                        })
                        .catch(err => {
                            console.error('Error:', err);
                            submitBtn.disabled = false;
                            submitBtn.textContent = 'SAVE PASSWORD';
                            
                            const message = err.message || 'Error changing password. Please try again.';
                            errorMessage.textContent = message;
                            errorMessage.style.display = 'block';
                        });
                    });
                </script>



                <div class="side-content-tabs" id="security" style="display:none">
                    <div class="side-inner-content-main">
                        <div class="side-inner-content resource-content change-password-section">
                            <h2>Account Security</h2>

                            <p class="mt-4">End all sessions of any saved signed-in visits to your Gap, Old Navy, Banana Republic, and Athleta account.</p>

                            <button class="btn end-session-btn mt-3">
                                End All Sessions
                            </button>
                            <p class="mt-2">This will not impact your current visit but you'll be prompted to sign in on a future visit.</p>

                        </div>
                    </div>
                </div>

                <div class="side-content-tabs" id="communication" style="display:none">
                    <div class="side-inner-content-main">
                        <div class="side-inner-content resource-content change-password-section">
                            <h2>Communication Preferences</h2>
                            
                            <p class="mb-4">Manage how you'd like to hear from us. You can update your preferences at any time.</p>
                            
                            <div id="preferences-error-message" class="alert alert-danger" style="display: none;"></div>
                            <div id="preferences-success-message" class="alert alert-success" style="display: none;"></div>
                            
                            <form id="communicationPreferencesForm">
                                @csrf
                                
                                <div class="preference-item mb-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="mb-1">Marketing Emails</h5>
                                            <p class="text-muted mb-0">Receive promotional offers and special deals</p>
                                        </div>
                                        <div class="toggle-switch">
                                            <input type="checkbox" id="marketing_emails" name="marketing_emails" value="1" {{ Auth::user()->marketing_emails ? 'checked' : '' }}>
                                            <label for="marketing_emails" class="toggle-label"></label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="preference-item mb-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="mb-1">Order Updates</h5>
                                            <p class="text-muted mb-0">Get notified about your order status and shipping</p>
                                        </div>
                                        <div class="toggle-switch">
                                            <input type="checkbox" id="order_updates" name="order_updates" value="1" {{ Auth::user()->order_updates ? 'checked' : '' }}>
                                            <label for="order_updates" class="toggle-label"></label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="preference-item mb-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="mb-1">Newsletter</h5>
                                            <p class="text-muted mb-0">Stay updated with our latest news and collections</p>
                                        </div>
                                        <div class="toggle-switch">
                                            <input type="checkbox" id="newsletter" name="newsletter" value="1" {{ Auth::user()->newsletter ? 'checked' : '' }}>
                                            <label for="newsletter" class="toggle-label"></label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="preference-item mb-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="mb-1">Product Recommendations</h5>
                                            <p class="text-muted mb-0">Receive personalized product suggestions</p>
                                        </div>
                                        <div class="toggle-switch">
                                            <input type="checkbox" id="product_recommendations" name="product_recommendations" value="1" {{ Auth::user()->product_recommendations ? 'checked' : '' }}>
                                            <label for="product_recommendations" class="toggle-label"></label>
                                        </div>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn w-100" style="background:#8d5943; color:#fff; padding:12px;" id="savePreferencesBtn">
                                    SAVE PREFERENCES
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
                
                <script>
                    // Communication Preferences Form Submission
                    if (document.getElementById('communicationPreferencesForm')) {
                        document.getElementById('communicationPreferencesForm').addEventListener('submit', function(e) {
                            e.preventDefault();
                            
                            const errorMessage = document.getElementById('preferences-error-message');
                            const successMessage = document.getElementById('preferences-success-message');
                            const submitBtn = document.getElementById('savePreferencesBtn');
                            
                            errorMessage.style.display = 'none';
                            successMessage.style.display = 'none';
                            
                            const formData = new FormData(this);
                            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                            
                            // Build preferences object - unchecked boxes won't be in formData
                            const preferences = {
                                marketing_emails: formData.get('marketing_emails') === '1' ? 1 : 0,
                                order_updates: formData.get('order_updates') === '1' ? 1 : 0,
                                newsletter: formData.get('newsletter') === '1' ? 1 : 0,
                                product_recommendations: formData.get('product_recommendations') === '1' ? 1 : 0
                            };
                            
                            submitBtn.disabled = true;
                            submitBtn.textContent = 'SAVING...';
                            
                            fetch('{{ route("preferences.update") }}', {
                                method: 'PUT',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify(preferences)
                            })
                            .then(res => {
                                if (!res.ok) {
                                    return res.json().then(data => {
                                        throw data;
                                    });
                                }
                                return res.json();
                            })
                            .then(data => {
                                submitBtn.disabled = false;
                                submitBtn.textContent = 'SAVE PREFERENCES';
                                
                                if (data.success) {
                                    // Show SweetAlert
                                    Swal.fire({
                                        title: 'Success!',
                                        text: 'Your communication preferences have been updated. A confirmation email has been sent.',
                                        icon: 'success',
                                        confirmButtonColor: '#8d5943'
                                    });
                                } else {
                                    errorMessage.textContent = data.message || 'Error updating preferences.';
                                    errorMessage.style.display = 'block';
                                }
                            })
                            .catch(err => {
                                console.error('Error:', err);
                                submitBtn.disabled = false;
                                submitBtn.textContent = 'SAVE PREFERENCES';
                                
                                const message = err.message || 'Error updating preferences. Please try again.';
                                errorMessage.textContent = message;
                                errorMessage.style.display = 'block';
                            });
                        });
                    }
                </script>




            </div>

        </div>
        </div>
    </x-slot>
    <x-slot name="insertjavascript">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>


        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                    new bootstrap.Tooltip(tooltipTriggerEl)
                })
            });
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const tabTriggers = document.querySelectorAll("[data-target]");
                const tabContents = document.querySelectorAll(".side-content-tabs");
                const sideMenuTabs = document.querySelectorAll("#tab-side-menu li");

                tabTriggers.forEach(trigger => {
                    trigger.addEventListener("click", () => {
                        const targetId = trigger.getAttribute("data-target");

                        // --- Reset everything ---
                        sideMenuTabs.forEach(tab => tab.classList.remove("active"));
                        tabContents.forEach(content => (content.style.display = "none"));

                        // --- Activate corresponding li in sidebar ---
                        const matchingLi = document.querySelector(
                            `#tab-side-menu li[data-target="${targetId}"]`
                        );
                        if (matchingLi) {
                            matchingLi.classList.add("active");
                        }

                        // --- Show correct content ---
                        const targetEl = document.getElementById(targetId);
                        if (targetEl) {
                            targetEl.style.display = "block";
                        }
                    });
                });
            });
        </script>
        <script>
            (function() {

                // map JS field names to DB column names (server expects 'field' + 'value')
                const FIELD_MAP = {
                    firstName: 'first_name',
                    birthday: 'birthday'
                };

                // escape text to safely inject into innerHTML
                function escapeHtml(unsafe) {
                    if (unsafe === null || typeof unsafe === 'undefined') return '';
                    return String(unsafe)
                        .replaceAll('&', '&amp;')
                        .replaceAll('<', '&lt;')
                        .replaceAll('>', '&gt;')
                        .replaceAll('"', '&quot;')
                        .replaceAll("'", '&#039;');
                }

                // Show edit UI for a field
                function editField(field) {
                    if (!FIELD_MAP[field]) return console.warn('Inline editing not allowed for field:', field);

                    const row = document.getElementById(field + 'Row');
                    if (!row) return console.warn('Row element not found for', field);

                    const valueEl = document.getElementById(field + 'Value');
                    const currentValue = (valueEl && valueEl.textContent) ? valueEl.textContent.trim() : '';

                    // store original value to restore on cancel
                    row.dataset.original = currentValue;

                    // choose input type (birthday expects MM/DD format)
                    let inputHtml = `<input type="text" id="${field}Input" class="form-control" value="${escapeHtml(currentValue)}">`;
                    if (field === 'birthday') {
                        inputHtml = `<input type="text" id="${field}Input" class="form-control" placeholder="MM/DD" value="${escapeHtml(currentValue)}">`;
                    }

                    const label = row.querySelector('.label') ? row.querySelector('.label').textContent : field;
                    row.innerHTML = `
      <div class="label">${escapeHtml(label)}</div>
      <div class="edit-box">
        ${inputHtml}
        <div class="edit-actions mt-2">
          <button class="btn btn-primary btn-sm" id="${field}SaveBtn">Save</button>
          <button class="btn btn-secondary btn-sm" id="${field}CancelBtn">Cancel</button>
        </div>
        <div class="field-feedback mt-2" id="${field}Feedback" style="font-size:13px;color:#d9534f;"></div>
      </div>
    `;

                    // attach handlers (avoid inline onclick to keep functions manageable)
                    const saveBtn = document.getElementById(field + 'SaveBtn');
                    const cancelBtn = document.getElementById(field + 'CancelBtn');
                    if (saveBtn) saveBtn.addEventListener('click', function() {
                        saveField(field);
                    });
                    if (cancelBtn) cancelBtn.addEventListener('click', function() {
                        cancelEdit(field);
                    });

                    const input = document.getElementById(field + 'Input');
                    if (input) input.focus();
                }

                // Save the field via AJAX and update UI on success
                function saveField(field) {
                    if (!FIELD_MAP[field]) return console.warn('Save not allowed for', field);

                    const row = document.getElementById(field + 'Row');
                    if (!row) return console.warn('Row element missing for', field);

                    const input = document.getElementById(field + 'Input');
                    const feedback = document.getElementById(field + 'Feedback');
                    const saveBtn = document.getElementById(field + 'SaveBtn');
                    const cancelBtn = document.getElementById(field + 'CancelBtn');

                    const newValue = input ? input.value.trim() : '';

                    // basic client-side validation
                    if (field === 'birthday' && newValue !== '' && !/^\d{1,2}\/\d{1,2}$/.test(newValue)) {
                        if (feedback) feedback.textContent = 'Enter birthday as MM/DD';
                        return;
                    }

                    if (saveBtn) saveBtn.disabled = true;
                    if (cancelBtn) cancelBtn.disabled = true;
                    if (feedback) feedback.textContent = '';

                    // prepare payload
                    const formData = new FormData();
                    formData.append('field', FIELD_MAP[field]);
                    formData.append('value', newValue);

                    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
                    const csrf = csrfMeta ? csrfMeta.getAttribute('content') : '';

                    fetch("{{ route('profile.update') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrf,
                                'Accept': 'application/json'
                            },
                            body: formData,
                            credentials: 'same-origin'
                        })

                        .then(res => res.json().catch(() => ({})))
                        .then(data => {
                            if (data && data.status === 'ok') {
                                // prefer server-provided display value if available
                                const display = data.value_display ?? data.value ?? newValue;
                                const label = row.querySelector('.label') ? row.querySelector('.label').textContent : field;

                                row.innerHTML = `
          <div class="label">${escapeHtml(label)}</div>
          <div class="main-field">
            <span class="value" id="${field}Value">${escapeHtml(display)}</span>
            <span class="edit-btn" onclick="editField('${field}')">Edit</span>
          </div>
        `;

                                // optionally show toast (if SweetAlert/Toast exists)
                                if (typeof Toast !== 'undefined') Toast.fire({
                                    icon: 'success',
                                    title: data.message || 'Saved'
                                });
                            } else {
                                const err = (data && data.message) ? data.message : 'Failed to save';
                                if (feedback) feedback.textContent = err;
                                if (typeof Toast !== 'undefined') Toast.fire({
                                    icon: 'error',
                                    title: err
                                });
                                if (saveBtn) saveBtn.disabled = false;
                                if (cancelBtn) cancelBtn.disabled = false;
                            }
                        })
                        .catch(() => {
                            if (feedback) feedback.textContent = 'Network error';
                            if (typeof Toast !== 'undefined') Toast.fire({
                                icon: 'error',
                                title: 'Network error'
                            });
                            if (saveBtn) saveBtn.disabled = false;
                            if (cancelBtn) cancelBtn.disabled = false;
                        });
                }

                // Cancel edit and restore original value
                function cancelEdit(field) {
                    const row = document.getElementById(field + 'Row');
                    if (!row) return;
                    // original value stored on row.dataset.original during editField
                    const original = (typeof row.dataset.original !== 'undefined') ? row.dataset.original : '';
                    const label = row.querySelector('.label') ? row.querySelector('.label').textContent : field;

                    row.innerHTML = `
      <div class="label">${escapeHtml(label)}</div>
      <div class="main-field">
        <span class="value" id="${field}Value">${escapeHtml(original)}</span>
        <span class="edit-btn" onclick="editField('${field}')">Edit</span>
      </div>
    `;
                }

                // export to global so inline onclick attributes work
                window.editField = editField;
                window.saveField = saveField;
                window.cancelEdit = cancelEdit;
                window.escapeHtml = escapeHtml;

            })();
        </script>


        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const menu = document.getElementById("tab-side-menu");
                const tabs = document.querySelectorAll(".side-content-tabs");
                const items = menu.querySelectorAll("li[data-target]");

                // When clicking menu item
                items.forEach(item => {
                    item.addEventListener("click", () => {
                        const targetId = item.getAttribute("data-target");

                        if (window.innerWidth <= 991) {
                            menu.style.display = "none"; // hide menu
                        }

                        tabs.forEach(tab => {
                            tab.style.display = tab.id === targetId ? "block" : "none";
                        });
                    });
                });

                // Add a back button dynamically to each content tab
                tabs.forEach(tab => {
                    const backBtn = document.createElement("button");
                    backBtn.innerText = "← Back";
                    backBtn.className = "back-btn";
                    backBtn.style.margin = "10px";
                    backBtn.style.display = "block";

                    backBtn.addEventListener("click", () => {
                        if (window.innerWidth <= 991) {
                            tab.style.display = "none"; // hide content
                            menu.style.display = "block"; // show menu
                        }
                    });

                    tab.insertBefore(backBtn, tab.firstChild);
                });
            });
        </script>

        <script>
            const newPasswordInput = document.querySelector(".cp-new-password");
            const confirmPasswordInput = document.querySelector(".cp-confirm-password");
            const saveBtn = document.querySelector(".cp-save-btn");

            const lengthItem = document.querySelector(".cp-length");
            const lowercaseItem = document.querySelector(".cp-lowercase");
            const uppercaseItem = document.querySelector(".cp-uppercase");
            const numberItem = document.querySelector(".cp-number");
            const specialItem = document.querySelector(".cp-special");

            function checkPassword() {
                const password = newPasswordInput.value;
                const confirm = confirmPasswordInput.value;

                lengthItem.classList.toggle("cp-valid", password.length >= 8 && password.length <= 24);
                lowercaseItem.classList.toggle("cp-valid", /[a-z]/.test(password));
                uppercaseItem.classList.toggle("cp-valid", /[A-Z]/.test(password));
                numberItem.classList.toggle("cp-valid", /\d/.test(password));
                specialItem.classList.toggle("cp-valid", /[!@#$%^&*()_+]/.test(password));

                const allValid = document.querySelectorAll(".cp-requirements li.cp-valid").length === 5;
                saveBtn.disabled = !(allValid && password === confirm);
            }

            newPasswordInput.addEventListener("input", checkPassword);
            confirmPasswordInput.addEventListener("input", checkPassword);

            // Toggle show/hide password (no data-target, finds sibling input)
            document.querySelectorAll(".cp-toggle-eye").forEach(toggle => {
                toggle.addEventListener("click", () => {
                    const input = toggle.previousElementSibling; // the input before the span
                    if (input.type === "password") {
                        input.type = "text";
                        toggle.textContent = "HIDE";
                    } else {
                        input.type = "password";
                        toggle.textContent = "SHOW";
                    }
                });
            });
        </script>
        <!-- Stripe JS library -->
        <script src="https://js.stripe.com/v3/"></script>

        <script>
            $(function() {
                const stripeKey = "{{ config('services.stripe.key') ?? env('STRIPE_KEY') }}";
                if (!stripeKey) {
                    console.error('Stripe key missing.');
                    return;
                }

                const stripe = Stripe(stripeKey);
                const elements = stripe.elements();
                const style = {
                    base: {
                        color: '#212529',
                        fontSize: '16px',
                        fontFamily: '"Helvetica Neue", Helvetica, Arial, sans-serif',
                        '::placeholder': {
                            color: '#6c757d'
                        }
                    },
                    invalid: {
                        color: '#d9534f'
                    }
                };

                // Stripe Elements
                const cardNumber = elements.create('cardNumber', {
                    style
                });
                const cardExpiry = elements.create('cardExpiry', {
                    style
                });
                const cardCvc = elements.create('cardCvc', {
                    style
                });

                cardNumber.mount('#card-number-element');
                cardExpiry.mount('#card-expiry-element');
                cardCvc.mount('#card-cvc-element');

                // Error display
                function clearErrors() {
                    $('#card-errors').text('');
                    $('#error-card-number, #error-card-expiry, #error-card-cvc').text('');
                }

                cardNumber.on('change', e => $('#error-card-number').text(e.error ? e.error.message : ''));
                cardExpiry.on('change', e => $('#error-card-expiry').text(e.error ? e.error.message : ''));
                cardCvc.on('change', e => $('#error-card-cvc').text(e.error ? e.error.message : ''));

                // Load saved cards
                // function loadCards() {
                //     const $select = $('#saved-cards');
                //     $select.html('<option>Loading...</option>');
                //     $.get("{{ route('cards.list') }}")
                //         .done(res => {
                //             $select.empty();
                //             if (res.cards && res.cards.length) {
                //                 $select.append('<option value="">-- choose saved card --</option>');
                //                 res.cards.forEach(c => {
                //                     const opt = $('<option>').val(c.id)
                //                         .text((c.brand ? c.brand + ' ' : '') + '**** ' + c.last4)
                //                         .data('last4', c.last4)
                //                         .data('exp_month', c.exp_month)
                //                         .data('exp_year', c.exp_year)
                //                         .prop('selected', c.is_default || false);
                //                     $select.append(opt);
                //                 });
                //                 updateCardDetails();
                //             } else {
                //                 $select.append('<option value="">No saved cards</option>');
                //                 $('#card-details').text('No saved cards.');
                //             }
                //         })
                //         .fail(() => {
                //             $select.html('<option value="">Error loading cards</option>');
                //             $('#card-details').text('Could not load saved cards.');
                //         });
                // }

                function updateCardDetails() {
                    const $select = $('#saved-cards');
                    const val = $select.val();
                    const opt = $select.find('option:selected');
                    if (val) {
                        const last4 = opt.data('last4') || '----';
                        const mm = opt.data('exp_month') || '';
                        const yy = opt.data('exp_year') || '';
                        const displayExp = mm && yy ? mm + '/' + String(yy).slice(-2) : '';
                        $('#card-details').html('Card: **** **** **** ' + last4 + '<br>Exp: ' + displayExp);
                    } else {
                        $('#card-details').html('Select a card to see details.');
                    }
                }

                $('#saved-cards').on('change', updateCardDetails);

                loadCards();

                // ---------- Add Card Form ----------
                $('#cardForm').on('submit', function(e) {
                    e.preventDefault();

                    // === Guard: prevent double/triple submissions ===
                    if (window._isAddingCard) return;
                    window._isAddingCard = true;

                    clearErrors();
                    const saveDefault = $('#is_default').is(':checked') ? true : false;

                    // --- plain-JS button disable + spinner (no jQuery for disabling) ---
                    const formEl = this;
                    const submitBtn = formEl.querySelector('button[type="submit"]') || formEl.querySelector('.save-card-btn');

                    // store original HTML once (so we can restore later)
                    if (submitBtn && !submitBtn.dataset.origHtml) {
                        submitBtn.dataset.origHtml = submitBtn.innerHTML;
                    }

                    if (submitBtn) {
                        submitBtn.disabled = true; // plain JS disable
                        submitBtn.setAttribute('aria-disabled', 'true');
                        submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...`;
                    }

                    // create Stripe PaymentMethod
                    stripe.createPaymentMethod({
                        type: 'card',
                        card: cardNumber,
                        billing_details: {
                            name: $('#full_name').val() || null
                        }
                    }).then(function(result) {
                        if (result.error) {
                            $('#card-errors').text(result.error.message);

                            // restore button & flag
                            if (submitBtn) {
                                submitBtn.innerHTML = submitBtn.dataset.origHtml || submitBtn.innerHTML;
                                submitBtn.disabled = false;
                                submitBtn.removeAttribute('aria-disabled');
                            }
                            window._isAddingCard = false;
                            return;
                        }

                        const payment_method_id = result.paymentMethod.id;

                        // send payment_method_id to server (keeps your existing jQuery AJAX)
                        $.ajax({
                            url: "{{ route('cards.store') }}",
                            method: "POST",
                            data: {
                                payment_method_id,
                                is_default: saveDefault ? 1 : 0,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(res) {
                                $('#cardForm')[0].reset();
                                $('#paymentModal').modal('hide');
                                if (typeof toastr !== 'undefined') toastr.success(res.message || 'Card saved');

                                // call your existing loader (unchanged)
                                loadCards();

                                // restore button & flag
                                if (submitBtn) {
                                    submitBtn.innerHTML = submitBtn.dataset.origHtml || submitBtn.innerHTML;
                                    submitBtn.disabled = false;
                                    submitBtn.removeAttribute('aria-disabled');
                                }
                                window._isAddingCard = false;
                            },
                            error: function(xhr) {
                                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                                    const errors = xhr.responseJSON.errors;
                                    Object.keys(errors).forEach(k => {
                                        const msg = errors[k][0] || errors[k];
                                        $('#card-errors').append('<div>' + msg + '</div>');
                                    });
                                } else {
                                    $('#card-errors').text(xhr.responseJSON?.message || 'Server error');
                                }

                                // restore button & flag on error
                                if (submitBtn) {
                                    submitBtn.innerHTML = submitBtn.dataset.origHtml || submitBtn.innerHTML;
                                    submitBtn.disabled = false;
                                    submitBtn.removeAttribute('aria-disabled');
                                }
                                window._isAddingCard = false;
                            }
                        });
                    });
                });


            });
        </script>



        <script>
            function maskCardNumber(number) {
                // show only last 4 digits
                number = number.replace(/\s+/g, ''); // remove spaces
                return '**** **** **** ' + number.slice(-4);
            }

            function maskCVV(cvv) {
                return '***';
            }

            function loadCards() {
                $.ajax({
                    url: "{{ route('cards.list') }}",
                    type: 'GET',
                    success: function(response) {
                        if (response.status === 'ok') {
                            let wrapper = $('#cardListWrapper');

                            // clear old cards
                            wrapper.find('.card-info-fields').remove();

                            // Ensure "no-data" UI is hidden by default
                            $('.no-data-footer, .no-data-action-sec').hide();

                            // If there are cards -> hide the "add card" prompt (payment-card) and keep no-data hidden
                            if (response.cards.length > 0) {
                                $('.payment-card').hide();
                                $('.no-data-footer, .no-data-action-sec').hide();
                            } else {
                                // No cards -> show the "add card" prompt and the no-data blocks
                                $('.payment-card').show();
                                $('.no-data-footer, .no-data-action-sec').show();
                            }

                            response.cards.forEach(function(card) {
                                let cardHtml = `
                        <div class="card-info-fields add-card mt-3" data-card-id="${card.id}">
                            <div class="input-field card-number-field">
                                <p><strong>Card Number:</strong> ${maskCardNumber(card.card_number)}</p>
                            </div>
                            <div class="input-field expiration-field">
                                <p><strong>Expiration date:</strong> ${card.expiry}</p>
                            </div>
                            <div class="input-field cvv-field">
                                <p><strong>CVV:</strong> ${maskCVV(card.cvv ?? '')}</p>
                            </div>

                            <!-- Action icons -->
                            <div class="card-actions mt-2">
                                <span class="card-action-icon delete-card" data-id="${card.id}" title="Delete" >
                                    <i class="fas fa-trash"></i>
                                </span>
                            </div>

                            <!-- Hidden details section -->
                            <div class="card-details mt-3 p-3 border rounded bg-light" style="display:none;">
                                <p><strong>Full Name:</strong> ${card.full_name ?? '-'}</p>
                                <p><strong>Street:</strong> ${card.street ?? '-'}</p>
                                <p><strong>Apartment:</strong> ${card.apartment ?? '-'}</p>
                                <p><strong>City:</strong> ${card.city ?? '-'}</p>
                                <p><strong>State:</strong> ${card.state ?? '-'}</p>
                                <p><strong>Zip:</strong> ${card.zip ?? '-'}</p>
                                <p><strong>Phone:</strong> ${card.phone ?? '-'}</p>
                                <p><strong>Default:</strong> ${card.is_default == 1 ? 'Yes' : 'No'}</p>
                            </div>
                        </div>
                    `;
                                wrapper.prepend(cardHtml);
                            });
                        }
                    }
                });
            }


            // Load cards on page load
            $(document).ready(function() {
                loadCards();
            });
        </script>
        <script>
            async function getOrders() {
                try {
                    const response = await fetch("{{ route('user.orders') }}", {
                        method: "GET",
                        headers: {
                            "X-Requested-With": "XMLHttpRequest",
                            "Accept": "application/json"
                        },
                        credentials: "include"
                    });

                    const result = await response.json();
                    const fullContainer = document.querySelector("#purchase-history .dash-purchase-history"); // full list
                    const previewContainer = document.querySelector(".persnal-left .dash-purchase-history"); // preview (2–3)
                    const noDataCard = document.querySelector("#purchase-history .not-data-card");

                    if (!result.status || !result.data || result.data.length === 0) {
                        fullContainer.innerHTML = "";
                        previewContainer.innerHTML = "You have no recent orders to track.";
                        noDataCard.style.display = "block";
                        return;
                    }

                    noDataCard.style.display = "none";
                    fullContainer.innerHTML = "";
                    previewContainer.innerHTML = "";

                    // loop through all orders
                    result.data.forEach((order, index) => {
                        if (order.products && order.products.length > 0) {
                            let productsHtml = "";

                            order.products.forEach(productItem => {
                                const product = productItem.product || {};
                                const variation = productItem.variation || {};

                                let variationHtml = "";
                                if (variation.color?.name) {
                                    variationHtml += `<p><strong>Color:</strong> ${variation.color.name}</p>`;
                                }
                                if (variation.size) {
                                    variationHtml += `<p><strong>Size:</strong> ${variation.size}</p>`;
                                }

                                productsHtml += `
                        <div class="purchase-section-main mt-3">
                            <div class="purchase-product">
                                <img src="{{ asset('assets/images/products') }}/${product.images?.[0] ?? 'default.jpg'}" alt="product-image">
                            </div>
                            <div class="purchased-detail">
                                <h1>${product.name ?? "Unnamed Product"}</h1>
                                ${variationHtml}
                                <strong>Price: $ ${productItem.price}</strong>
                            </div>
                        </div>
                    `;
                            });

                            // full purchase history card
                            const orderHtml = `
                     ${productsHtml}
                `;

                            fullContainer.insertAdjacentHTML("beforeend", orderHtml);

                            // only first 2-3 orders go in preview
                            if (index < 3) {
                                const previewHtml = `
                        <div class="purchase-section-main mt-3">
                            <div class="purchase-product">
                                <img src="{{ asset('assets/images/products') }}/${order.products[0].product?.images?.[0] ?? 'default.jpg'}" alt="product-image">
                            </div>
                            <div class="purchased-detail">
                                <h1>${order.products[0].product?.name ?? "Unnamed Product"}</h1>
                                <strong>Total: $ ${order.total_amount}</strong>
                                <p>Status: ${order.status}</p>
                            </div>
                        </div>
                    `;
                                previewContainer.insertAdjacentHTML("beforeend", previewHtml);
                            }
                        }
                    });

                } catch (error) {
                    console.error("Error fetching orders:", error);
                }
            }

            document.addEventListener("DOMContentLoaded", getOrders);
        </script>
        <script>
            function toggleDetails(id) {
                const element = document.getElementById(id);
                element.style.display = (element.style.display === "block") ? "none" : "block";
            }
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.giftcard-summary').forEach(summary => {
                    summary.addEventListener('click', function() {
                        const details = this.nextElementSibling;
                        if (!details) return;
                        details.style.display = details.style.display === 'none' ? 'block' : 'none';
                    });
                });
            });
        </script>

        <script>
            async function getGiftCards() {
                try {
                    const resp = await fetch("{{ route('gift-card.history') }}", {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        credentials: 'include'
                    });

                    const giftCards = await resp.json();
                    const container = document.querySelector("#gift-card-set #giftcard-items");
                    const noData = document.querySelector(".no-giftcard-message");

                    if (!container) return console.warn("Gift card container not found");

                    container.innerHTML = '';

                    if (!Array.isArray(giftCards) || giftCards.length === 0) {
                        if (noData) noData.style.display = 'block';
                        container.innerHTML = `<div class="no-orders-msg"></div>`;
                        return;
                    } else {
                        if (noData) noData.style.display = 'none';
                    }

                    giftCards.forEach(gift => {
                        const code = gift.code || 'N/A';
                        const status = gift.status || 'Unknown';
                        const total = gift.amount ? `$${parseFloat(gift.amount).toFixed(2)}` : '$0.00';

                        // --- Header Row ---
                        const summary = document.createElement('div');
                        summary.className = 'giftcard-summary';
                        summary.style.backgroundColor = '#f9f9f9';
                        summary.style.padding = '10px';
                        summary.style.borderRadius = '6px';
                        summary.style.display = 'flex';
                        summary.style.justifyContent = 'space-between';
                        summary.style.alignItems = 'center';
                        summary.style.cursor = 'pointer';
                        summary.innerHTML = `
                <span class="giftcard-code">CODE: ${code}</span>
                <span class="giftcard-status ${status.toLowerCase()}">${status}</span>
                <span class="giftcard-amount">${total}</span>
            `;

                        // --- Detail Section ---
                        const details = document.createElement('div');
                        details.className = 'giftcard-details';
                        details.style.display = 'none';
                        details.style.padding = '10px';
                        details.style.border = '1px solid #f0f0f0';
                        details.style.borderTop = 'none';
                        details.style.borderRadius = '0 0 6px 6px';
                        details.style.backgroundColor = '#fff';
                        details.style.marginBottom = '10px';

                        if (Array.isArray(gift.histories) && gift.histories.length > 0) {
                            const ul = document.createElement('ul');
                            ul.className = 'giftcard-history';
                            ul.style.listStyle = 'none';
                            ul.style.padding = '0';
                            ul.style.margin = '0';
                            let totalUsed = 0;

                            gift.histories.forEach(h => {
                                const usedAmount = parseFloat(h.used_amount || 0);
                                totalUsed += usedAmount;
                                const date = h.created_at ? new Date(h.created_at).toLocaleDateString() : '—';
                                const user = h.user?.name || 'Unknown User';

                                const li = document.createElement('li');
                                li.style.display = 'flex';
                                li.style.justifyContent = 'space-between';
                                li.style.padding = '4px 0';
                                li.innerHTML = `
                        <span>$${usedAmount.toFixed(2)}</span>
                        <span>${date}</span>
                    `;
                                ul.appendChild(li);
                            });

                            const remaining = (gift.amount - totalUsed).toFixed(2);
                            details.appendChild(ul);
                            details.innerHTML += `<p class="remaining"><strong>Remaining Balance:</strong> $${remaining}</p>`;
                        } else {
                            details.innerHTML = `
        <p class="remaining" style="
            text-align: center;
            color: #777;
            font-style: italic;
            margin: 10px 0;
        ">
            <strong>No usage history yet.</strong>
        </p>
    `;
                        }


                        // --- Card Wrapper ---
                        const card = document.createElement('div');
                        card.className = 'giftcard-card';
                        card.style.marginBottom = '15px';
                        card.appendChild(summary);
                        card.appendChild(details);

                        // --- Toggle on click ---
                        summary.addEventListener('click', () => {
                            const isOpen = details.style.display === 'block';
                            details.style.display = isOpen ? 'none' : 'block';
                            summary.classList.toggle('open', !isOpen);
                        });


                        container.appendChild(card);
                    });
                } catch (err) {
                    console.error("Gift card load error:", err);
                    const container = document.querySelector("#gift-card-set #giftcard-items");
                    if (container) container.innerHTML = '<div class="error-msg">Error loading gift cards.</div>';
                }
            }

            // 🔹 Run when page or gift card tab is opened
            document.addEventListener('DOMContentLoaded', () => {
                const giftCardTab = document.querySelector('[data-target="gift-card-set"]');
                if (giftCardTab) {
                    giftCardTab.addEventListener('click', () => getGiftCards());
                } else {
                    // If it's directly on the gift card page
                    getGiftCards();
                }
            });
        </script>
        <script>
            $(document).on('click', '.delete-card', function() {
                const cardId = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'By deleting this card, you will remove it permanently from your account.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {

                        // Show loading state
                        Swal.fire({
                            title: 'Deleting...',
                            text: 'Please wait while we remove your card.',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        $.ajax({
                            url: "{{ route('cards.delete', ':id') }}".replace(':id', cardId),
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.close();

                                if (response.status === 'ok') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: 'Your card has been removed successfully.',
                                        timer: 1500,
                                        showConfirmButton: false
                                    });

                                    // Optionally remove card from DOM
                                    $(`.card-info-fields[data-card-id="${cardId}"]`).fadeOut(300, function() {
                                        $(this).remove();
                                    });

                                } else {
                                    Swal.fire('Error', response.message || 'Something went wrong.', 'error');
                                }
                            },
                            error: function(xhr) {
                                Swal.close();
                                Swal.fire('Error', xhr.responseJSON?.message || 'Failed to delete card.', 'error');
                            }
                        });
                    }
                });
            });

            // Subscription Toggle Functionality
            $(document).on('click', '#subscription-toggle-btn', function(e) {
                e.preventDefault();
                
                const btn = $(this);
                const originalText = btn.text();
                
                // Disable button and show loading
                btn.prop('disabled', true).text('Processing...');
                
                $.ajax({
                    url: "{{ route('subscription.toggle') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update button text
                            btn.text(response.subscribed ? 'Unsubscribe' : 'Subscribe');
                            
                            // Update status text
                            $('#subscription-status').text(response.subscribed ? 'Subscribed' : 'Unsubscribed');
                            
                            // Show success message
                            $('#subscription-message')
                                .removeClass('alert-danger')
                                .addClass('alert-success')
                                .text(response.message)
                                .fadeIn()
                                .delay(3000)
                                .fadeOut();
                        } else {
                            // Show error message
                            $('#subscription-message')
                                .removeClass('alert-success')
                                .addClass('alert-danger')
                                .text(response.message || 'Failed to update subscription status.')
                                .fadeIn()
                                .delay(3000)
                                .fadeOut();
                            
                            btn.text(originalText);
                        }
                    },
                    error: function(xhr) {
                        // Show error message
                        $('#subscription-message')
                            .removeClass('alert-success')
                            .addClass('alert-danger')
                            .text('An error occurred. Please try again.')
                            .fadeIn()
                            .delay(3000)
                            .fadeOut();
                        
                        btn.text(originalText);
                    },
                    complete: function() {
                        btn.prop('disabled', false);
                    }
                });
            });
        </script>
    </x-slot>
</x-layouts.user-default>

</html>