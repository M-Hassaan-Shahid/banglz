<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function get_orders_list(Request $request)
    {
        $query = Order::query();


        // Handle search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('order_id', 'LIKE', "%{$search}%")
                    ->orWhere('status', 'LIKE', "%{$search}%")
                    ->orWhere('total_amount', 'LIKE', "%{$search}%")
                    ->orwhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'LIKE', "%{$search}%")
                            ->orWhere('last_name', 'LIKE', "%{$search}%");
                    });
            });
        }

        $totalRecords = Order::count();
        $filteredQuery = clone $query;
        $totalFiltered = $filteredQuery->count();


        // Handle sorting
        $sortBy = $request->input('sort_by', 'id');
        $sortDir = $request->input('sort_dir', 'desc');
        $query->orderBy($sortBy, $sortDir);

        // Handle pagination
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $orders = $query->skip($start)->take($length)->get();

        $data = [];

        foreach ($orders as $order) {
            $actions = '
        <a href="' . route('admin.orders.show', ['id' => $order->id]) . '" class="btn btn-primary btn-sm">View</a>
     ';

            $statusBadge = match ($order->status) {
                'pending'     => '<span class="badge bg-warning text-dark">Unfulfilled</span>',
                'processing'  => '<span class="badge bg-info text-dark">Processing</span>',
                'on_the_way'  => '<span class="badge bg-primary">On the Way</span>',
                'delivered'   => '<span class="badge bg-success">Delivered</span>',
                'completed'   => '<span class="badge bg-success">Completed</span>',
                'cancelled'   => '<span class="badge bg-danger">Cancelled</span>',
                'returned'    => '<span class="badge bg-dark">Returned</span>',
                'failed'      => '<span class="badge bg-secondary">Failed</span>',
                default       => '<span class="badge bg-light text-dark">Unknown</span>',
            };


            $data[] = [
                'order_id'     => $order->order_id,
                'customer_name' => $order->user ? $order->user->name . ' ' . $order->user->last_name : 'Guest',
                'created_at'   => $order->created_at->format('d M Y H:i'),
                'total_amount' => '$' . number_format($order->total_amount, 2),
                'status'       => $statusBadge,
                'action'       => $actions,
            ];
        }


        return response()->json([
            'draw'            => intval($request->input('draw')),
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data'            => $data
        ]);
    }

   public function createLabel($id)
{
    $order = Order::findOrFail($id);
    $productsMetaData = json_decode($order->products_meta_data, true);
    $deliverMetaData = json_decode($order->delivery_meta_data, true);
     $giftCardMetaData = json_decode($order->applied_gift_card_meta_data, true);
    $userMetaData = json_decode($order->user_meta_data, true);
      $bangletMetaData = json_decode($order->bangle_box_meta_data ?? $order->bangle_meta_data ?? '[]', true);
    if (is_string($bangletMetaData)) {
        $bangletMetaData = json_decode($bangletMetaData, true) ?: [];
    }
    // normalize to array
    $bangletMetaData = is_array($bangletMetaData) ? $bangletMetaData : [];
    // Check if gift card amount is available
    if (!empty($giftCardMetaData) && isset($giftCardMetaData[0]['applied'])) {
        $order->appliedgiftcard = $giftCardMetaData[0]['applied'];
    } else {
        $order->appliedgiftcard = null;
    }
    $userOrdersCount = Order::where('email', $order->email)->count();
    $userMetaData['order_count'] = $userOrdersCount;
    $order->user_meta_data = $userMetaData;
    //  dd($productsMetaData);
    return view('admin.order.create-label', compact('order', 'productsMetaData','deliverMetaData','bangletMetaData'));
}

public function updateAddress(Request $request)
{
    $validated = $request->validate([
        'order_id'       => 'required|integer|exists:orders,id',
        'first_name'     => 'nullable|string',
        'last_name'      => 'nullable|string',
        'phone'          => 'nullable|string',
        'email'          => 'nullable|email',
        'address'        => 'required|string',
        'city'           => 'nullable|string',
        'state'          => 'nullable|string',
        'state_code'     => 'nullable|string',
        'postal_code'    => 'nullable|string',
        'country'        => 'nullable|string',
        'country_iso'    => 'nullable|string',
        'street'         => 'nullable|string',
        'latitude'       => 'nullable|numeric',
        'longitude'      => 'nullable|numeric',
        'place_id'       => 'nullable|string|max:255',
        'area'           => 'nullable|string|max:255',
        'sub_area'       => 'nullable|string|max:255',
        'formatted_address' => 'nullable|string',
    ]);

    $order = \App\Models\Order::find($validated['order_id']);

    if (!$order) {
        return response()->json(['success' => false, 'message' => 'Order not found.'], 404);
    }

    // Build delivery_meta_data (store all useful pieces)
    $deliveryMeta = [
        'address'        => $validated['address'] ?? null,
        'street'         => $validated['street'] ?? null,
        'formatted_address' => $validated['formatted_address'] ?? $validated['address'] ?? null,
        'city'           => $validated['city'] ?? null,
        'state_province' => $validated['state'] ?? null,
        'province_code'  => $validated['state_code'] ?? null,
        'country'        => $validated['country'] ?? null,
        'country_iso'    => strtoupper($validated['country_iso'] ?? ($validated['country'] ? $validated['country'] : '')),
        'postal_code'    => $validated['postal_code'] ?? null,
        'latitude'       => $validated['latitude'] ?? null,
        'longitude'      => $validated['longitude'] ?? null,
        'place_id'       => $validated['place_id'] ?? null,
        'area'           => $validated['area'] ?? null,
        'sub_area'       => $validated['sub_area'] ?? null,
        'updated_at'     => now()->toDateTimeString(),
    ];
// dd($deliveryMeta);
    // Build user_meta_data for contact name/phone/email
    $userMeta = [
        'name'       => $validated['first_name'] ?? null,
        'last_name'  => $validated['last_name'] ?? null,
        'phone'      => $validated['phone'] ?? $order->phone ?? null,
        'email'      => $validated['email'] ?? $order->email ?? null,
    ];

    // Persist: prefer array assignment if your Order model casts to array/json
    // If your model doesn't cast, you can use json_encode($deliveryMeta)
    try {
        // $order->delivery_meta_data->postcode = $validated['postal_code'] ?? null;
        $order->delivery_meta_data = json_encode($deliveryMeta);
        $order->user_meta_data = json_encode($userMeta);
        $order->save();
    } catch (\Throwable $e) {
        return response()->json(['success' => false, 'message' => 'Failed to save address.', 'error' => $e->getMessage()], 500);
    }

    return response()->json([
        'success' => true,
        'message' => 'Address updated successfully.',
        'data' => [
            'order_id' => $order->id,
            'delivery_meta_data' => $deliveryMeta,
            'user_meta_data' => $userMeta,
        ],
    ]);
}




}
