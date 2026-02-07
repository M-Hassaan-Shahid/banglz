<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    /**
     * Show the subscription management page.
     */
    public function index()
    {
        return view('subscription.manage');
    }

    /**
     * Check subscription status for an email.
     */
    public function checkStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please enter a valid email address.'
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Email address not found in our system.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'subscribed' => (bool)$user->email_subscribed,
            'message' => $user->email_subscribed 
                ? 'You are currently subscribed to our marketing emails.' 
                : 'You are currently unsubscribed from our marketing emails.'
        ]);
    }

    /**
     * Unsubscribe an email from marketing communications.
     */
    public function unsubscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please enter a valid email address.'
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Email address not found in our system.'
            ], 404);
        }

        if (!$user->email_subscribed) {
            return response()->json([
                'success' => false,
                'message' => 'This email is already unsubscribed.'
            ], 400);
        }

        // Unsubscribe user
        $user->update([
            'email_subscribed' => false,
            'marketing_emails' => false
        ]);

        \Log::info('User unsubscribed from marketing emails', [
            'email' => $user->email,
            'user_id' => $user->id
        ]);

        return response()->json([
            'success' => true,
            'subscribed' => false,
            'message' => 'You have been successfully unsubscribed from marketing emails.'
        ]);
    }

    /**
     * Re-subscribe an email to marketing communications.
     */
    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please enter a valid email address.'
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Email address not found in our system.'
            ], 404);
        }

        if ($user->email_subscribed) {
            return response()->json([
                'success' => false,
                'message' => 'This email is already subscribed.'
            ], 400);
        }

        // Re-subscribe user
        $user->update([
            'email_subscribed' => true,
            'marketing_emails' => true
        ]);

        \Log::info('User re-subscribed to marketing emails', [
            'email' => $user->email,
            'user_id' => $user->id
        ]);

        return response()->json([
            'success' => true,
            'subscribed' => true,
            'message' => 'You have been successfully re-subscribed to marketing emails.'
        ]);
    }
}
