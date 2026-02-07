<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePreferencesRequest;
use App\Services\PreferenceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PreferenceController extends Controller
{
    private PreferenceService $preferenceService;

    public function __construct(PreferenceService $preferenceService)
    {
        $this->middleware('auth');
        $this->preferenceService = $preferenceService;
    }

    /**
     * Show the preferences form with current values.
     */
    public function edit(): View
    {
        $user = auth()->user();
        $preferences = $this->preferenceService->getPreferences($user);

        return view('preferences.edit', compact('preferences'));
    }

    /**
     * Update user communication preferences.
     */
    public function update(UpdatePreferencesRequest $request)
    {
        $user = auth()->user();

        try {
            // Update preferences
            $this->preferenceService->updatePreferences($user, $request->validated());

            // Send confirmation email
            $this->preferenceService->sendPreferencesUpdatedNotification($user, $request->validated());

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Communication preferences updated successfully. A confirmation email has been sent.'
                ]);
            }

            return redirect()->route('preferences.edit')
                ->with('success', 'Communication preferences updated successfully. A confirmation email has been sent.');
        } catch (\Exception $e) {
            \Log::error('Preferences update error', ['error' => $e->getMessage()]);
            
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update preferences. Please try again.'
                ], 500);
            }
            
            return redirect()->back()
                ->with('error', 'Failed to update preferences. Please try again.')
                ->withInput();
        }
    }
}
