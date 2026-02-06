<?php

namespace App\Services;

use App\Models\User;

class SubscriptionService
{
    /**
     * Toggle subscription status for the user.
     *
     * @param User $user
     * @return bool
     */
    public function toggleSubscription(User $user): bool
    {
        $user->email_subscribed = !$user->email_subscribed;
        return $user->save();
    }

    /**
     * Get current subscription status for the user.
     *
     * @param User $user
     * @return bool
     */
    public function getSubscriptionStatus(User $user): bool
    {
        return $user->email_subscribed ?? true;
    }

    /**
     * Unsubscribe user from marketing emails.
     *
     * @param User $user
     * @return bool
     */
    public function unsubscribe(User $user): bool
    {
        $user->email_subscribed = false;
        return $user->save();
    }

    /**
     * Subscribe user to marketing emails.
     *
     * @param User $user
     * @return bool
     */
    public function subscribe(User $user): bool
    {
        $user->email_subscribed = true;
        return $user->save();
    }
}
