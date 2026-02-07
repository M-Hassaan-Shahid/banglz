<?php

namespace App\Services;

use App\Mail\PasswordChangedMail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PasswordService
{
    /**
     * Verify if the current password matches the stored password hash.
     *
     * @param User $user
     * @param string $currentPassword
     * @return bool
     */
    public function verifyCurrentPassword(User $user, string $currentPassword): bool
    {
        return Hash::check($currentPassword, $user->password);
    }

    /**
     * Update the user's password with a new hashed password.
     *
     * @param User $user
     * @param string $newPassword
     * @return bool
     */
    public function updatePassword(User $user, string $newPassword): bool
    {
        $user->password = Hash::make($newPassword);
        return $user->save();
    }

    /**
     * Validate if password meets security requirements.
     *
     * @param string $password
     * @return bool
     */
    public function validatePasswordStrength(string $password): bool
    {
        // Check minimum length
        if (strlen($password) < 8) {
            return false;
        }

        // Check for at least one uppercase letter
        if (!preg_match('/[A-Z]/', $password)) {
            return false;
        }

        // Check for at least one lowercase letter
        if (!preg_match('/[a-z]/', $password)) {
            return false;
        }

        // Check for at least one digit
        if (!preg_match('/\d/', $password)) {
            return false;
        }

        // Check for at least one special character
        if (!preg_match('/[!@#$%^&*()_+]/', $password)) {
            return false;
        }

        return true;
    }

    /**
     * Send password changed notification email to the user.
     *
     * @param User $user
     * @return void
     */
    public function sendPasswordChangedNotification(User $user): void
    {
        try {
            Mail::to($user->email)->send(new PasswordChangedMail($user));
        } catch (\Exception $e) {
            // Log the error but don't throw exception to avoid blocking user workflow
            \Log::error('Failed to send password changed email', [
                'user_id' => $user->id,
                'email' => $user->email,
                'error' => $e->getMessage()
            ]);
        }
    }
}
