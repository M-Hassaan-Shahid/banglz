<?php

namespace App\Http\Controllers;

use Omnipay\Omnipay;
use Illuminate\Http\Request;
use App\Models\Payment;
// use App\Models\Cart;


class PayPalController extends Controller
{
    private $gateway;

    public function __construct()
    {
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(env('PAYPAL_SANDBOX_CLIENT_ID'));
        $this->gateway->setSecret(env('PAYPAL_SANDBOX_CLIENT_SECRET'));
        $this->gateway->setTestMode(true); // Sandbox mode
    }

    /**
     * Start the payment process
     */
    public function pay(Request $request)
    {
        try {
            $response = $this->gateway->purchase([
                'amount'    => $request->amount,
                'currency'  => env('PAYPAL_CURRENCY', 'CAD'),
                'returnUrl' => route('payment.success'),
                'cancelUrl' => route('payment.error'),
            ])->send();

            if ($response->isRedirect()) {
                return $response->redirect(); // redirect to PayPal
            } else {
                return $response->getMessage();
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    /**
     * Payment was successful
     */
    public function success(Request $request)
    {
        if ($request->has('paymentId') && $request->has('PayerID')) {
            $transaction = $this->gateway->completePurchase([
                'payer_id'             => $request->get('PayerID'),
                'transactionReference' => $request->get('paymentId'),
            ]);

            $response = $transaction->send();

            if ($response->isSuccessful()) {
                // Payment data
                $data = $response->getData();
                 $payment = Payment::create([
                                'payment_id'     => $data['id'], // PayPal transaction ID
                                'payer_id'       => $data['payer']['payer_info']['payer_id'] ?? '',
                                'payer_email'    => $data['payer']['payer_info']['email'] ?? '',
                                'amount'         => $data['transactions'][0]['amount']['total'] ?? '',
                                'currency'       => $data['transactions'][0]['amount']['currency'] ?? '',
                                'payment_status' => $data['state'] ?? '',
                            ]);

                 $request->session()->invalidate();
                return redirect()->route('payment-conform')->with([
                        'transactionId' => $payment->payment_id,
                        'date'          => $payment->created_at->format('Y-m-d H:i:s'),
                    ]);
            } else {
                return $response->getMessage();
            }
        } else {
            return "Payment failed, missing data.";
        }
    }

    /**
     * Payment was cancelled
     */
    public function error()
    {
        return "User cancelled the payment.";
    }
}