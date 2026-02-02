<?php

namespace App\Http\Controllers;

use App\Models\GiftCardCodes;
use Illuminate\Http\Request;

class GiftCardController extends Controller
{
   public function showGiftCards()
{
    $giftCardPrices = config('services.gift_cards');

    return view('pages.gift-card', compact('giftCardPrices'));
}
 public function check(Request $request)
    {
        $code = $request->query('code');

        $giftCard = GiftCardCodes::where('code', $code)
            ->where('status', 'active')
            ->first();

        if (!$giftCard) {
            return response()->json([
                'valid' => false,
                'message' => 'Invalid or expired gift card code'
            ]);
        }
        $giftCard->load('histories');
        $totalUsed = $giftCard->histories->sum('used_amount');
        $remainingAmount = $giftCard->amount - $totalUsed;
        if ($remainingAmount <= 0) {
            return response()->json([
                'valid' => false,
                'message' => 'Gift card has been used up'
            ]);
        }
        return response()->json([
            'valid'  => true,
            'total_amount' => $giftCard->amount,
            'code'   => $giftCard->code,
            'remaining_amount' => $remainingAmount, // Assuming full amount is available
        ]);
    }

    public function giftCardHistory()
    {
        $giftCards = GiftCardCodes::where('recipient_email', auth()->user()->email)->with('histories')->get();
        return response()->json($giftCards);
    }
}
