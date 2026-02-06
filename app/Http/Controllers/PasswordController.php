<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Services\PasswordService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PasswordController extends Controller
{
    private PasswordService $passwordService;

    public function __construct(PasswordService $passwordService)
    {
        $this->middleware('auth');
        $this->passwordService = $passwordService;
    }

    /**
     * Show the password change form.
     */
    public function edit(): View
    {
        return view('password.edit');
    }

    /**
     * Process the password change request.
     */
    public function update(ChangePasswordRequest $request): RedirectResponse
    {
        $user = auth()->user();

        // Verify current password
        if (!$this->passwordService->verifyCurrentPassword($user, $request->current_password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'Current password is incorrect.'])
                ->withInput();
        }

        try {
            // Update password
            $this->passwordService->updatePassword($user, $request->new_password);

            // Send confirmation email
            $this->passwordService->sendPasswordChangedNotification($user);

            return redirect()->route('password.edit')
                ->with('success', 'Password changed successfully. A confirmation email has been sent to your email address.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to change password. Please try again.')
                ->withInput();
        }
    }
}
