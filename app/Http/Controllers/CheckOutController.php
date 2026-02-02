<?php

namespace App\Http\Controllers;

use App\Mail\GiftCardMail;
use App\Models\Bundle;
use App\Models\BundleProduct;
use App\Models\Card;
use App\Models\Cart;
use App\Models\GiftCardCodes;
use App\Models\GiftCardHistory;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Stripe\StripeClient;
use Illuminate\Support\Str;


class CheckOutController extends Controller
{

    protected $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(config('services.stripe.secret') ?? env('STRIPE_SECRET'));
    }
    public function checkoutPage()
    {
        $userId    = Auth::check() ? Auth::id() : null;
        $sessionId = session()->get('cart_session_id');
        $query = Cart::query();

        $user = null;
        if ($userId) {
            $user = User::find($userId);
            $query->where('user_id', $userId);
        } else {
            $query->where('session_id', $sessionId);
        }

        // Fetch products
        $products = (clone $query)
            ->where('type', 'product')
            ->with(['product', 'variation'])
            ->get();

        // Fetch bundles
        $bundles = (clone $query)
            ->where('type', 'bundle')
            ->with(['bundle.bundleProducts.product', 'bundle.bundleProducts.variation'])
            ->get();

        $subTotal = 0;

        $metadata = [
            'Products' => [],
            'Bundle'   => [],
            'GiftCards'  => [],
            'BangleBox'  => [],
        ];

        // Helper: calculate correct price
        $getPrice = function ($product, $variation, $isLoggedIn) {
            if ($variation) {
                if ($isLoggedIn) {
                    return $variation->member_price
                        ?? $variation->compare_price
                        ?? $variation->price;
                } else {
                    return $variation->compare_price
                        ?? $variation->price;
                }
            } else {
                if ($isLoggedIn) {
                    return $product->member_price
                        ?? $product->compare_price
                        ?? $product->price;
                } else {
                    return $product->compare_price
                        ?? $product->price;
                }
            }
        };

        // Process products
        foreach ($products as $cartItem) {
            $product = $cartItem->product;
            $variation = $cartItem->variation;

            $price = $getPrice($product, $variation, $userId ? true : false);
            $lineTotal = $price * $cartItem->qty;
            $subTotal += $lineTotal;

            $metadata['Products'][] = [
                'cart_id'     => $cartItem->id,
                'qty'         => $cartItem->qty,
                'final_price' => $price,
                'line_total'  => $lineTotal,
                'product'     => $product,
                'variation'   => $variation,
            ];
        }

        // Process bundles
        foreach ($bundles as $cartItem) {
            $bundle = $cartItem->bundle;

            $bundleProducts = [];
            $bundlePriceTotal = 0;

            foreach ($bundle->bundleProducts as $bp) {
                $bpPrice = $getPrice($bp->product, $bp->variation, $userId ? true : false);
                $bundleProducts[] = [
                    'product'   => $bp->product,
                    'variation' => $bp->variation,
                    'qty'       => $bp->qty ?? 1,
                    'price'     => $bpPrice,
                ];
                $bundlePriceTotal += $bpPrice * ($bp->qty ?? 1);
            }

            $lineTotal = $bundlePriceTotal * $cartItem->qty;
            $subTotal += $lineTotal;

            $metadata['Bundle'][] = [
                'cart_id'     => $cartItem->id,
                'qty'         => $cartItem->qty,
                'final_price' => $bundlePriceTotal,
                'line_total'  => $lineTotal,
                'bundle'      => [
                    'id'        => $bundle->id,
                    'user_id'   => $bundle->user_id,
                    'session_id' => $bundle->session_id,
                    'products'  => $bundleProducts,
                ],
            ];
        }
        $giftCards = (clone $query)
            ->where('type', 'gift-card')
            ->get();

        $giftCardsTotal = 0;

        foreach ($giftCards as $cartItem) {
            // ✅ Lookup price from config using stored type_id
            $price = config('services.gift_cards')[$cartItem->type_id] ?? 0;

            $lineTotal = $price * $cartItem->qty;
            $giftCardsTotal += $lineTotal;

            $metadata['GiftCards'][] = [
                'cart_id'     => $cartItem->id,
                'qty'         => $cartItem->qty,
                'final_price' => $price,
                'line_total'  => $lineTotal,
                'email'       => $cartItem->recipient_email, // updated key name
            ];
        }
        $bangleBoxes = (clone $query)
            ->where('type', 'bangle_box')
            ->with(['bangleBox', 'bangleSize', 'bangleCartColors.color'])
            ->get();
        foreach ($bangleBoxes as $cartItem) {
            $bangleBox = $cartItem->bangleBox;

            $price = $bangleBox->price ?? 0;
            $lineTotal = $price * $cartItem->qty;
            $subTotal += $lineTotal;

            $metadata['BangleBox'][] = [
                'cart_id'     => $cartItem->id,
                'qty'         => $cartItem->qty,
                'final_price' => $price,
                'line_total'  => $lineTotal,
                'bangle_box'  => $bangleBox,
                'bangle_size' => $cartItem->bangleSize,
                'colors'      => $cartItem->bangleCartColors,
            ];
        }
        // Totals
        $tax      = $subTotal * 0.05;
        $delivery = 5.00;
        // dd('total',$total,'subTotal',$subTotal,'tax',$tax,'delivery',$delivery 
        // );
        $isGiftOnly = (
    $subTotal == 0 &&
    empty($metadata['Products']) &&
    empty($metadata['Bundle']) &&
    empty($metadata['BangleBox']) &&
    !empty($metadata['GiftCards'])
);

$isProductOnly = (
    (!empty($metadata['Products']) || !empty($metadata['Bundle']) || !empty($metadata['BangleBox'])) &&
    empty($metadata['GiftCards'])
);

$isMixed = (
    (!empty($metadata['Products']) || !empty($metadata['Bundle']) || !empty($metadata['BangleBox'])) &&
    !empty($metadata['GiftCards'])
);
        // $isGiftOnly = ($subTotal == 0 && empty($metadata['Products']) && empty($metadata['Bundle']) && !empty($metadata['GiftCards']));
        // $isProductOnly = (!empty($metadata['Products']) || !empty($metadata['Bundle'])) && empty($metadata['GiftCards']);
        // $isMixed = (!empty($metadata['Products']) || !empty($metadata['Bundle'])) && !empty($metadata['GiftCards']);
        if ($isGiftOnly) {
            $type = 'gift_card';
        } elseif ($isProductOnly) {
            $type = 'product';
        } elseif ($isMixed) {
            $type = 'both';
        } else {
            $type = 'empty';
        }
        // dd($metadata['BangleBox']);
        return view('pages.check-out', [
            'subTotal'          => $subTotal,
            'tax'               => $tax,
            'delivery'          => $delivery,
            'total'             => $subTotal,
            'user'              => $user,
            'giftCardsTotal'    => $giftCardsTotal,
            'product_meta_data' => $metadata,
            'gift_card_mata_data'    => $metadata['GiftCards'],
            'bangle_box_meta_data'  => $metadata['BangleBox'],
            'type'        =>  $type
        ]);
    }



    public function createPaymentIntent(Request $request)
    {
        // dd($request->all());
        $productsMeta   = is_string($request->products_meta_data) ? json_decode($request->products_meta_data, true) : $request->products_meta_data;
        $usersMeta      = is_string($request->users_meta_data) ? json_decode($request->users_meta_data, true) : $request->users_meta_data;
        $deliveryMeta   = is_string($request->delivery_meta_data) ? json_decode($request->delivery_meta_data, true) : $request->delivery_meta_data;
        $applied_gift_card_meta_data = is_string($request->applied_gift_card_meta_data) ? json_decode($request->applied_gift_card_meta_data, true) : $request->applied_gift_card_meta_data;
        $bangle_box_meta_data   = is_string($request->bangle_box_meta_data) ? json_decode($request->bangle_box_meta_data, true) : $request->bangle_box_meta_data;
        $request->merge([
            'products_meta_data' => $productsMeta ?? [],
            'users_meta_data'    => $usersMeta ?? [],
            'delivery_meta_data' => $deliveryMeta ?? [],
            'applied_gift_card_meta_data' => $applied_gift_card_meta_data ?? [],
        ]);
        if ($request->type == 'gift_card') {
            // gift card branch - no validation
        } else {
            try {
                $request->validate([
                    'amount'             => 'required|numeric|min:0',
                    'currency'           => 'nullable|string',
                    'use_saved_card_id'  => 'nullable|integer',
                    'save_card'          => 'nullable|boolean',
                    'billing'            => 'nullable|array',
                    'products_meta_data' => 'required|array|min:1',
                    'tax'                => 'nullable|numeric',
                    'shipping_fee'       => 'nullable|numeric',
                    'email'              => 'required|email',

                    // User info required
                    'users_meta_data'                 => 'required|array',
                    'users_meta_data.name'            => 'required|string|max:255',
                    'users_meta_data.last_name'       => 'required|string|max:255',
                    'users_meta_data.phone'           => 'required|string|max:20',

                    'delivery_meta_data'              => 'required|array',

                    'delivery_meta_data.address'      => 'required|string',
                    'delivery_meta_data.country'      => 'required|string',
                    'delivery_meta_data.country_iso'  => 'required|string',
                    'delivery_meta_data.state_province' => 'required|string',
                    'delivery_meta_data.city'         => 'required|string',
                    'delivery_meta_data.street'       => 'required|string',
                    'delivery_meta_data.postcode'     => 'nullable|string',

                    'delivery_meta_data.latitude'     => 'required|numeric',
                    'delivery_meta_data.longitude'    => 'required|numeric',
                ], [
                    // 🔹 Custom messages
                    'amount.required'             => 'Please enter the amount.',
                    'amount.numeric'              => 'Amount must be a number.',
                    'amount.min'                  => 'Amount must be at least 0.5.',

                    'email.required'              => 'Please enter your email address.',
                    'email.email'                 => 'Please enter a valid email address.',

                    'products_meta_data.required' => 'Please add products before placing order.',
                    'products_meta_data.array'    => 'Products data is not valid.',
                    'products_meta_data.min'      => 'At least one product is required.',

                    'currency.string'             => 'Currency must be a valid string.',
                    'use_saved_card_id.integer'   => 'Invalid saved card selected.',
                    'save_card.boolean'           => 'Invalid save card option.',
                    'billing.array'               => 'Billing data must be an array.',
                    'tax.numeric'                 => 'Tax must be a valid number.',
                    'shipping_fee.numeric'        => 'Shipping fee must be a valid number.',
                ]);
            } catch (ValidationException $e) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Please Fill the form correctly.',
                    'errors'  => $e->errors(), // 🔹 Sends proper field-specific errors
                ], 422);
            }
        }

        $gift_meta_data = is_string($request->gift_card_meta_data) ? json_decode($request->gift_card_meta_data, true) : $request->gift_card_meta_data;
        $user = Auth::user();
        $amount = round($request->input('amount') * 100); // cents
        $currency = $request->input('currency', 'usd');
        $sessionId = $user ? null : session()->getId(); // for guest users
        $gift_cards_total = $request->input('giftCardsTotal', 0);
        // $amount = $amount + ($gift_cards_total * 100);

        if ($amount <= 0) {

            if ($request->type == 'gift_card') {
                $giftcard = $this->giftCardOrder($gift_meta_data);
            } else if ($request->type == 'product') {
                $order = $this->StoreOrder([
                    'user_id' => $user ? $user->id : null,
                    'session_id' => $sessionId,
                    'products_meta_data' => json_encode($request->input('products_meta_data')),
                    'delivery_meta_data' => json_encode($request->input('delivery_meta_data')),
                    'applied_gift_card_meta_data' => json_encode($request->input('applied_gift_card_meta_data')),
                    'bangle_box_meta_data' => json_encode($request->input('bangle_box_meta_data')),
                    'total_amount' => 0,
                    'tax' => $request->input('tax'),
                    'shipping_fee' => $request->input('shipping_fee'),
                    'us_import_duties' => $request->input('us_import_duties', 0),
                    'status' => 'pending',
                    'email' => $request->input('email'),
                    'payment_status' => 'paid',
                    'user_meta_data' => json_encode($request->input('users_meta_data')),
                    'applied_points' => $request->input('applied_points', 0),
                    'applied_shipping' => $request->input('applied_shipping', false),
                    'rewards_discount' => $request->input('rewards_discount', 0),
                    'sub_total' => $request->input('subtotal', 0),
                ]);
            } else if ($request->type == 'both') {
                $giftcard = $this->giftCardOrder($gift_meta_data);
                $order = $this->StoreOrder([
                    'user_id' => $user ? $user->id : null,
                    'session_id' => $sessionId,
                    'products_meta_data' => json_encode($request->input('products_meta_data')),
                    'delivery_meta_data' => json_encode($request->input('delivery_meta_data')),
                    'applied_gift_card_meta_data' => json_encode($request->input('applied_gift_card_meta_data')),
                    'bangle_box_meta_data' => json_encode($request->input('bangle_box_meta_data')),
                    'total_amount' => 0,
                    'tax' => $request->input('tax'),
                    'shipping_fee' => $request->input('shipping_fee'),
                    'us_import_duties' => $request->input('us_import_duties', 0),
                    'status' => 'pending',
                    'email' => $request->input('email'),
                    'payment_status' => 'paid',
                    'user_meta_data' => json_encode($request->input('users_meta_data')),
                    'applied_points' => $request->input('applied_points', 0),
                    'applied_shipping' => $request->input('applied_shipping', false),
                    'rewards_discount' => $request->input('rewards_discount', 0),
                    'sub_total' => $request->input('subtotal', 0),
                ]);
            }
            if ($request->appliedGiftCardAmount > 0 && !empty($request->appliedGiftCardCode)) {
                $this->applyGiftCardToOrder(
                    $request->appliedGiftCardCode,
                    $request->appliedGiftCardAmount,
                );
            }
            return response()->json([
                'status'  => 'ok',
                'message' => 'Order placed successfully (no payment needed).',
                'amount' => 0,
                'is_free' => true,
                'order_id' => $order->order_id,
                'date' => $order->created_at->toDateString(),
            ]);
        }

        // If user selected a saved card (server will attempt off-session)
        if ($request->filled('use_saved_card_id') && $user) {
            $card = Card::where('id', $request->use_saved_card_id)
                ->where('user_id', $user->id)
                ->first();

            if (!$card || ! $card->stripe_pm_id) {
                return response()->json(['status' => 'error', 'message' => 'Saved card not found.'], 422);
            }

            // Ensure user has stripe_customer_id
            if (!$user->stripe_customer_id) {
                // create Stripe customer
                $customer = $this->stripe->customers->create([
                    'email' => $user->email,
                    'name'  => $user->name,
                ]);
                $user->update(['stripe_customer_id' => $customer->id]);
            }

            try {
                // Create & confirm PaymentIntent off-session using saved PM
                $paymentIntent = $this->stripe->paymentIntents->create([
                    'amount' => $amount,
                    'currency' => $currency,
                    'customer' => $user->stripe_customer_id,
                    'payment_method' => $card->stripe_pm_id,
                    'off_session' => true,
                    'confirm' => true,
                    'metadata' => [
                        'user_id' => $user->id,
                    ],
                ]);

                // Store order with delivery_meta_data and session_id

                if ($request->type == 'gift_card') {
                    $giftcard = $this->giftCardOrder(
                        $gift_meta_data
                    );
                } else if ($request->type == 'product') {
                    $order = $this->StoreOrder([
                        'user_id' => $user->id,
                        'session_id' => null,
                        'products_meta_data' => json_encode($request->input('products_meta_data')),
                        'delivery_meta_data' => json_encode($request->input('delivery_meta_data')), // added
                        'applied_gift_card_meta_data' => json_encode($request->input('applied_gift_card_meta_data')),
                        'bangle_box_meta_data' => json_encode($request->input('bangle_box_meta_data')),

                        'total_amount' => $request->input('amount'),
                        'tax' => $request->input('tax'),
                        'shipping_fee' => $request->input('shipping_fee'),
                        'us_import_duties' => $request->input('us_import_duties', 0),
                        'status' => 'pending',
                        'email' => $request->input('email'),
                        'payment_status' => 'paid',
                        'user_meta_data' => json_encode($request->input('users_meta_data')),
                        'applied_points' => $request->input('applied_points', 0),
                        'applied_shipping' => $request->input('applied_shipping', false),
                        'rewards_discount' => $request->input('rewards_discount', 0),
                        'sub_total' => $request->input('subtotal', 0),


                    ]);
                } else if ($request->type == 'both') {
                    $giftcard = $this->giftCardOrder(
                        $gift_meta_data
                    );
                    $order = $this->StoreOrder([
                        'user_id' => $user->id,
                        'session_id' => null,
                        'products_meta_data' => json_encode($request->input('products_meta_data')),
                        'delivery_meta_data' => json_encode($request->input('delivery_meta_data')), // added
                        'applied_gift_card_meta_data' => json_encode($request->input('applied_gift_card_meta_data')),
                        'bangle_box_meta_data' => json_encode($request->input('bangle_box_meta_data')),

                        'total_amount' => $request->input('amount'),
                        'tax' => $request->input('tax'),
                        'shipping_fee' => $request->input('shipping_fee'),
                        'us_import_duties' => $request->input('us_import_duties', 0),
                        'status' => 'pending',
                        'email' => $request->input('email'),
                        'payment_status' => 'paid',
                        'user_meta_data' => json_encode($request->input('users_meta_data')),
                        'applied_points' => $request->input('applied_points', 0),
                        'applied_shipping' => $request->input('applied_shipping', false),
                        'rewards_discount' => $request->input('rewards_discount', 0),
                        'sub_total' => $request->input('subtotal', 0),


                    ]);
                }

                if ($request->appliedGiftCardAmount > 0 && !empty($request->appliedGiftCardCode)) {
                    $this->applyGiftCardToOrder(
                        $request->appliedGiftCardCode,
                        $request->appliedGiftCardAmount,
                    );
                }

                return response()->json([
                    'status' => 'ok',
                    'message' => 'Payment successful',
                    'payment_intent' => $paymentIntent,
                    'order_id' => $order->order_id,
                    'date' => $order->created_at->toDateString(),
                ]);
            } catch (\Stripe\Exception\CardException $e) {
                return response()->json([
                    'status' => 'requires_action',
                    'message' => $e->getMessage(),
                    'error' => $e->getStripeError(),
                ], 402);
            } catch (\Exception $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
            }
        }

        try {
            $paymentIntent = $this->stripe->paymentIntents->create([
                'amount' => $amount,
                'currency' => $currency,
                'metadata' => [
                    'user_id' => $user ? $user->id : null,
                ],
            ]);

            // Store order for guest or new card
            if ($request->type == 'gift_card') {
                $giftcard = $this->giftCardOrder(
                    $gift_meta_data
                );
            } else if ($request->type == 'product') {
                $order = $this->StoreOrder([
                    'user_id' => $user ? $user->id : null,
                    'session_id' => $sessionId,
                    'products_meta_data' => json_encode($request->input('products_meta_data')),
                    'delivery_meta_data' => json_encode($request->input('delivery_meta_data')), // added
                    'applied_gift_card_meta_data' => json_encode($request->input('applied_gift_card_meta_data')),
                    'bangle_box_meta_data' => json_encode($request->input('bangle_box_meta_data')),

                    'total_amount' => $request->input('amount'),
                    'tax' => $request->input('tax'),
                    'shipping_fee' => $request->input('shipping_fee'),
                    'us_import_duties' => $request->input('us_import_duties', 0),
                    'status' => 'pending',
                    'email' => $request->input('email'),
                    'payment_status' => 'paid',
                    'user_meta_data' => json_encode($request->input('users_meta_data')),
                    'applied_points' => $request->input('applied_points', 0),
                    'applied_shipping' => $request->input('applied_shipping', false),
                    'rewards_discount' => $request->input('rewards_discount', 0),
                    'sub_total' => $request->input('subtotal', 0),


                ]);
            } else if ($request->type == 'both') {
                $giftcard = $this->giftCardOrder(
                    $gift_meta_data
                );
                $order = $this->StoreOrder([
                    'user_id' => $user ? $user->id : null,
                    'session_id' => $sessionId,
                    'products_meta_data' => json_encode($request->input('products_meta_data')),
                    'delivery_meta_data' => json_encode($request->input('delivery_meta_data')), // added
                    'applied_gift_card_meta_data' => json_encode($request->input('applied_gift_card_meta_data')),
                    'bangle_box_meta_data' => json_encode($request->input('bangle_box_meta_data')),

                    'total_amount' => $request->input('amount'),
                    'tax' => $request->input('tax'),
                    'shipping_fee' => $request->input('shipping_fee'),
                    'us_import_duties' => $request->input('us_import_duties', 0),
                    'status' => 'pending',
                    'email' => $request->input('email'),
                    'payment_status' => 'paid',
                    'user_meta_data' => json_encode($request->input('users_meta_data')),
                    'applied_points' => $request->input('applied_points', 0),
                    'applied_shipping' => $request->input('applied_shipping', false),
                    'rewards_discount' => $request->input('rewards_discount', 0),
                    'sub_total' => $request->input('subtotal', 0),


                ]);
            }
            if ($request->appliedGiftCardAmount > 0 && !empty($request->appliedGiftCardCode)) {
                $this->applyGiftCardToOrder(
                    $request->appliedGiftCardCode,
                    $request->appliedGiftCardAmount,
                );
            }
            return response()->json(['message' => 'Order placed successfully','status' => 'ok', 'client_secret' => $paymentIntent->client_secret,'order_id' => $order->order_id,
                    'date' => $order->created_at->toDateString(),]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    private function StoreOrder($orderData)
    {
        $order = Order::create($orderData);
        $productsMeta = json_decode($orderData['products_meta_data'], true);
        $bangle_box_meta_data = json_decode($orderData['bangle_box_meta_data'], true);
        // dd($bangle_box_meta_data);
        if (!empty($productsMeta['Products'])) {
            foreach ($productsMeta['Products'] as $item) {
                $product   = $item['product'] ?? null;
                $variation = $item['variation'] ?? null;
                $qty       = (int) $item['qty'];

                if ($variation && isset($variation['id'])) {
                    // Decrease variation stock safely
                    ProductVariation::where('id', $variation['id'])
                        ->where('quantity', '>', 0)
                        ->decrement('quantity', $qty);
                } elseif ($product && isset($product['id'])) {
                    // Decrease product stock safely
                    Product::where('id', $product['id'])
                        ->where('quantity', '>', 0)
                        ->decrement('quantity', $qty);
                }

                // Remove from cart
                if (isset($item['cart_id'])) {
                    Cart::where('id', $item['cart_id'])->delete();
                }
            }
        }

        // Handle bundles
        if (!empty($productsMeta['Bundle'])) {
            foreach ($productsMeta['Bundle'] as $bundleItem) {
                $bundle    = $bundleItem['bundle'] ?? null;
                $bundleQty = (int) $bundleItem['qty'];

                if ($bundle) {
                    foreach ($bundle['products'] as $bProduct) {
                        $product   = $bProduct['product'] ?? null;
                        $variation = $bProduct['variation'] ?? null;
                        $qty       = (int) $bProduct['qty'] * $bundleQty;

                        if ($variation && isset($variation['id'])) {
                            ProductVariation::where('id', $variation['id'])
                                ->where('quantity', '>', 0)
                                ->decrement('quantity', $qty);
                        } elseif ($product && isset($product['id'])) {
                            Product::where('id', $product['id'])
                                ->where('quantity', '>', 0)
                                ->decrement('quantity', $qty);
                        }
                    }

                    // Delete bundle cart item
                    if (isset($bundleItem['cart_id'])) {
                        Cart::where('id', $bundleItem['cart_id'])->delete();
                    }

                    // Delete Bundle + its products
                    BundleProduct::where('bundle_id', $bundle['id'])->delete();
                    Bundle::where('id', $bundle['id'])->delete();
                }
            }
        }
        $user = Auth::user();

        if ($user) {
            // Applied points (raw integer points, not dollars)
            if (!empty($orderData['applied_points']) && $orderData['applied_points'] > 0) {
                $pointsToUse = (int) $orderData['applied_points'];
                $user->decrement('total_points', $pointsToUse);
            }

            // Applied free shipping
            if (!empty($orderData['applied_shipping'])) {
                if ($user->total_shippings > 0) {
                    $user->decrement('total_shippings', 1);
                }
            }
        } else {
            $UserData = json_decode($orderData['user_meta_data'], true);
            $email    = $orderData['email'];

            $existingUser = User::where('email', $email)->first();

            if ($existingUser) {
                if ($existingUser->is_guest) {
                    $existingUser->update([
                        'name'      => $UserData['name'] ?? $existingUser->name,
                        'last_name' => $UserData['last_name'] ?? $existingUser->last_name,
                    ]);
                }

                $user = $existingUser;
            } else {
                // First create user (id is generated here)
                $user = User::create([
                    'name'     => $UserData['name'] ?? 'Guest',
                    'last_name' => $UserData['last_name'] ?? null,
                    'email'    => $email,
                    'password' => Hash::make(Str::random(12)),
                    'is_guest' => true,
                ]);

                // Then update customer_id to use the user id
                $user->update([
                    'customer_id' => 'CUST-' . str_pad($user->id, 3, '0', STR_PAD_LEFT),
                ]);
            }
        }

        Order::where('id', $order->id)->update([
            'user_id' => $user->id,
            'email' => $user->email,

        ]);
 if (!empty($bangle_box_meta_data)) {
    if (is_string($bangle_box_meta_data)) {
        $bangle_box_meta_data = json_decode($bangle_box_meta_data, true);
    }

    $cartIds = collect($bangle_box_meta_data)
        ->pluck('cart_id')
        ->filter()
        ->toArray();

    if (!empty($cartIds)) {
        Cart::whereIn('id', $cartIds)->delete();
    }
}

        // dd('jhjhj');
        return $order;
    }




    private function giftCardOrder($giftOrderData)
    {
        $created = [];

        if (!empty($giftOrderData) && is_array($giftOrderData)) {
            foreach ($giftOrderData as $giftCard) {
                $qty = $giftCard['qty'] ?? 1;

                // Generate one order_id per giftCard batch
                $orderId = 'ORDCD-' . strtoupper(Str::random(6));

                $batchCodes = [];

                for ($i = 0; $i < $qty; $i++) {
                    $card = GiftCardCodes::create([
                        'recipient_email' => $giftCard['email'] ?? null,
                        'amount'          => $giftCard['final_price'] ?? 0,
                        'status'          => 'active',
                        'code'            => strtoupper(Str::random(8)),
                        'order_id'        => $orderId,
                    ]);

                    $created[]   = $card;
                    $batchCodes[] = $card; // collect for mail
                }

                // ✅ Send one email for the whole batch
                if (!empty($giftCard['email'])) {
                    Mail::to($giftCard['email'])->send(
                        new GiftCardMail($batchCodes, $orderId)
                    );
                }
                if (!empty($giftCard['cart_id'])) {
                    Cart::where('id', $giftCard['cart_id'])->delete();
                }
            }
        }

        return $created;
    }


    private function applyGiftCardToOrder($appliedGiftCardCode, $appliedGiftCardAmount)
    {
        $giftCard = GiftCardCodes::where('code', $appliedGiftCardCode)->first();

        if (!$giftCard) {
            return false;
        }

        GiftCardHistory::create([
            'gift_card_id' => $giftCard->id,
            'used_amount'  => $appliedGiftCardAmount,
        ]);
        $totalUsed = $giftCard->histories()->sum('used_amount');

        if ($totalUsed >= $giftCard->amount) {
            $giftCard->update(['status' => 'used']);
        }

        return true;
    }
}
