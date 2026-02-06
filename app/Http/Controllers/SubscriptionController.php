<?php

namespace App\Http\Controllers;

use App\Services\SubscriptionService;
use Illuminate\Http\JsonResponse;

class SubscriptionController extends Controller
{
    private SubscriptionService $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->middleware('auth');
        $this->subscriptionService = $subscriptionService;
    }

    /**
     * Toggle subscription status for the authenticated user.
     */
    public function toggle(): JsonResponse
    {
        try {
            $user = auth()->user();

            // Toggle subscription status
            $this->subscriptionService->toggleSubscription($user);

            // Get updated status
            $newStatus = $this->subscriptionService->getSubscriptionStatus($user);

            return response()->json([
                'success' => true,
                'subscribed' => $newStatus,
                'message' => $newStatus 
                    ? 'You have successfully subscribed to marketing emails.' 
                    : 'You have successfully unsubscribed from marketing emails.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update subscription status. Please try again.',
            ], 500);
        }
    }
}
