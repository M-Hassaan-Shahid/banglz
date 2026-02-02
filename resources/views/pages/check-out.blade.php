<x-layouts.user-default>
    <x-slot name="insertstyle">
        <link rel="stylesheet" href="{{ asset('assets/css/extra.css') }}">

        <style>
            #applied-gift-card-row {
    margin: 0; /* optional, keep consistent */
}
#applied-gift-card-amount {
    font-weight: bold;
}
#remove-gift-card {
    text-decoration: none;
    font-size: 14px;
    cursor: pointer;
}

            .d-none {
                display: none !important;
            }

            .active-reward {
                border: 2px solid #4caf50;
                background: #f0fff4;
                border-radius: 8px;
                transition: 0.2s ease-in-out;
            }

            .reward-container {
                display: flex;
                justify-content: center;
                gap: 40px;
                /* space between items */
                flex-wrap: nowrap;
                /* force one row */
            }

            .reward-box {
                margin-top: 20px;
                display: flex;
                flex-direction: column;
                /* image on top, text below */
                align-items: center;
                cursor: pointer;
                padding: 10px;
                border: 2px solid transparent;
                border-radius: 10px;
                transition: 0.2s;
                width: 240px;
                text-align: center;
            }

            .reward-box img {
                max-width: 90px;
                margin-bottom: 8px;
            }

            .reward-box:hover {
                border-color: #ccc;
            }

            .reward-box.selected {
                border-color: #28a745;
                background: #f6fff6;
            }

            .blog-detail-hearo {
                margin-bottom: 0px
            }

            .card-info-fields {
                display: none;
                /* Hide both by default */
            }

            .card-info-fields.active {
                display: flex;
                /* Show when active */
            }

            .place-order {
                background-color: #8d5943;
            }

            .btn.active {
                background: #5f3a2a;
                color: white;
            }

            .saved-details {
                padding: 8px;
                border: 1px solid #ddd;
                border-radius: 6px;
                background: #f9f9f9;
            }

            .save-card {
                align-items: center;
            }

            .save-card label {
                font-weight: 600;
            }

            .save-card select {
                width: 250px;
                border: 1px solid #ddd;
                border-radius: 6px;
            }

            /* Make Stripe Element containers look identical to your inputs */
            .stripe-mount {
                padding: .375rem .75rem;
                min-height: 38px;
                line-height: 1.5;
                border: 0;
                border-bottom: 1px solid #e9e9e9;
                border-radius: 0;
                background: transparent;
                box-shadow: none;
                font-size: 16px;
                height: 90%;
                padding: 15px;
            }

            .field-error {
                color: #d9534f;
                font-size: .9rem;
                margin-top: 6px;
                display: block;
            }

            .card-errors {
                color: #d9534f;
                margin-top: 6px;
            }
            .paypal-icon img{
                height: 40px !important;
    width: 100px !important;
            }
            .link-term{
                color: black !important;
                font-weight: 600 !important;
            }
            .terms-checkbox {
                margin: 15px 0;
                text-align: center;
            }
            .terms-checkbox label {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                cursor: pointer;
                font-size: 14px;
            }
            .terms-checkbox input[type="checkbox"] {
                width: 16px;
                height: 16px;
            }
            .terms-error {
                color: #d9534f;
                font-size: 14px;
                margin-top: 5px;
                text-align: center;
                display: none;
            }
            [type="checkbox"]:checked,
[type="checkbox"]:not(:checked) {
    position: unset;
}
        </style>
    </x-slot>

    <x-slot name="content">
        <div class="product-detail-main-wrapper">
            <div class="checkout-main-section check-out-wraper">
                <div class="top-header">
                    <h1><span>Checkout</span></h1>
                </div>
                <div class="checkout-section-body">
                    <div class="left-checkout-form-wrapper">
                        <form id="checkoutForm" onsubmit="return false;">
                           <h1 style="{{ $type === 'gift_card' ? 'display:none;' : '' }}">Personal information:</h1>
<div class="name-fields" style="{{ $type === 'gift_card' ? 'display:none;' : '' }}">
    <div class="input-field">
        <input type="text" name="name" placeholder="First name" value="{{ $user->name ?? '' }}">
        <span id="error-name" class="field-error text-danger"></span>
    </div>
    <div class="input-field">
        <input type="text" name="last_name" placeholder="Last name" value="{{ $user->last_name ?? '' }}">
        <span id="error-last_name" class="field-error text-danger"></span>
    </div>
</div>

<div class="name-fields" style="{{ $type === 'gift_card' ? 'display:none;' : '' }}">
    <div class="input-field">
        <input type="text" name="phone" placeholder="Phone number" value="{{ $user->mobile ?? '' }}">
        <span id="error-phone" class="field-error text-danger"></span>
    </div>
    <div class="input-field">
        <input type="text" name="user_email" placeholder="Email" value="{{ $user->email ?? '' }}" @if($user) readonly @endif>
        <span id="error-email" class="field-error text-danger"></span>
    </div>
</div>

<h1 style="{{ $type === 'gift_card' ? 'display:none;' : '' }}">Delivery Details:</h1>

<!-- Main Autocomplete Field -->
<div class="input-field" style="{{ $type === 'gift_card' ? 'display:none;' : '' }}">
    <input id="autocomplete" type="text" placeholder="Search your full address">
    <span id="error-autocomplete" class="field-error text-danger"></span>
</div>

<!-- Other Auto-Filled Fields -->
<div class="name-fields" style="{{ $type === 'gift_card' ? 'display:none;' : '' }}">
    <div class="input-field">
        <input type="text" id="country" name="country" placeholder="Country / Region" readonly>
        <span id="error-country" class="field-error text-danger"></span>
    </div>
    <div class="input-field">
        <input type="text" id="city" name="city" placeholder="Town / City" readonly>
        <span id="error-city" class="field-error text-danger"></span>
    </div>
</div>

<div class="name-fields" style="{{ $type === 'gift_card' ? 'display:none;' : '' }}">
    <div class="input-field">
        <input type="text" id="state" name="state" placeholder="State / Province" readonly>
        <span id="error-state" class="field-error text-danger"></span>
    </div>
    <div class="input-field">
        <input type="text" id="postcode" name="postcode" placeholder="Postcode" readonly>
        <span id="error-postcode" class="field-error text-danger"></span>
    </div>
</div>

<div class="name-fields" style="{{ $type === 'gift_card' ? 'display:none;' : '' }}">
    <div class="input-field">
        <input type="text" id="street" name="street" placeholder="Street" readonly>
        <span id="error-street" class="field-error text-danger"></span>
    </div>
</div>

<!-- Hidden Lat/Lng -->
<input type="hidden" id="latitude" name="latitude">
<input type="hidden" id="longitude" name="longitude">
<input type="hidden" id="country_iso" name="country_iso">
<input type="hidden" name="formatted_address" id="formatted_address">
<input type="hidden" name="province_code" id="province_code">
<input type="hidden" name="place_id" id="place_id">
<input type="hidden" name="area" id="area">
<input type="hidden" name="sub_area" id="sub_area">



                            <h1>Payment:</h1>
                            <div class="payment-types">
                                <div class="payment-types">
                                    <div class="payment-type-row">
                                        <label class="custom-radio">
                                            <input type="radio" name="payment_method" value="stripe" checked>
                                            <span class="radiomark"></span>
                                            Stripe
                                        </label>
                                        <div class="right-icon">
                                            <img src="{{ asset('assets/images/stripe_logo.png') }}" alt="">
                                        </div>
                                    </div>
                                    <div class="payment-type-row">
                                        <label class="custom-radio">
                                            <input type="radio" name="payment_method" value="paypal">
                                            <span class="radiomark"></span>
                                            PayPal
                                        </label>
                                        <div class="right-icon paypal-icon">
                                            <img src="{{ asset('assets/images/paypal.png') }}" alt="">
                                        </div>
                                    </div>
                                </div>

                                <!-- PayPal processing message -->
                                <div id="paypal-processing" style="display: none; text-align: center; padding: 20px; background: #f8f9fa; border-radius: 8px; margin: 15px 0;">
                                    <div style="font-size: 16px; color: #8d5943; margin-bottom: 10px;">
                                        <i class="fas fa-spinner fa-spin"></i> Redirecting to PayPal...
                                    </div>
                                    <p>Please wait while we prepare your payment.</p>
                                </div>

                            </div>

                            <div class="card-button mb-3">
                                <div class="btn add-card-btn">+ Add Card</div>
                                <div class="btn save-card-btn">Use Saved Card</div>

                            </div>

                            <!-- NEW CARD: Stripe Elements mounted here -->
                            <div class="card-info-fields add-card" id="new-card-section">
                                <div class="input-field card-number-field">
                                    <input type="text" placeholder="Card number" style="display:none;">
                                    <div id="card-number-element" class="stripe-mount form-control border-0 border-bottom rounded-0 shadow-none"></div>
                                    <span id="error-card-number" class="field-error text-danger"></span>
                                </div>

                                <div class="input-field expiration-field" >
                                    <input type="text" placeholder="Expiration date" style="display:none;">
                                    <div id="card-expiry-element" class="stripe-mount form-control border-0 border-bottom rounded-0 shadow-none" ></div>
                                    <span id="error-card-expiry" class="field-error text-danger"></span>
                                </div>

                                <div class="input-field cvv-field" >
                                    <input type="text" placeholder="CVV" style="display:none;">
                                    <div id="card-cvc-element" class="stripe-mount form-control border-0 border-bottom rounded-0 shadow-none"></div>
                                    <span id="error-card-cvc" class="field-error text-danger"></span>
                                </div>

                                <div id="card-errors" class="card-errors text-danger mt-2"></div>

                                <div style="margin-top:10px; display:none" >
                                    <label>
                                        <input type="checkbox" id="save_card" name="save_card" value="1">
                                    </label>
                                </div>
                            </div>

                            <!-- SAVED CARDS -->
                            <div class="card-info-fields save-card" id="saved-card-section">
                                <label for="saved-cards">Select a saved card:</label>
                                <select id="saved-cards">
                                    @if($user)
                                    <option value="">Loading saved cards...</option>
                                    @else
                                    <option value="">Sign in to view saved cards</option>
                                    @endif
                                </select>

                                <div class="saved-details" id="card-details">
                                    @if($user)
                                    Card: **** **** **** 1234<br>Exp: 12/26
                                    @else
                                    Please sign in to use saved cards.
                                    @endif
                                </div>
                                <span id="error-saved-card" class="field-error text-danger"></span>
                            </div>

                            <div class="promo-section" style="margin-top:12px;">
                                <div class="promo-section promo-back-ground">
                                    <h1>Gift Card</h1>
                                    <div class="promo-field">
                                        <div class="form-group">
                                            <input type="text" name="gift_card_code">
                                            <span id="error-gift_card_code" class="field-error text-danger"></span>
                                        </div>
                                        <div class="btn apply-btn">Apply</div>
                                    </div>
                                </div>

                                <div class="promo-section promo-back-ground" style="margin-top:10px;">
                                    <h1>Rewards & Points</h1>
                                    <div class="reward-container">

                                        @guest
                                        <div class="form-group text-center">
                                            <p>Sign in to redeem Rewards and Free Shipping.</p>
                                            <a href="{{ route('login') }}" class="btn apply-btn">Sign In Or Join</a>
                                        </div>
                                        @else
                                        {{-- Points --}}
                                        @if(auth()->user()->total_points > 0)
                                        <div class="reward-box" id="points-box" data-type="points" data-value="{{ auth()->user()->total_points }}">
                                            <img src="{{ asset('assets/images/benifit-1.svg') }}" alt="Points">
                                            <h3>Redeem Points</h3>
                                            <p class="reward-remaining">
                                                You have <strong>{{ auth()->user()->total_points }}</strong> points
                                            </p>
                                        </div>
                                        @endif

                                        @if(auth()->user()->total_shippings > 0)
                                        <div style="display: none important;" class="reward-box" id="shipping-box" data-type="shipping" data-value="{{ auth()->user()->total_shippings }}">
                                            <img src="{{ asset('assets/images/benifit-3.svg') }}" alt="Free Shipping">
                                            <h3>Free Shipping</h3>
                                            <p class="reward-remaining">
                                                You have <strong>{{ auth()->user()->total_shippings }}</strong> shipping credit(s)
                                            </p>
                                        </div>
                                        @endif

                                        @endguest

                                    </div>
                                </div>

                            </div>
                        </form>

                    </div>

                    <div class="right-cart-items-detail">
                        <h1>Order Summary</h1>
                       <div class="cart-items-total">
    <p style="{{ $type === 'gift_card' ? 'display:none;' : '' }}">
        Sub-total <span id="subtotal-amount">${{ number_format($subTotal, 2) }}</span>
    </p>
    <p style="{{ $type === 'gift_card' ? 'display:none;' : '' }}">
        Tax (5%) <span id="tax-amount">${{ number_format($tax, 2) }}</span>
    </p>
    <p style="{{ $type === 'gift_card' ? 'display:none;' : '' }}">
        Delivery charges <span id="delivery-amount">${{ number_format($delivery, 2) }}</span>
    </p>

    {{-- Hidden by default, will be shown when points are applied --}}
    <p id="us-import-duties-row" class="d-none" style="{{ $type === 'gift_card' ? 'display:none;' : '' }}">
        U.S Import Duties & Fees
        <span id="us-import-duties-amount">$0.00</span>
    </p>
    <p id="discount-row" class="d-none" >
        Rewards Discount <span id="discount-amount">-$0.00</span>
    </p>

    <p style="{{ $type === 'product' ? 'display:none;' : '' }}">
        Gift Card Total Price<span id="gift-card-amount">${{ number_format($giftCardsTotal, 2) }}</span>
    </p>
 <p id="applied-gift-card-row" class="d-none d-flex justify-content-between align-items-center">
    <span>Applied Gift Card</span>
    <span>
        <span id="applied-gift-card-amount">-$0.00</span>
        <a href="javascript:void(0)" id="remove-gift-card" class="text-danger ms-2">✕</a>
    </span>
</p>



</div>


                        <!-- Terms and Conditions Checkbox -->
                       <div class="terms-checkbox">
                                <input type="checkbox" id="terms_agreement" name="terms_agreement">
                                I agree to the <a href="{{ route('resource') }}" class="link-term" target="_blank">Terms & Conditions</a>
                                and <a href="{{ route('resource') }}" class="link-term" target="_blank">Privacy Policy</a>
                            <div id="terms-error" class="terms-error">Please accept the terms and conditions to proceed</div>
                        </div>

                        <div class="cart-total-payment">
                            <h1>Total: 
    <span id="grand-total">
        ${{ number_format($total, 2) }}
    </span>
</h1>

                            <!-- <h1>Total: <span id="grand-total">${{ number_format($total, 2) }}</span></h1> -->
                            <div class="cart-footer-buttons">
                                <div class="common-button-light">
                                    <button id="cancelBtn" class="btn cancel-btn">Cancel</button>
                                </div>
                                <div class="common-button place-order">
                                    <button id="placeOrderBtn" class="btn">Place order</button>
                                </div>
                            </div>
                            <div id="checkout-message" style="margin-top:.75rem;"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </x-slot>

    <x-slot name="insertjavascript">
        <script src="https://www.paypal.com/sdk/js?client-id={{ config('services.paypal.sandbox_client_id') }}&currency=USD"></script>

        <script>
            // declare as globals so any later script can read them
            window.AMOUNT = parseFloat("{{ $total ?? 0 }}") || 0;
            window.TAX = parseFloat("{{ $tax ?? 0 }}") || 0;
            window.SHIPPING_FEE = parseFloat("{{ $delivery ?? 0 }}") || 0;
            window.BASE_SHIPPING_FEE = parseFloat("{{ $delivery ?? 0 }}") || 0;
            window.CURRENCY = 'usd';
            window.GIFT_CARDS_TOTAL = {{ $giftCardsTotal ?? 0 }};
            window.TYPE = '{{ $type ?? '' }}';
            window. appliedGiftCardAmount = 0;
            window.appliedGiftCardCode = '';
            window. appliedGiftCardMax = 0; // server gift card total for this code
            APPLIED_GIFT_CARD_META = [];
            
        </script>

        <!-- Stripe -->
        <script src="https://js.stripe.com/v3/"></script>
        <!-- SweetAlert2 (for friendly messages) -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready(function() {
                // DOM references
                const $addCardBtn = $('.add-card-btn');
                const $saveCardBtn = $('.save-card-btn');
                const $newCardSection = $('#new-card-section');
                const $savedCardSection = $('#saved-card-section');
                const $savedCardsSelect = $('#saved-cards');
                const $cardDetails = $('#card-details');
                const $cardErrors = $('#card-errors');
                const $placeOrderBtn = $('#placeOrderBtn');
                const $checkoutMessage = $('#checkout-message');
                const $termsCheckbox = $('#terms_agreement');
                const $termsError = $('#terms-error');

                $checkoutMessage.html('');

                // 🔄 Loader element
                const $loader = $(`
  <div id="loader" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:#00000066;z-index:9999;">
    <div style="display:flex;align-items:center;justify-content:center;height:100%;">
      <div style="background:#fff;padding:20px;border-radius:10px;box-shadow:0 0 10px #000;">
        Processing Your order please wait...
      </div>
    </div>
  </div>
`);
                $('body').append($loader);

                function showLoader() {
                    $loader.show();
                }

                function hideLoader() {
                    $loader.hide();
                }

                // Product metadata from server (keep structure provided by controller)
                const PRODUCTS_META = @json($product_meta_data);
                const GIFT_CARD_META = @json($gift_card_mata_data);
                const BangleBox_META = @json($bangle_box_meta_data);
                // server-side totals
                const TAX = parseFloat("{{ $tax ?? 0 }}") || 0;
                const CURRENCY = 'usd';

                // Toggle active section
                function activate(button, section) {
                    document.querySelectorAll('.btn').forEach(btn => btn.classList.remove('active'));
                    document.querySelectorAll('.card-info-fields').forEach(sec => sec.classList.remove('active'));
                    if (button) button.classList.add('active');
                    if (section) section.classList.add('active');
                }

                $addCardBtn.on('click', () => activate($addCardBtn[0], $newCardSection[0]));
                $saveCardBtn.on('click', () => activate($saveCardBtn[0], $savedCardSection[0]));

                // Default view (preserve your original intent)
                @if($user)
                activate($saveCardBtn[0], $savedCardSection[0]);
                @else
                activate($addCardBtn[0], $newCardSection[0]);
                @endif

                // --- Stripe Elements (unchanged) ---
                const stripeKey = "{{ config('services.stripe.key') ?? env('STRIPE_KEY') }}";
                if (!stripeKey) {
                    $cardErrors.text('Payment unavailable.');
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

                const $errNumber = $('#error-card-number');
                const $errExpiry = $('#error-card-expiry');
                const $errCvc = $('#error-card-cvc');

                function clearErrors() {
                    $errNumber.text('');
                    $errExpiry.text('');
                    $errCvc.text('');
                    $cardErrors.text('');
                    $('#error-saved-card').text('');
                    $checkoutMessage.text('');
                    $termsError.hide();
                }

                cardNumber.on('change', e => $errNumber.text(e.error ? e.error.message : ''));
                cardExpiry.on('change', e => $errExpiry.text(e.error ? e.error.message : ''));
                cardCvc.on('change', e => $errCvc.text(e.error ? e.error.message : ''));

                // --- Load saved cards (unchanged) ---
                function loadSavedCards() {
                    if (!$savedCardsSelect.length) return;
                    $savedCardsSelect.html('<option>Loading...</option>');
                    $.getJSON("{{ route('cards.list') }}")
                        .done(res => {
                            $savedCardsSelect.empty();
                            if (res && res.status === 'ok' && Array.isArray(res.cards) && res.cards.length) {
                                $savedCardsSelect.append('<option value="">-- choose saved card --</option>');
                                res.cards.forEach(c => {
                                    $('<option>')
                                        .val(c.id)
                                        .text((c.brand || '') + ' **** ' + (c.last4 || ''))
                                        .data({
                                            last4: c.last4,
                                            exp_month: c.exp_month,
                                            exp_year: c.exp_year
                                        })
                                        .prop('selected', c.is_default)
                                        .appendTo($savedCardsSelect);
                                });
                                updateCardDetails();
                            } else {
                                $savedCardsSelect.append('<option value="">No saved cards</option>');
                                $cardDetails.text('No saved cards found.');
                            }
                        })
                        .fail(() => {
                            $savedCardsSelect.html('<option value="">Error loading cards</option>');
                            $cardDetails.text('Could not load saved cards.');
                        });
                }

                function updateCardDetails() {
                    const val = $savedCardsSelect.val();
                    const opt = $savedCardsSelect.find('option:selected');
                    if (val) {
                        const last4 = opt.data('last4') || '----';
                        const mm = opt.data('exp_month') || '';
                        const yy = opt.data('exp_year') || '';
                        const displayExp = mm && yy ? mm + '/' + String(yy).slice(-2) : '';
                        $cardDetails.html('Card: **** **** **** ' + last4 + '<br>Exp: ' + displayExp);
                    } else {
                        $cardDetails.html(@json($user ? 'Select a card to see details.' : 'Please sign in to use saved cards.'));
                    }
                }

                $savedCardsSelect.on('change', updateCardDetails);
                loadSavedCards();

                // Helper to gather user and delivery fields
                function gatherFormData() {
                    return {
                        users_meta_data: {
                            name: $('input[name="name"]').val() || '',
                            last_name: $('input[name="last_name"]').val() || '',
                            phone: $('input[name="phone"]').val() || '',
                            email: $('input[name="user_email"]').val() || '',
                        },
                     delivery_meta_data: {
    address: $('#autocomplete').val() || '',   // full selected address
    formatted_address: $('input[name="formatted_address"]').val() || '',
    street: $('input[name="street"]').val() || '',
    area: $('input[name="area"]').val() || '',
    sub_area: $('input[name="sub_area"]').val() || '',
    city: $('input[name="city"]').val() || '',
    state_province: $('input[name="state"]').val() || '',
    province_code: $('input[name="province_code"]').val() || '',
    country: $('input[name="country"]').val() || '',
    country_iso: $('input[name="country_iso"]').val() || '',
    postcode: $('input[name="postcode"]').val() || '',
    latitude: $('input[name="latitude"]').val() || '',
    longitude: $('input[name="longitude"]').val() || '',
    place_id: $('input[name="place_id"]').val() || ''
}

                    };
                }

                // Function to validate terms agreement
                function validateTerms() {
                    if (!$termsCheckbox.is(':checked')) {
                        $termsError.show();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Terms Required',
                            text: 'Please agree to the Terms & Conditions and Privacy Policy to proceed.'
                        });
                        return false;
                    }
                    $termsError.hide();
                    return true;
                }

                // --- Place order / checkout ---
                $placeOrderBtn.on('click', function(e) {
                    e.preventDefault();
                    clearErrors();

                    // Validate terms agreement first
                    if (!validateTerms()) {
                        return;
                    }

                    $placeOrderBtn.prop('disabled', true);
                    $checkoutMessage.text('Processing payment...').css('color', '#333');
                    showLoader();

                    const selectedPaymentMethod = $('input[name="payment_method"]:checked').val();

                    // Handle PayPal payment
                    if (selectedPaymentMethod === 'paypal') {
                        processPayPalPayment();
                        return;
                    }

                    // Handle Stripe payment (existing code)
                    processStripePayment();
                });

                // PayPal Payment Processing
                function processPayPalPayment() {
                    $('#paypal-processing').show();

                    // Create a NEW form instead of using the hidden one
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = "{{ route('payment') }}";
                    form.style.display = 'none';

                    // Add CSRF token
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = "{{ csrf_token() }}";
                    form.appendChild(csrfToken);

                    // Add amount
                    const amountInput = document.createElement('input');
                    amountInput.type = 'hidden';
                    amountInput.name = 'amount';
                    amountInput.value = (FINAL_TOTAL + US_DUTIES).toFixed(2);
                    form.appendChild(amountInput);

                    // Add other necessary data
                    const formDataParts = gatherFormData();

                    const usersMetaInput = document.createElement('input');
                    usersMetaInput.type = 'hidden';
                    usersMetaInput.name = 'users_meta_data';
                    usersMetaInput.value = JSON.stringify(formDataParts.users_meta_data);
                    form.appendChild(usersMetaInput);

                    const deliveryMetaInput = document.createElement('input');
                    deliveryMetaInput.type = 'hidden';
                    deliveryMetaInput.name = 'delivery_meta_data';
                    deliveryMetaInput.value = JSON.stringify(formDataParts.delivery_meta_data);
                    form.appendChild(deliveryMetaInput);

                    const productsMetaInput = document.createElement('input');
                    productsMetaInput.type = 'hidden';
                    productsMetaInput.name = 'products_meta_data';
                    productsMetaInput.value = JSON.stringify(PRODUCTS_META || { Products: [], Bundle: [] });
                    form.appendChild(productsMetaInput);

                    // Add to page and submit
                    document.body.appendChild(form);
                    form.submit();
                }

                // Stripe Payment Processing
                function processStripePayment() {
                    const selectedSavedCardId = $savedCardsSelect.length ? $savedCardsSelect.val() : null;
                    const saveCard = $('#save_card').is(':checked') ? 1 : 0;
                    const currency = 'usd';

                    const formDataParts = gatherFormData();

                    if (selectedSavedCardId) {
                        $.post("{{ route('checkout.createPaymentIntent') }}", {
                            amount: FINAL_TOTAL,
                            giftCardsTotal:window.GIFT_CARDS_TOTAL || 0,
                            appliedGiftCardAmount: window.appliedGiftCardAmount || 0, // ✅ amount used
    appliedGiftCardCode: window.appliedGiftCardCode || '',     // ✅ single code
     applied_gift_card_meta_data: JSON.stringify(window.APPLIED_GIFT_CARD_META || []), // ✅ full meta
                           type: window.TYPE || "",
                            us_import_duties: US_DUTIES,
                            rewards_discount: $('#discount-amount').text().replace('$', '').replace('-', '').replace(',', '') || 0,
                            subtotal: $('#subtotal-amount').text().replace('$', '').replace(',', '') || 0,
                            currency: currency,
                            use_saved_card_id: selectedSavedCardId,
                            products_meta_data: JSON.stringify(PRODUCTS_META || {
                                Products: [],
                                Bundle: []
                            }),
                            gift_card_meta_data: JSON.stringify(GIFT_CARD_META || []),
     bangle_box_meta_data: JSON.stringify(BangleBox_META || []),

                            users_meta_data: JSON.stringify(formDataParts.users_meta_data),
                            delivery_meta_data: JSON.stringify(formDataParts.delivery_meta_data),
                            tax: TAX,
                            shipping_fee: appliedShipping ? 0 : BASE_SHIPPING_FEE,
                            email: formDataParts.users_meta_data.email,
                            applied_points: USED_POINTS_FOR_CHECKOUT, // convert $ back → points
                            applied_shipping: appliedShipping ? 1 : 0, // free shipping used?
                            _token: "{{ csrf_token() }}"
                        }).done(resp => {
                            hideLoader();
                            if (resp && resp.status === 'ok') {
                                                              const orderId = data.order_id;
    const orderDate = data.date;
    const message = encodeURIComponent(data.message || 'Order placed successfully');
    console.log(data);
            window.location.href = "{{ url('confirmation') }}/" + orderId + "/" + orderDate;
    return; // already handled below
                                if (resp.is_free) {
                                    $checkoutMessage.text('Order placed successfully — no payment needed.').css('color', '#3c763d');
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Order Successful',
                                        text: resp.message || 'Thank you! Your order has been placed.',
                                        confirmButtonText: 'Go to Home'
                                    }).then(() => {
                                        window.location.href = "{{ route('home') }}";
                                    });
                                    return;
                                }
                            }
                            if (resp && resp.status === 'ok') {
                                $checkoutMessage.text('Payment successful — thank you!').css('color', '#3c763d');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Payment successful',
                                    text: resp.message || 'Thank you! Your payment has been processed.',
                                    confirmButtonText: 'Go to Home'
                                }).then(() => {
                                    window.location.href = "{{ route('home') }}";
                                });
                            } else if (resp && resp.status === 'requires_action') {
                                $checkoutMessage.text(resp.message || 'Action required').css('color', '#d9534f');
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Action required',
                                    text: resp.message || 'Additional authentication required.'
                                });
                            } else {
                                $checkoutMessage.text(resp.message || 'Payment failed').css('color', '#d9534f');
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Payment failed',
                                    text: resp.message || 'Payment failed'
                                });
                            }
                        }).fail(xhr => {
                            hideLoader();
                            $checkoutMessage.text(xhr.responseJSON?.message || 'Payment failed').css('color', '#d9534f');
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: xhr.responseJSON?.message || 'Payment failed'
                            });
                        }).always(() => {
                            $placeOrderBtn.prop('disabled', false);
                        });
                        return;
                    }

                    stripe.createPaymentMethod({
                        type: 'card',
                        card: cardNumber
                    }).then(result => {
                        if (result.error) {
                            hideLoader();
                            $cardErrors.text(result.error.message);
                            $placeOrderBtn.prop('disabled', false);
                            $checkoutMessage.text('Card Error').css('color', '#d9534f');
                            Swal.fire({
                                icon: 'error',
                                title: 'Card Error',
                                text: result.error.message
                            });
                            return;
                        }

                        $.post("{{ route('checkout.createPaymentIntent') }}", {
                            amount: FINAL_TOTAL,
                            giftCardsTotal:window.GIFT_CARDS_TOTAL || 0,
                           type: window.TYPE || "",
                           appliedGiftCardAmount: window.appliedGiftCardAmount || 0, // ✅ amount used
                             appliedGiftCardCode: window.appliedGiftCardCode || '',     // ✅ single code
                            applied_gift_card_meta_data: JSON.stringify(window.APPLIED_GIFT_CARD_META || []),                             us_import_duties: US_DUTIES,
                            rewards_discount: $('#discount-amount').text().replace('$', '').replace('-', '').replace(',', '') || 0,
                            subtotal: $('#subtotal-amount').text().replace('$', '').replace(',', '') || 0,
                            currency: currency,
                            save_card: saveCard,
                            gift_card_meta_data: JSON.stringify(GIFT_CARD_META || []),
                           bangle_box_meta_data: JSON.stringify(BangleBox_META || []),

                            payment_method_id: result.paymentMethod.id,
                            products_meta_data: JSON.stringify(PRODUCTS_META || {
                                Products: [],
                                Bundle: []
                            }),
                            users_meta_data: JSON.stringify(formDataParts.users_meta_data),
                            delivery_meta_data: JSON.stringify(formDataParts.delivery_meta_data),
                            tax: TAX,
                            shipping_fee: appliedShipping ? 0 : BASE_SHIPPING_FEE,
                            email: formDataParts.users_meta_data.email,
                            applied_points: USED_POINTS_FOR_CHECKOUT, // convert $ back → points
                            applied_shipping: appliedShipping ? 1 : 0, // free shipping used?
                            _token: "{{ csrf_token() }}"
                          }).done(data => {
                                hideLoader();
                             if (data && data.status === 'ok') {
                                    const orderId = data.order_id;
    const orderDate = data.date;
    const message = encodeURIComponent(data.message || 'Order placed successfully');
    console.log(data);
            window.location.href = "{{ url('confirmation') }}/" + orderId + "/" + orderDate;
    return; // already handled below
                                if (data.is_free) {
                                    $checkoutMessage.text('Order placed successfully — no payment needed.').css('color', '#3c763d');
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Order Successful',
                                        text: data.message || 'Thank you! Your order has been placed.',
                                        confirmButtonText: 'Go to Home'
                                    }).then(() => {
                                        window.location.href = "{{ route('home') }}";
                                    });
                                    return;
                                }
                            }
                            if (!data || data.status !== 'ok' || !data.client_secret) {
                                hideLoader();
                                $checkoutMessage.text(data?.message || 'Failed to initiate payment').css('color', '#d9534f');
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data?.message || 'Failed to initiate payment'
                                });
                                $placeOrderBtn.prop('disabled', false);
                                return;
                            }

                            stripe.confirmCardPayment(data.client_secret, {
                                payment_method: result.paymentMethod.id
                            }).then(r => {
                                hideLoader();
                                if (r.error) {
                                    $cardErrors.text(r.error.message || 'Payment failed');
                                    $checkoutMessage.text('Payment failed: ' + (r.error.message || '')).css('color', '#d9534f');
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Payment failed',
                                        text: r.error.message || ''
                                    });
                                    $placeOrderBtn.prop('disabled', false);
                                } else if (r.paymentIntent && r.paymentIntent.status === 'succeeded') {
                                    $checkoutMessage.text('Payment successful — thank you!').css('color', '#3c763d');
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Payment successful',
                                        text: 'Thank you! Your payment has been processed.',
                                        confirmButtonText: 'Go to Home'
                                    }).then(() => {
                                        window.location.href = "{{ route('home') }}";
                                    });

                                    $.post("{{ route('checkout.complete') }}", {
                                            payment_intent: r.paymentIntent.id,
                                            save_card: saveCard,
                                            _token: "{{ csrf_token() }}"
                                        }).done(() => loadSavedCards())
                                        .always(() => {
                                            $placeOrderBtn.prop('disabled', false);
                                        });
                                } else {
                                    $checkoutMessage.text('Payment not completed: ' + (r.paymentIntent?.status || 'unknown')).css('color', '#d9534f');
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Payment not completed',
                                        text: 'Status: ' + (r.paymentIntent?.status || 'unknown')
                                    });
                                    $placeOrderBtn.prop('disabled', false);
                                }
                            }).catch(err => {
                                hideLoader();
                                $checkoutMessage.text(err.message || 'Payment error').css('color', '#d9534f');
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Payment error',
                                    text: err.message || 'Payment error'
                                });
                                $placeOrderBtn.prop('disabled', false);
                            });
                        }).fail(xhr => {
                            hideLoader();
                            $checkoutMessage.text(xhr.responseJSON?.message || 'Failed to start payment').css('color', '#d9534f');
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: xhr.responseJSON?.message || 'Failed to start payment'
                            });
                            $placeOrderBtn.prop('disabled', false);
                        });
                    });
                }

                // Cancel
                $('#cancelBtn').on('click', () => window.history.back());

                // Handle payment method change (just UI, no immediate redirect)
                $('input[name="payment_method"]').change(function() {
                    const method = $(this).val();
                    console.log('Payment method changed to:', method);

                    if (method === 'paypal') {
                        // Just show PayPal message, don't redirect yet
                        $('.card-button').hide();
                        $('.card-info-fields').hide();
                        $('#paypal-processing').hide(); // Only show when actually processing
                    } else if (method === 'stripe') {
                        showStripeSections();
                        $('#paypal-processing').hide();
                    }
                });

                function showStripeSections() {
                    $('.card-button').show();
                    $('#paypal-processing').hide();

                    @if($user)
                    $('#saved-card-section').show();
                    $('.save-card-btn').addClass('active');
                    @else
                    $('#new-card-section').show();
                    $('.add-card-btn').addClass('active');
                    @endif
                }
            });
        </script>

        <!-- Rest of your existing scripts (rewards, Google Maps, etc.) remain the same -->
        <script>
            // --- Global values from backend ---
            window.AMOUNT = parseFloat("{{ $total ?? 0 }}") || 0;
            window.TAX = parseFloat("{{ $tax ?? 0 }}") || 0;
            window.BASE_SHIPPING_FEE = parseFloat("{{ $delivery ?? 0 }}") || 0;
            window.CURRENCY = 'usd';

            // --- State ---
            let appliedPointsDollar = 0;
            let appliedShipping = false;
            let FINAL_TOTAL = window.AMOUNT;
            let US_DUTIES = 0;
            let USED_POINTS_FOR_CHECKOUT = 0;
            let DELIVERY_FOR_CHECKOUT = BASE_SHIPPING_FEE;
            let usedPoints=0;

            // function updateTotals(userPoints = 0, userShippings = 0) {
            //     const subtotal = window.AMOUNT;
            //     const tax = window.TAX;
            //     const delivery = appliedShipping ? 0 : BASE_SHIPPING_FEE;
            //     const giftCardsTotal = window.GIFT_CARDS_TOTAL || 0;
            //     // pre-discount total (what we must cover)
            //     const preDiscountTotal = subtotal + tax + delivery+US_DUTIES;

            //     // how much $ can be provided by user's points
            //     const maxDiscountFromPoints = userPoints / 100; // convert points -> dollars

            //     // discount actually applied from points:
            //     // - cannot exceed what user chose (appliedPointsDollar)
            //     // - cannot exceed invoice preDiscountTotal
            //     // - cannot exceed points-available (maxDiscountFromPoints)
            //     const discountFromPoints = Math.min(appliedPointsDollar, preDiscountTotal, maxDiscountFromPoints);

            //     usedPoints = Math.floor(discountFromPoints * 100);
            //     const total = preDiscountTotal - discountFromPoints;

            //     FINAL_TOTAL = total;
            //     USED_POINTS_FOR_CHECKOUT = usedPoints;
            //     DELIVERY_FOR_CHECKOUT = delivery;

            //     document.getElementById("subtotal-amount").textContent = `$${subtotal.toFixed(2)}`;
            //     document.getElementById("tax-amount").textContent = `$${tax.toFixed(2)}`;
            //     document.getElementById("delivery-amount").textContent = appliedShipping ? "Free" : `$${BASE_SHIPPING_FEE.toFixed(2)}`;

            //     if (discountFromPoints > 0) {
            //         document.getElementById("discount-row").classList.remove("d-none");
            //         document.getElementById("discount-amount").textContent = `-$${discountFromPoints.toFixed(2)}`;
            //     } else {
            //         document.getElementById("discount-row").classList.add("d-none");
            //     }

            //     document.getElementById("grand-total").textContent = `$${total.toFixed(2)}`;

            //     if (userPoints > 0) {
            //         const remainingPoints = Math.max(0, userPoints - usedPoints);
            //         const pointsBox = document.querySelector("#points-box .reward-remaining");
            //         if (pointsBox) {
            //             pointsBox.innerHTML = `You have <strong>${remainingPoints}</strong> points left`;
            //         }
            //     }

            //     if (userShippings > 0) {
            //         const remainingShipping = Math.max(0, userShippings - (appliedShipping ? 1 : 0));
            //         const shippingBox = document.querySelector("#shipping-box .reward-remaining");
            //         if (shippingBox) {
            //             shippingBox.innerHTML = `You have <strong>${remainingShipping}</strong> shipping credit(s) left`;
            //         }
            //     }
            // }
          function updateTotals(userPoints = 0, userShippings = 0) {
    const subtotal = window.AMOUNT;
    const tax = window.TAX;
    const giftCardsTotal = window.GIFT_CARDS_TOTAL || 0; // purchased gift card products
    const type = window.TYPE || ""; 

    const delivery = type === "gift_card" ? 0 : (appliedShipping ? 0 : BASE_SHIPPING_FEE);

    const preDiscountTotal = subtotal + tax + delivery + US_DUTIES;

    const maxDiscountFromPoints = userPoints / 100;
    const discountFromPoints = Math.min(appliedPointsDollar, preDiscountTotal, maxDiscountFromPoints);
    usedPoints = Math.floor(discountFromPoints * 100);

    const totalWithoutGiftCards = preDiscountTotal - discountFromPoints;

    // ✅ Final total = products + gift cards (purchased) - applied gift card balance
    const totalWithGiftCardProducts = totalWithoutGiftCards + giftCardsTotal;
    const totalAfterGiftCardUsage = Math.max(0, totalWithGiftCardProducts - appliedGiftCardAmount);

    FINAL_TOTAL = totalAfterGiftCardUsage;
    USED_POINTS_FOR_CHECKOUT = usedPoints;
    DELIVERY_FOR_CHECKOUT = delivery;

    // Update DOM
    document.getElementById("subtotal-amount").textContent = `$${subtotal.toFixed(2)}`;
    document.getElementById("tax-amount").textContent = `$${tax.toFixed(2)}`;

    if (type != "gift_card") {
        document.getElementById("delivery-amount").textContent = delivery === 0 ? "Free" : `$${delivery.toFixed(2)}`;
    }

    if (discountFromPoints > 0) {
        document.getElementById("discount-row").classList.remove("d-none");
        document.getElementById("discount-amount").textContent = `-$${discountFromPoints.toFixed(2)}`;
    } else {
        document.getElementById("discount-row").classList.add("d-none");
    }

    document.getElementById("grand-total").textContent = `$${FINAL_TOTAL.toFixed(2)}`;
}


// function updateTotals(userPoints = 0, userShippings = 0) {
//     const subtotal = window.AMOUNT;
//     const tax = window.TAX;
//     const giftCardsTotal = window.GIFT_CARDS_TOTAL || 0;
//     const type = window.TYPE || ""; // e.g. "gift_card"

//     // 🚨 if cart type is gift card => no delivery
//     const delivery = type === "gift_card" ? 0 : (appliedShipping ? 0 : BASE_SHIPPING_FEE);

//     // normal cart items total (products/bundles only, without gift cards)
//     const preDiscountTotal = subtotal + tax + delivery + US_DUTIES;

//     // max discount user can apply with points
//     const maxDiscountFromPoints = userPoints / 100;

//     // discount actually applied
//     const discountFromPoints = Math.min(appliedPointsDollar, preDiscountTotal, maxDiscountFromPoints);

//     usedPoints = Math.floor(discountFromPoints * 100);

//     // ✅ gift cards are added AFTER all other totals
//     const totalWithoutGiftCards = preDiscountTotal - discountFromPoints;
//     FINAL_TOTAL = totalWithoutGiftCards;
//     const grandTotal = totalWithoutGiftCards + giftCardsTotal;
//     USED_POINTS_FOR_CHECKOUT = usedPoints;
//     DELIVERY_FOR_CHECKOUT = delivery;

//     // Update DOM
//     document.getElementById("subtotal-amount").textContent = `$${subtotal.toFixed(2)}`;
//     document.getElementById("tax-amount").textContent = `$${tax.toFixed(2)}`;
    
//     // hide delivery row completely if type is gift_card
//     if (type == "gift_card") {
//         // document.getElementById("delivery-row").classList.add("d-none");
//     } else {
//         // document.getElementById("delivery-row").classList.remove("d-none");
//         document.getElementById("delivery-amount").textContent = delivery === 0 ? "Free" : `$${delivery.toFixed(2)}`;
//     }

//         // alert('hehehe');
//     if (discountFromPoints > 0) {
//         document.getElementById("discount-row").classList.remove("d-none");
//         document.getElementById("discount-amount").textContent = `-$${discountFromPoints.toFixed(2)}`;
//     } else {
//         document.getElementById("discount-row").classList.add("d-none");
//     }
//     // alert(grandTotal);

//     // ✅ Final total includes gift cards, but tax/shipping/discounts don't affect them
//     document.getElementById("grand-total").textContent = `$${grandTotal.toFixed(2)}`;
// }


            document.addEventListener("click", function(e) {
                if (e.target.closest("#points-box")) {
                    const box = document.getElementById("points-box");
                    const userPoints = parseInt(box.dataset.value, 10) || 0;
                    const maxDiscount = userPoints / 100;

                    if (appliedPointsDollar > 0) {
                        appliedPointsDollar = 0;
                        updateTotals(userPoints, parseInt(document.getElementById("shipping-box")?.dataset.value || 0));
                        Toast.fire({
                            icon: 'info',
                            title: 'Points Removed'
                        });
                        box.classList.remove("active-reward");
                    } else {
                        appliedPointsDollar = maxDiscount;
                        updateTotals(userPoints, parseInt(document.getElementById("shipping-box")?.dataset.value || 0));
                        Toast.fire({
                            icon: 'success',
                            title: `Points Applied: ${usedPoints.toFixed(2)}`
                        });
                        box.classList.add("active-reward");
                    }
                }

                if (e.target.closest("#shipping-box")) {
                    const box = document.getElementById("shipping-box");
                    const userShippings = parseInt(box.dataset.value, 10) || 0;

                    appliedShipping = !appliedShipping;
                    updateTotals(parseInt(document.getElementById("points-box")?.dataset.value || 0), userShippings);

                    if (appliedShipping) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Free Shipping Applied'
                        });
                        box.classList.add("active-reward");
                    } else {
                        Toast.fire({
                            icon: 'info',
                            title: 'Shipping Removed'
                        });
                        box.classList.remove("active-reward");
                    }
                }
            });

            updateTotals(
                parseInt(document.getElementById("points-box")?.dataset.value || 0),
                parseInt(document.getElementById("shipping-box")?.dataset.value || 0)
            );
        </script>

      <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&libraries=places"></script>
<script>
//     function initAutocomplete() {
//         const input = document.getElementById('autocomplete');
//         const autocomplete = new google.maps.places.Autocomplete(input, { types: ['address'] });

//         autocomplete.setFields(['address_components', 'geometry']);

//         autocomplete.addListener('place_changed', function() {
//             const place = autocomplete.getPlace();
//             if (!place.address_components) return;

//             let comp = {};
//             place.address_components.forEach(c => {
//                 c.types.forEach(t => {
//                     comp[t] = c.long_name;
//                     comp[t + '_short'] = c.short_name;
//                 });
//             });
//              window.postalcode= comp['postal_code'];
//             if (!comp['postal_code'] && place.geometry) {
//     const lat = place.geometry.location.lat();
//     const lng = place.geometry.location.lng();
    
//     fetch(`https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lng}&key={{ config('services.google.maps_api_key') }}`)
//         .then(res => res.json())
//         .then(data => {
//             if (data.results?.length) {
//                 const postalComp = data.results[0].address_components.find(c => c.types.includes('postal_code'));
//                 if (postalComp) {
//                     console.log('Found postal code:', postalComp['long_name']);
//                     console.log('Short name:', postalComp['short_name']);
//                     window.postalcode = postalComp['long_name'];
//                 }
//             }
//         })
//         .catch(err => console.error('Postal code lookup failed:', err));
// }
//             // Fill fields
//             document.getElementById('country').value   = comp['country'] || '';
//             document.getElementById('city').value      = comp['locality'] || comp['administrative_area_level_2'] || '';
//             document.getElementById('state').value     = comp['administrative_area_level_1'] || '';
//             document.getElementById('postcode').value  = postalcode || '';
            
//             document.getElementById('street').value    = (comp['street_number'] ? comp['street_number'] + ' ' : '') + (comp['route'] || '');
//             document.getElementById('latitude').value  = place.geometry?.location?.lat() || '';
//             document.getElementById('longitude').value = place.geometry?.location?.lng() || '';
//             document.getElementById('country_iso').value = comp['country_short'] || '';
//            // ✅ Added missing ones
// document.getElementById('formatted_address').value = place.formatted_address || '';
// document.getElementById('province_code').value     = comp['administrative_area_level_1_short'] || '';
// document.getElementById('place_id').value          = place.place_id || '';
// document.getElementById('area').value              = comp['sublocality'] || comp['neighborhood'] || '';
// document.getElementById('sub_area').value          = comp['sublocality_level_1'] || comp['sublocality_level_2'] || '';
//             // ✅ Handle Import Duties
//             handleImportDuties(comp['country_short']);
//         });
//     }
function initAutocomplete() {
    const input = document.getElementById('autocomplete');
    const autocomplete = new google.maps.places.Autocomplete(input, { types: ['address'] });

    autocomplete.setFields(['address_components', 'geometry']);

    // ✅ Make callback async so we can use await
    autocomplete.addListener('place_changed', async function() {
        const place = autocomplete.getPlace();
        if (!place.address_components) return;

        let comp = {};
        place.address_components.forEach(c => {
            c.types.forEach(t => {
                comp[t] = c.long_name;
                comp[t + '_short'] = c.short_name;
            });
        });

        // Extract postal
        let postal = comp['postal_code'] || '';
        window.postalcode = postal;

        // ✅ Reverse geocode if postal missing
        if (!postal && place.geometry) {
            const lat = place.geometry.location.lat();
            const lng = place.geometry.location.lng();

            try {
                const res = await fetch(
                    `https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lng}&key={{ config('services.google.maps_api_key') }}`
                );
                const data = await res.json();
                if (data.results?.length) {
                    const postalComp = data.results[0].address_components.find(c => c.types.includes('postal_code'));
                    if (postalComp) {
                        postal = postalComp.long_name;
                        window.postalcode = postal;
                        console.log('✅ Found postal code via reverse geocoding:', postal);
                    }
                }
            } catch (err) {
                console.error('Postal code lookup failed:', err);
            }
        }

        // ✅ Fill fields only after postal is resolved
        document.getElementById('country').value = comp['country'] || '';
        document.getElementById('country_iso').value = comp['country_short'] || '';
        document.getElementById('state').value = comp['administrative_area_level_1'] || '';
        document.getElementById('city').value = comp['locality'] || comp['administrative_area_level_2'] || '';
document.getElementById('province_code').value     = comp['administrative_area_level_1_short'] || '';

        document.getElementById('postcode').value = window.postalcode || '';
        document.getElementById('street').value = (comp['street_number'] ? comp['street_number'] + ' ' : '') + (comp['route'] || '');
        document.getElementById('latitude').value = place.geometry?.location?.lat() || '';
        document.getElementById('longitude').value = place.geometry?.location?.lng() || '';

        // ✅ Optional: log to verify
        console.log('📦 Final Postal Code:', postal);

        // Optionally call duties handler
        handleImportDuties(comp['country_short']);
    });
}

google.maps.event.addDomListener(window, 'load', initAutocomplete);


    function handleImportDuties(countryCode) {
        const subtotalEl = document.getElementById('subtotal-amount');
        const dutiesRow = document.getElementById('us-import-duties-row');
        const dutiesAmountEl = document.getElementById('us-import-duties-amount');
        const grandTotalEl = document.getElementById('grand-total');

        let subtotal = parseFloat(subtotalEl.textContent.replace(/[^0-9.-]+/g,"")) || 0;
        let tax = parseFloat(document.getElementById('tax-amount').textContent.replace(/[^0-9.-]+/g,"")) || 0;
        let delivery = parseFloat(document.getElementById('delivery-amount').textContent.replace(/[^0-9.-]+/g,"")) || 0;
        let discount = parseFloat(document.getElementById('discount-amount').textContent.replace(/[^0-9.-]+/g,"")) || 0;

        let duties = 0;

        if (countryCode === 'US') {
            duties = subtotal * 0.20; // 20%
            dutiesRow.classList.remove('d-none');
            dutiesAmountEl.textContent = `$${duties.toFixed(2)}`;
            US_DUTIES = duties;
            FINAL_TOTAL=FINAL_TOTAL+US_DUTIES;
                document.getElementById("grand-total").textContent = `$${FINAL_TOTAL}`;
        } else {
            dutiesRow.classList.add('d-none');
            dutiesAmountEl.textContent = `$0.00`;
                 FINAL_TOTAL=FINAL_TOTAL-US_DUTIES;
                document.getElementById("grand-total").textContent = `$${FINAL_TOTAL}`;
            US_DUTIES = 0;
        }

        // Recalculate grand total
        let grandTotal = subtotal + tax + delivery + duties - discount;
        grandTotalEl.textContent = `$${grandTotal.toFixed(2)}`;
        updateTotals();
    }

    google.maps.event.addDomListener(window, 'load', initAutocomplete);
</script>

<script>

function showStripeSections() {
    $('.card-button').show();
    $('#placeOrderBtn').show();
    $('#paypal-processing').hide();

    @if($user)
    $('#saved-card-section').show();
    $('.save-card-btn').addClass('active');
    @else
    $('#new-card-section').show();
    $('.add-card-btn').addClass('active');
    @endif
}

function showPayPalSections() {
    $('.card-info-fields').hide();
    $('.card-button').hide();
    $('#placeOrderBtn').hide();
}

// Gather form data
function gatherFormData() {
    return {
        users_meta_data: {
            name: $('input[name="name"]').val()?.trim() || '',
            last_name: $('input[name="last_name"]').val()?.trim() || '',
            phone: $('input[name="phone"]').val()?.trim() || '',
            email: $('input[name="email"]').val()?.trim() || '',
        },
      delivery_meta_data: {
    address: $('#autocomplete').val()?.trim() || '',
    formatted_address: $('input[name="formatted_address"]').val()?.trim() || '',
    street: $('input[name="street"]').val()?.trim() || '',
    area: $('input[name="area"]').val()?.trim() || '',
    sub_area: $('input[name="sub_area"]').val()?.trim() || '',
    city: $('input[name="city"]').val()?.trim() || '',
    state_province: $('input[name="state"]').val()?.trim() || '',
    province_code: $('input[name="province_code"]').val()?.trim() || '',
    country: $('input[name="country"]').val()?.trim() || '',
    country_iso: $('input[name="country_iso"]').val()?.trim() || '',
    postcode: $('input[name="postcode"]').val()?.trim() || '',
    latitude: $('input[name="latitude"]').val()?.trim() || '',
    longitude: $('input[name="longitude"]').val()?.trim() || '',
    place_id: $('input[name="place_id"]').val()?.trim() || ''
}

    };
}
</script>
<script>
  let appliedGiftCardCode = null; // track which code is applied

document.querySelector(".apply-btn").addEventListener("click", function () {
    const code = document.querySelector("input[name='gift_card_code']").value.trim();
    if (!code) {
        Toast.fire({ icon: 'error', title: 'Please enter a gift card code' });
        return;
    }

    // 🚨 Prevent reapplying same code without removing
     if (window.appliedGiftCardCode === code && window.appliedGiftCardAmount > 0) {
            Toast.fire({ icon: 'info', title: `Gift card already applied ($${window.appliedGiftCardAmount.toFixed(2)})` });
            return;
        }

    const checkGiftCardUrl = "{{ route('giftcards.check') }}";
    fetch(`${checkGiftCardUrl}?code=${code}`)
        .then(res => res.json())
        .then(data => {
            if (data.valid) {
                appliedGiftCardMax = data.remaining_amount;

              Swal.fire({
    title: "Gift Card Found",
    html: `
        <p><strong>Total Value:</strong> $${data.total_amount}</p>
        <p><strong>Used:</strong> $${(data.total_amount - data.remaining_amount).toFixed(2)}</p>
        <p><strong>Available Balance:</strong> $${data.remaining_amount}</p>
        <input id="giftCardUsage" type="number" class="swal2-input" 
               placeholder="Enter amount to use" 
               min="1" max="${data.remaining_amount}">
    `,
    confirmButtonText: "Apply",
    showCancelButton: true,
    preConfirm: () => {
        const val = parseFloat(document.getElementById("giftCardUsage").value);
        if (isNaN(val) || val <= 0) {
            Swal.showValidationMessage("Amount must be greater than 0");
            return false;
        }
        if (val > data.remaining_amount) {
            Swal.showValidationMessage(`You can use up to $${data.remaining_amount}`);
            return false;
        }
        return val;
    }
}).then(result => {
                    if (result.isConfirmed) {
                        const grandTotalEl = document.getElementById('grand-total');
                        const currentTotal = parseFloat(
                            (grandTotalEl?.textContent || grandTotalEl?.innerText || '0').replace(/[^0-9.-]+/g, "")
                        ) || 0;

                         window.appliedGiftCardAmount = Math.min(result.value, appliedGiftCardMax, currentTotal);
                            window.appliedGiftCardCode = code;
 window.APPLIED_GIFT_CARD_META = [{
                                code: code,
                                applied: window.appliedGiftCardAmount,
                                total: data.total_amount,
                                remaining: data.remaining_amount
                            }];
                        document.getElementById("applied-gift-card-row").classList.remove("d-none");
                        document.getElementById("applied-gift-card-amount").textContent = `-$${appliedGiftCardAmount.toFixed(2)}`;

                        updateTotals(
                            parseInt(document.getElementById("points-box")?.dataset.value || 0),
                            parseInt(document.getElementById("shipping-box")?.dataset.value || 0)
                        );

                        Toast.fire({
                            icon: 'success',
                            title: `Gift Card Applied: $${appliedGiftCardAmount.toFixed(2)}`
                        });
                    }
                });
            } else {
                Toast.fire({ icon: 'error', title: 'Invalid or expired gift card code' });
            }
        });
});

document.addEventListener("click", function(e) {
    if (e.target.closest("#remove-gift-card")) {
        appliedGiftCardAmount = 0;
        appliedGiftCardMax = 0;
         window.appliedGiftCardAmount = 0;
            window.appliedGiftCardCode = '';
            window.APPLIED_GIFT_CARD_META = [];
        document.getElementById("applied-gift-card-row").classList.add("d-none");
        updateTotals(
            parseInt(document.getElementById("points-box")?.dataset.value || 0),
            parseInt(document.getElementById("shipping-box")?.dataset.value || 0)
        );
        Toast.fire({ icon: 'info', title: 'Gift Card Removed' });
    }
});

</script>
    </x-slot>
</x-layouts.user-default>
