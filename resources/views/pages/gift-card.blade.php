<x-layouts.user-default>
    <x-slot name="insertstyle">
        <style>
            /* Wrapper */
            .gift-card-wrapper {
                display: flex;
                flex-direction: row;
                gap: 30px;
                margin: 40px auto;
                max-width: 900px;
                align-items: flex-start;
                font-family: 'Poppins', sans-serif;
            }

            /* Left Preview Box */
            .gift-card-display {
                flex: 1;
                background: #e1cfc6;
                border: 2px solid #a87a66;
                border-radius: 12px;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                height: 250px;
                text-align: center;
                padding: 20px;
                color: #333;
                box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            }

            .gift-card-display h6 {
                font-size: 33px;
                color: #a87a66;
                margin-bottom: 10px;
                font-weight: 600;
            }

            .gift-card-display span {
                font-size: 60px;
                font-weight: bold;
                color: #333;
            }

            /* Right Section */
            .gift-card-details {
                flex: 1;
                text-align: left;
            }

            .gift-card-details h2 {
                margin-bottom: 15px;
                font-size: 22px;
                color: #a87a66;
            }

            /* Price Options */
            .price-options {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                margin: 15px 0;
            }

            .price-options button {
                margin: 0;
                padding: 10px 20px;
                border: 1px solid #a87a66;
                background: white;
                cursor: pointer;
                border-radius: 6px;
                font-size: 16px;
                transition: 0.2s;
                color: #333;
            }

            .price-options button.active {
                background: #a87a66;
                color: white;
            }

            /* Quantity Selector */
            .quantity-selector {
                display: inline-flex;
                border: 1px solid #ccc;
                border-radius: 4px;
                overflow: hidden;
                margin: 20px 0;
            }

            .quantity-selector button {
                width: 40px;
                height: 40px;
                border: none;
                background: #f9f9f9;
                cursor: pointer;
                font-size: 18px;
                font-weight: bold;
                color: #333;
            }

            .quantity-selector button:hover {
                background: #e1cfc6;
            }

            .quantity-selector input {
                width: 50px;
                text-align: center;
                border: none;
                font-size: 16px;
                outline: none;
            }

            /* Email Field */
            .recipient-email {
                margin: 20px 0;
            }

            .recipient-email label {
                display: block;
                margin-bottom: 6px;
                font-weight: 500;
                color: #333;
            }

            .recipient-email input {
                width: 100%;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 6px;
                font-size: 16px;
            }

            /* Total Price */
            .total-price {
                font-size: 20px;
                font-weight: bold;
                margin-bottom: 20px;
                color: #333;
            }

            /* Gift Card Add to Cart Button */
            .gift-card-add-btn {
                padding: 14px 20px;
                background: #a87a66;
                color: white;
                border: none;
                cursor: pointer;
                font-size: 16px;
                border-radius: 6px;
                width: 100%;
                transition: background 0.3s;
            }

            .gift-card-add-btn:hover {
                background: #8c6350;
            }
        </style>
    </x-slot>

    <x-slot name="content">
        <div class="product-detail-main-wrapper">
            <div class="gift-card-wrapper">

                <!-- Left: Display Selected Amount -->
                <div class="gift-card-display" id="selected-amount-display">
                    <span>${{ reset($giftCardPrices) }}</span>
                    <h6>Gift Card</h6>
                </div>

                <!-- Right: Gift Card Details -->
                <div class="gift-card-details">
                    <h2>Select Price</h2>
                    <div class="price-options">
                       @foreach($giftCardPrices as $id => $price)
   <button 
    data-id="{{ $id }}" 
    data-value="{{ $price }}" 
    class="{{ $loop->first ? 'active' : '' }}">
    ${{ $price }}
</button>

@endforeach

                    </div>

                    <!-- Quantity Selector -->
                    <div class="quantity-selector">
                        <button id="decrease-qty">-</button>
                        <input type="text" id="quantity" value="1" readonly>
                        <button id="increase-qty">+</button>
                    </div>

                    <!-- Email Input -->
                    <div class="recipient-email">
                        <label for="recipient-email">Recipient Email</label>
                        <input type="email" id="recipient-email" 
                               value="{{ Auth::check() ? Auth::user()->email : '' }}" 
                               placeholder="Enter recipient email">
                    </div>

                    <!-- Total Price -->
                    <div class="total-price" id="total-price">
                        Total: ${{ reset($giftCardPrices) }}
                    </div>

                    <!-- Add to Cart -->
                    @php
                        $giftCardKeys = array_keys($giftCardPrices);
                        $defaultGiftCardKey = reset($giftCardKeys);
                        $defaultGiftCardPrice = reset($giftCardPrices);
                    @endphp

                    <button 
                        class="gift-card-add-btn" 
                        id="gift-card-add-to-cart"
                        data-type="gift-card"
                        data-type-id="{{ $defaultGiftCardKey }}" 
                        data-qty="1"
                    >
                        Add to Cart
                    </button>
                </div>
            </div>
        </div>
    </x-slot>

    <x-slot name="insertjavascript">
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const addBtn = document.getElementById("gift-card-add-to-cart");
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                let selectedAmount = {{ $defaultGiftCardPrice }};
                let quantity = 1;

                const amountDisplay = document.getElementById("selected-amount-display");
                const totalPrice = document.getElementById("total-price");
                const qtyInput = document.getElementById("quantity");

                // Handle price selection
                document.querySelectorAll(".price-options button").forEach(btn => {
                    btn.addEventListener("click", function () {
                        document.querySelectorAll(".price-options button").forEach(b => b.classList.remove("active"));
                        this.classList.add("active");

                 selectedAmount = parseInt(this.dataset.value);
addBtn.dataset.typeId = this.dataset.id;

                        amountDisplay.innerHTML = `<span>$${selectedAmount}</span><h6>Gift Card</h6>`;
                        updateTotal();
                    });
                });

                // Handle quantity
                document.getElementById("increase-qty").addEventListener("click", () => {
                    quantity++;
                    qtyInput.value = quantity;
                    updateTotal();
                });

                document.getElementById("decrease-qty").addEventListener("click", () => {
                    if (quantity > 1) {
                        quantity--;
                        qtyInput.value = quantity;
                        updateTotal();
                    }
                });

                function updateTotal() {
                    totalPrice.textContent = "Total: $" + (selectedAmount * quantity);
                    addBtn.dataset.qty = quantity;
                }

                // Add to Cart AJAX
              addBtn.addEventListener("click", function () {
    const btn = this;
    const type = btn.dataset.type;
    const typeId = btn.dataset.typeId;
    const qty = btn.dataset.qty || 1;
    const recipientEmailInput = document.getElementById("recipient-email");
    const recipientEmail = recipientEmailInput.value.trim();

    // ✅ Validate email (required + format check)
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!recipientEmail || !emailRegex.test(recipientEmail)) {
        // Option 1: Show Toast
        if (typeof Toast !== "undefined") {
            Toast.fire({
                icon: "warning",
                title: "Please enter a valid recipient email."
            });
        }

        // Option 2: Show inline error
        let errorEl = document.getElementById("recipient-email-error");
        if (!errorEl) {
            errorEl = document.createElement("div");
            errorEl.id = "recipient-email-error";
            errorEl.className = "text-danger mt-1";
            recipientEmailInput.insertAdjacentElement("afterend", errorEl);
        }
        errorEl.textContent = "Recipient email is required and must be valid.";

        return; // 🚫 Stop request if invalid
    } else {
        // remove error if fixed
        const errorEl = document.getElementById("recipient-email-error");
        if (errorEl) errorEl.remove();
    }

    btn.disabled = true;
    btn.textContent = "Adding...";

    const formData = new FormData();
    formData.append("type", type);
    formData.append("type_id", typeId);
    formData.append("qty", qty);
    formData.append("recipient_email", recipientEmail);

    fetch("{{ route('cart.add') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": csrfToken,
            "Accept": "application/json"
        },
        body: formData,
        credentials: "same-origin"
    })
    .then(async res => {
        const data = await res.json().catch(() => ({}));
        btn.disabled = false;
        btn.textContent = "Add to Cart";

        if (res.ok) {
            Toast.fire({
                icon: "success",
                title: data.message || "Gift Card added to cart."
            });
            loadCartBadge();
        } else if (res.status === 422) {
            Toast.fire({
                icon: "warning",
                title: data.message || "Invalid request."
            });
        } else {
            Toast.fire({
                icon: "error",
                title: data.message || "Something went wrong."
            });
        }
    })
    .catch(() => {
        btn.disabled = false;
        btn.textContent = "Add to Cart";
        Toast.fire({
            icon: "error",
            title: "Network error. Please try again."
        });
    });
});

            });
        </script>
    </x-slot>
</x-layouts.user-default>
