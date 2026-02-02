<?php

namespace App\Http\Controllers;

use App\Http\Controllers\admin\BangleSize;
use App\Models\BangleBoxColor;
use App\Models\BangleBoxSize;
use App\Models\BoxSize;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BanglzBox extends Controller
{
    public function index()
    {
        $sizes = BangleBoxSize::selectRaw('MIN(id) as id, size')
            ->groupBy('size')
            ->orderByRaw('CAST(REPLACE(size, ".", "") AS UNSIGNED) ASC')
            ->get();

        $boxSize = BoxSize::orderByRaw('CAST(REPLACE(size, ".", "") AS UNSIGNED) ASC')->get();

        return view('pages.banglz-box', compact('sizes', 'boxSize'));
    }



    public function getColors($id)
    {
        try {
            $bangleBoxColors = BangleBoxColor::where('bangle_box_size_id', $id)->get();

            if ($bangleBoxColors->isEmpty()) {
                return response()->json([
                    'message' => 'This size is not available',
                    'error'   => 'This size is not available'
                ], 404);
            }

            return response()->json($bangleBoxColors);
        } catch (\Exception $e) {
            Log::error('GetColors Error: ' . $e->getMessage());

            return response()->json([
                'message' => 'Server error while fetching colors'
            ], 500);
        }
    }
    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'size_id'   => 'required|exists:bangle_box_sizes,id',
            'color_ids' => 'required|array|min:1',
            'color_ids.*' => 'exists:bangle_box_colors,id',
            'box_id'    => 'required|exists:box_sizes,id',
            'box_size'  => 'required|string',
        ]);

        $sizeId   = $validated['size_id'];
        $colorIds = $validated['color_ids']; // array of color IDs
        $boxId    = $validated['box_id'];
        $boxSize  = $validated['box_size'];
        // dd($validated);

        $userId    = Auth::check() ? Auth::id() : null;
        $sessionId = session()->get('cart_session_id');
        if ($userId) {
            $cart = Cart::create([
                'user_id' => $userId,
                'session_id' => null,
                'type' => 'bangle_box',
                'bangle_size_id' => $sizeId,
                'bangle_box_id' => $boxId,
                'bangle_box_size' => $boxSize,
                'qty' => 1,
            ]);
        } else {
             if (!$sessionId) {
            $sessionId = Str::uuid()->toString();
            session()->put('cart_session_id', $sessionId);
        }
            $cart = Cart::create([
                'user_id' => null,
                'session_id' => $sessionId,
                'type' => 'bangle_box',
                'bangle_size_id' => $sizeId,
                'bangle_box_id' => $boxId,
                'bangle_box_size' => $boxSize,
                'qty' => 1,
            ]);
        }
        if ($cart) {
            foreach ($colorIds as $colorId) {
                $cart->bangleCartColors()->create([
                    'color_id' => $colorId,
                ]);
            }
        }
        return response()->json([
            'message' => 'Bangle box added to cart successfully',
            'data' => [
                'size_id' => $sizeId,
                'color_ids' => $colorIds,
                'box_id' => $boxId,
                'box_size' => $boxSize,
            ]
        ]);
    }
}
