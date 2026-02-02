<?php

namespace App\Http\Controllers;

use App\Models\WishList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class WishlistController extends Controller
{
public function toggle(Request $request)
    {
        $request->validate([
            'product_id'   => 'required|integer|exists:products,id',
            'variation_id' => 'nullable|integer|exists:product_variations,id',
        ]);

        $userId = Auth::id();
        $sessionId = null;
        if (!$userId) {
            $sessionId = session()->get('wishlist_session_id');
            if (!$sessionId) {
                $sessionId = Str::uuid()->toString();
                session()->put('wishlist_session_id', $sessionId);
            }
        }

        $wishlist = WishList::where('product_id', $request->product_id)
        ->where('user_id', $userId)
            ->first();
        // $wishlist = Wishlist::where('product_id', $request->product_id)
        //     ->when($request->variation_id, fn($q) => $q->where('variation_id', $request->variation_id))
        //     ->where(function ($q) use ($userId, $sessionId) {
        //         if ($userId) {
        //             $q->where('user_id', $userId);
        //         } else {
        //             $q->where('session_id', $sessionId);
        //         }
        //     })
        //     ->first();

        if ($wishlist) {
            $wishlist->delete();

            return response()->json([
                'status'  => 'removed',
                'message' => 'Removed from wishlist',
            ]);
        }
        $wishlist = Wishlist::create([
            'user_id'      => $userId ?: null,
            'session_id'   => $userId ? null : $sessionId,
            'product_id'   => $request->product_id,
            'variation_id' => $request->variation_id,
        ]);

        return response()->json([
            'status'   => 'added',
            'message'  => 'Added to wishlist',
            'wishlist' => $wishlist,
        ]);
    }


  public function list(Request $request)
{
    $userId = Auth::id();

    $query = Wishlist::query()
        ->with(['product.variations', 'variation']);

         $query->where('user_id', $userId);

    $items = $query->get();

    return response()->json([
        'status'   => 'ok',
        'count'    => $items->count(),
        'wishlist' => $items,
    ]);
}
}
