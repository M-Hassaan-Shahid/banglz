<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\ProductColor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

public function userOrders()
{
    $user = Auth::user();

    if (!$user) {
        return response()->json([
            'status'  => false,
            'message' => 'Unauthorized. Please login.',
            'data'    => null,
        ], 401);
    }

    $orders = Order::where('user_id', $user->id)
        ->latest()
        ->get();

    if ($orders->isEmpty()) {
        return response()->json([
            'status'  => false,
            'message' => 'No orders found for this user.',
            'data'    => [],
        ]);
    }

    $orders = $orders->map(function ($order) {
        $userMeta     = json_decode($order->user_meta_data, true);
        $deliveryMeta = json_decode($order->delivery_meta_data, true);

        $productsMeta = json_decode($order->products_meta_data, true);
        if (is_string($productsMeta)) {
            $productsMeta = json_decode($productsMeta, true);
        }
   $bangleBoxesMeta = json_decode($order->bangle_box_meta_data, true);
        if (is_string($bangleBoxesMeta)) {
            $bangleBoxesMeta = json_decode($bangleBoxesMeta, true);
        }
        $allProducts = [];

        // ✅ Normal products
        if (!empty($productsMeta['Products'])) {
            foreach ($productsMeta['Products'] as $p) {
                $variation = $p['variation'] ?? null;

                // attach color details if variation has color_id
                if ($variation && isset($variation['color_id'])) {
                    $color = ProductColor::find($variation['color_id']);
                    if ($color) {
                        $variation['color'] = [
                            'id'   => $color->id,
                            'name' => $color->name,
                            'code' => $color->code ?? null, // optional hex/color field
                        ];
                    }
                }

                $allProducts[] = [
                    'type'       => 'single',
                    'cart_id'    => $p['cart_id'] ?? null,
                    'qty'        => $p['qty'] ?? 1,
                    'line_total' => $p['line_total'] ?? 0,
                    'price'      => $p['final_price'] ?? $p['price'] ?? null,
                    'product'    => $p['product'] ?? null,
                    'variation'  => $variation,
                ];
            }
        }

        // ✅ Bundle products
        if (!empty($productsMeta['Bundle'])) {
            foreach ($productsMeta['Bundle'] as $bundle) {
                if (!empty($bundle['bundle']['products'])) {
                    foreach ($bundle['bundle']['products'] as $bp) {
                        $variation = $bp['variation'] ?? null;

                        if ($variation && isset($variation['color_id'])) {
                            $color = ProductColor::find($variation['color_id']);
                            if ($color) {
                                $variation['color'] = [
                                    'id'   => $color->id,
                                    'name' => $color->name,
                                    'code' => $color->code ?? null,
                                ];
                            }
                        }

                        $allProducts[] = [
                            'type'       => 'bundle',
                            'bundle_id'  => $bundle['bundle']['id'] ?? null,
                            'qty'        => $bp['qty'] ?? 1,
                            'line_total' => $bp['line_total'] ?? 0,
                            'price'      => $bp['price'] ?? null,
                            'product'    => $bp['product'] ?? null,
                            'variation'  => $variation,
                        ];
                    }
                }
            }
        }
if (!empty($bangleBoxesMeta)) {
            foreach ($bangleBoxesMeta as $b) {
                $colors = [];

                if (!empty($b['colors'])) {
                    foreach ($b['colors'] as $c) {
                        if (isset($c['color'])) {
                            $colors[] = [
                                'id'   => $c['color']['id'] ?? null,
                                'name' => $c['color']['color_name'] ?? null,
                                'image' => $c['color']['image'] ?? null,
                            ];
                        }
                    }
                }

                $allProducts[] = [
                    'type'        => 'bangle_box',
                    'cart_id'     => $b['cart_id'] ?? null,
                    'qty'         => $b['qty'] ?? 1,
                    'line_total'  => $b['line_total'] ?? 0,
                    'price'       => $b['final_price'] ?? null,
                    'bangle_box'  => $b['bangle_box'] ?? null,
                    'bangle_size' => $b['bangle_size'] ?? null,
                    'colors'      => $colors,
                ];
            }
        }
        return [
            'id'                 => $order->id,
            'total_amount'       => $order->total_amount,
            'status'             => $order->status,
            'payment_status'     => $order->payment_status,
            'user_meta_data'     => $userMeta,
            'delivery_meta_data' => $deliveryMeta,
            'created_at'         => $order->created_at,
            'products'           => $allProducts,
        ];
    });

    return response()->json([
        'status'  => true,
        'message' => 'Orders fetched successfully.',
        'data'    => $orders,
    ]);
}


// CartController.php
public function getCartCount()
{
    $userId    = Auth::check() ? Auth::id() : null;
    $sessionId = session()->get('cart_session_id');

    $query = Cart::query();

    if ($userId) {
        $query->where('user_id', $userId);
    } elseif ($sessionId) {
        $query->where('session_id', $sessionId);
    } else {
        return response()->json(['count' => 0]);
    }

    $count = $query->count();

    return response()->json(['count' => $count]);
}

public function confirmation($trancationId, $date)
{
    session()->put('transactionId', $trancationId);
    session()->put('date', $date);
   return view('pages.conformation', [
        'transactionId' => session('transactionId'),
        'date'          => session('date'),
        'message' => 'Order placed successfully',
    ]);
}

}
