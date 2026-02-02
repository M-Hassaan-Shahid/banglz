<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\PaymentMethod;
use Stripe\Customer;

class CardController extends Controller
{
    public function __construct()
    {
        // require auth for store/delete/setDefault/list saved cards
        $this->middleware('auth')->except(['list']); // list could be protected too if you want
    }

    // GET /cards/list  (route name cards.list)
    public function list()
    {
        $user = Auth::user();
        if (! $user) {
            return response()->json(['status' => 'ok', 'cards' => []]);
        }

        $cards = Card::where('user_id', $user->id)
            ->orderByDesc('is_default')
            ->get()
            ->map(function ($c) {
                return [
                    'id' => $c->id,
                    'card_number' => $c->card_number, // masked via accessor
                    'last4' => $c->card_last4,
                    'brand' => $c->card_brand,
                    'expiry' => $c->expiry,
                    'exp_month' => $c->exp_month,
                    'exp_year' => $c->exp_year,
                    'full_name' => $c->full_name,
                    'street' => $c->street,
                    'apartment' => $c->apartment,
                    'city' => $c->city,
                    'state' => $c->state,
                    'zip' => $c->zip,
                    'phone' => $c->phone,
                    'is_default' => (bool) $c->is_default,
                ];
            });

        return response()->json(['status' => 'ok', 'cards' => $cards]);
    }

    // POST /cards/store (route name cards.store)
    // Expecting: payment_method_id (from Stripe Elements via JS), optional billing fields
    public function store(Request $request)
    {
        $request->validate([
            'payment_method_id' => 'required|string',
            'full_name' => 'nullable|string|max:255',
            'street'    => 'nullable|string|max:255',
            'apartment' => 'nullable|string|max:50',
            'city'      => 'nullable|string|max:120',
            'state'     => 'nullable|string|max:120',
            'zip'       => 'nullable|string|max:30',
            'phone'     => 'nullable|string|max:40',
            'save_card'  => 'nullable|in:0,1',
        ]);

        $user = $request->user();
        if (! $user) {
            return response()->json(['status' => 'error', 'message' => 'Login required to save card.'], 401);
        }

        $pmId = $request->input('payment_method_id');

        // init stripe library
        Stripe::setApiKey(config('services.stripe.secret') ?? env('STRIPE_SECRET'));

        try {
            // get or create Stripe customer for this user (you must implement how you save stripe_customer_id on users table)
            $stripeCustomerId = $user->stripe_customer_id ?? null;
            if (! $stripeCustomerId) {
                $customer = Customer::create([
                    'email' => $user->email,
                    'name'  => $user->name,
                ]);
                $stripeCustomerId = $customer->id;
                // save customer id on user (ensure fillable)
                $user->update(['stripe_customer_id' => $stripeCustomerId]);
            }

            // Attach PaymentMethod to customer
            $pm = PaymentMethod::retrieve($pmId);
            $pm->attach(['customer' => $stripeCustomerId]);

            // optional: set as default payment method for invoices
            $saveCard = (int) $request->input('save_card', 0);
            if ($saveCard) {
                // Set as default payment method
                \Stripe\Customer::update($stripeCustomerId, [
                    'invoice_settings' => ['default_payment_method' => $pmId]
                ]);
            }

            // Extract safe metadata
            $card = $pm->card ?? null;
            $last4 = $card->last4 ?? null;
            $brand = $card->brand ?? null;
            $exp_month = $card->exp_month ?? null;
            $exp_year  = $card->exp_year ?? null;
            $expiry = $exp_month && $exp_year ? sprintf('%02d/%02d', $exp_month, $exp_year % 100) : null;

            // If user requested default, unset other defaults
            if ($saveCard) {
                Card::where('user_id', $user->id)->update(['is_default' => false]);
            }

            $cardRecord = Card::create([
                'user_id' => $user->id,
                'stripe_pm_id' => $pmId,
                'card_last4' => $last4,
                'card_brand' => $brand,
                'exp_month' => $exp_month,
                'exp_year' => $exp_year,
                'expiry' => $expiry,
                'full_name' => $request->input('full_name'),
                'street' => $request->input('street'),
                'apartment' => $request->input('apartment'),
                'city' => $request->input('city'),
                'state' => $request->input('state'),
                'zip' => $request->input('zip'),
                'phone' => $request->input('phone'),
                'is_default' => $saveCard ? true : false
            ]);

            return response()->json(['status' => 'ok', 'message' => 'Card saved', 'card' => $cardRecord]);
        } catch (\Exception $e) {
            Log::error('Stripe store card error: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Failed to save card. ' . $e->getMessage()], 500);
        }
    }

    // DELETE /cards/{card}  (route name cards.delete)
    public function destroy(Card $card)
    {
        $user = Auth::user();
        if ($card->user_id !== $user->id) {
            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], 403);
        }

        // Optionally detach from Stripe (best-effort)
        try {
            if ($card->stripe_pm_id) {
                Stripe::setApiKey(config('services.stripe.secret') ?? env('STRIPE_SECRET'));
                $pm = PaymentMethod::retrieve($card->stripe_pm_id);
                if ($pm && method_exists($pm, 'detach')) {
                    $pm->detach();
                }
            }
        } catch (\Exception $e) {
            Log::warning('Failed to detach PM: ' . $e->getMessage());
        }

        $card->delete();
        return response()->json(['status' => 'ok', 'message' => 'Card deleted']);
    }

    // POST /cards/{card}/default  (route name cards.setDefault)
    public function setDefault(Card $card)
    {
        $user = Auth::user();
        if ($card->user_id !== $user->id) {
            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], 403);
        }

        // unset others
        Card::where('user_id', $user->id)->update(['is_default' => false]);
        $card->is_default = true;
        $card->save();

        // Also update Stripe Customer invoice_settings
        if ($user->stripe_customer_id && $card->stripe_pm_id) {
            Stripe::setApiKey(config('services.stripe.secret') ?? env('STRIPE_SECRET'));
            \Stripe\Customer::update($user->stripe_customer_id, [
                'invoice_settings' => ['default_payment_method' => $card->stripe_pm_id]
            ]);
        }

        return response()->json(['status' => 'ok', 'message' => 'Default updated']);
    }
}
