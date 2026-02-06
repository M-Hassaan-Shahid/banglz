<?php

namespace App\Services;

use App\Mail\PreferencesUpdatedMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class PreferenceService
{
    /**
     * Update user communication preferences.
     *
     * @param User $user
     * @param array $preferences
     * @return bool
     */
    public function updatePreferences(User $user, array $preferences): bool
    {
        // Filter only the preference fields
        $allowedFields = ['marketing_emails', 'order_updates', 'newsletter', 'product_recommendations'];
        $filteredPreferences = array_intersect_key($preferences, array_flip($allowedFields));

        // Update user preferences
        return $user->update($filteredPreferences);
    }

    /**
     * Get current preferences for a user.
     *
     * @param User $user
     * @return array
     */
    public function getPreferences(User $user): array
    {
        return [
            'marketing_emails' => $user->marketing_emails ?? true,
            'order_updates' => $user->order_updates ?? true,
            'newsletter' => $user->newsletter ?? false,
            'product_recommendations' => $user->product_recommendations ?? true,
        ];
    }

    /**
     * Send preferences updated notification email to the user.
     *
     * @param User $user
     * @param array $preferences
     * @return void
     */
    public function sendPreferencesUpdatedNotification(User $user, array $preferences): void
    {
        try {
            Mail::to($user->email)->queue(new PreferencesUpdatedMail($user, $preferences));
        } catch (\Exception $e) {
            // Log the error but don't throw exception to avoid blocking user workflow
            \Log::error('Failed to send preferences updated email', [
                'user_id' => $user->id,
                'email' => $user->email,
                'error' => $e->getMessage()
            ]);
        }
    }
}
