<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function get_customers_list(Request $request)
    {
        $query = User::where('type', '!=', 'admin');

        // Handle search
        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('customer_id', 'LIKE', "%{$search}%");
            });
        }

        $totalRecords = User::where('type', '!=', 'admin')->count();
        $totalFiltered = $query->count();


        // Handle sorting
        $sortBy = request('sort_by', 'id');
        $sortDir = request('sort_dir', 'desc');
        $query->orderBy($sortBy, $sortDir);

        // Handle pagination
        $start = request('start', 0);
        $length = request('length', 10);
        $customers = $query->skip($start)->take($length)->get();

        $data = [];

        foreach ($customers as $customer) {

            $actions = '
          <a href="' . route('admin.customer.details', ['id' => $customer->id]) . '">
                <button type="button" class="btn btn-primary">View</button>
            </a> <a href="' . route('admin.customer.orders', ['id' => $customer->id]) . '">
             <button type="button" class="btn btn-info">Orders</button>
            </a>
        ';

            $data[] = [
                'customer_id' => $customer->customer_id ?? '—', // fallback if null
                'name'        => $customer->name,
                'last_name'   => $customer->last_name,
                'email'       => $customer->email,
                'is_guest'    => $customer->is_guest
                    ? '<span class="badge bg-warning">Guest</span>'
                    : '<span class="badge bg-success">Registered</span>',
                'action'      => $actions,
            ];
        }

        return response()->json([
            'draw'            => intval(request('draw')),
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data'            => $data
        ]);
    }

public function details($id)
{
    $customer = User::withCount('orders')->find($id);
    return view('admin.customer.customer_details', compact('customer'));
}

public function get_customer_orders_list(Request $request, $customerId)
{
    $query = Order::where('user_id', $customerId);

    // Handle search
    if ($search = $request->input('search')) {
        $query->where(function ($q) use ($search) {
            $q->where('order_id', 'LIKE', "%{$search}%")
              ->orWhere('status', 'LIKE', "%{$search}%")
              ->orWhere('total_amount', 'LIKE', "%{$search}%");
        });
    }

    $totalRecords = Order::where('user_id', $customerId)->count();
    $totalFiltered = $query->count();

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
    'pending'     => '<span class="badge bg-warning text-dark">Pending</span>',
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
public function customer_orders($id)
{
    $customer = User::with('orders')->findOrFail($id);

    return view('admin.customer.customer_orders', compact('customer'));
}

// Admin/OrdersController.php

public function show($id)
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

    return view('admin.customer.customer_order_details', compact('order', 'productsMetaData','deliverMetaData','bangletMetaData'));
}

public function updateStatus(Request $request, $id)
{
    $order = Order::findOrFail($id);
    $order->status = $request->status;
    $order->save();

    return redirect()->back()->with('success', 'Order status updated successfully!');
}
public function updatePoints(Request $request)
{
    $request->validate([
        'customer_id' => 'required|exists:users,id',
        'total_points' => 'required|integer|min:0',
    ]);

    $customer = User::findOrFail($request->customer_id);
    $customer->total_points = $request->total_points;
    $customer->save();

    return response()->json(['success' => true]);
}

}
