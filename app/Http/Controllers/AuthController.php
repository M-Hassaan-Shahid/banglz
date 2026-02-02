<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use App\Models\Card;
use App\Models\Cart;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
  public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'first_name' => 'required|string|max:50',
        'last_name'  => 'required|string|max:50',
        'email'      => 'required|email',
        'address'    => 'required|string|max:255',
        'country'    => 'required|string',
        'password'   => 'required|min:8|confirmed',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $sessionId = session()->get('cart_session_id'); // guest cart session

    // 🔹 Check if user already exists
    $existingUser = User::where('email', $request->email)->first();

    if ($existingUser) {
        if ($existingUser->is_guest) {
            // Upgrade guest to registered user
            $existingUser->update([
                'name'       => $request->first_name,
                'last_name'  => $request->last_name,
                'address'    => $request->address,
                'country'    => $request->country,
                'password'   => bcrypt($request->password),
                'is_guest'   => false,
                'type'       => 'user',
            ]);

            $user = $existingUser;
        } else {
            return response()->json([
                'errors' => ['email' => ['This email is already registered.']]
            ], 422);
        }
    } else {
        // Create a fresh user
        $user = User::create([
            'name'       => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'address'    => $request->address,
            'country'    => $request->country,
            'password'   => bcrypt($request->password),
            'type'       => 'user',
            'is_guest'   => false,
        ]);

        // Assign customer_id after creation
        $user->update([
            'customer_id' => 'CUST-' . str_pad($user->id, 3, '0', STR_PAD_LEFT),
        ]);
    }

    // 🔹 Merge bundles
    $bundleSessionId = session()->get('bundle_session_id');
    if ($bundleSessionId) {
        Bundle::where('session_id', $bundleSessionId)
            ->whereNull('user_id')
            ->update(['user_id' => $user->id]);
    }

    // 🔹 Move cart items to user
    if ($sessionId) {
        Cart::where('session_id', $sessionId)
            ->whereNull('user_id')
            ->update(['user_id' => $user->id]);
    }

    return response()->json([
        'success' => true,
        'message' => $existingUser && $existingUser->wasChanged('is_guest')
            ? 'Guest account upgraded successfully!'
            : 'Account created successfully!',
        'user'    => $user
    ]);
}


    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $sessionId = session()->get('cart_session_id');
            $bundleSessionId = session()->get('bundle_session_id');
            if ($bundleSessionId) {

                // Merge guest bundles
                Bundle::where('session_id', $sessionId)
                    ->whereNull('user_id')
                    ->update(['user_id' => $user->id]);
            }
            if ($sessionId) {
                // Merge guest cart into user cart
                Cart::where('session_id', $sessionId)
                    ->whereNull('user_id')
                    ->update(['user_id' => $user->id]);
                // dd('sessionId', $sessionId, 'user_id', $user->id , 'Cart', Cart::where('session_id', $sessionId)->whereNull('user_id')->get(), 'Bundle', Bundle::where('session_id', $sessionId)->whereNull('user_id')->get() );
                $user->update(['session_id' => $sessionId]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Login successful!',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials'
        ], 401);
    }




    public function logout(Request $request)
    {
        if (Auth::check()) {
            $sessionId = Auth::user()->session_id;

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            if ($sessionId) {
                session()->put('cart_session_id', $sessionId);
                session()->put('bundle_session_id', $sessionId);
            }
        }

        return redirect()->route('user.login');
    }





    public function updateField(Request $request)
    {
        $field = $request->input('field');
        $value = $request->input('value');
        if (! in_array($field, $allowed)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Field not allowed.',
            ], 422);
        }

        // Validation rules per field
        $rules = [];
        $messages = [];

        switch ($field) {
            case 'first_name':
                $rules['value'] = ['nullable', 'string', 'max:191'];
                break;

            case 'birthday':
                // client sends MM/DD, optional
                $rules['value'] = ['nullable', 'regex:/^\d{1,2}\/\d{1,2}$/'];
                $messages['value.regex'] = 'Birthday must be in MM/DD format.';
                break;

            default:
                $rules['value'] = ['nullable', 'string', 'max:191'];
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $user = Auth::user();
        if (! $user) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Not authenticated.',
            ], 401);
        }

        // Prepare value to store
        $storeValue = null;
        try {
            if ($field === 'birthday') {
                if ($value === null || $value === '') {
                    $storeValue = null;
                } else {
                    // convert MM/DD to Y-m-d using current year
                    [$m, $d] = array_map('intval', explode('/', $value));
                    $year = now()->year;

                    // validate month/day ranges
                    if ($m < 1 || $m > 12 || $d < 1 || $d > 31) {
                        return response()->json([
                            'status'  => 'error',
                            'message' => 'Invalid month or day.',
                        ], 422);
                    }

                    // use Carbon to create safe date (this will normalize/catch invalid day for month)
                    $date = Carbon::createFromDate($year, $m, $d);
                    $storeValue = $date->format('Y-m-d');
                }
                // store
                $user->birthday = $storeValue;
            } else { // first_name
                $storeValue = $value === null ? null : (string) $value;
                $user->first_name = $storeValue;
            }

            $user->save();
        } catch (\Exception $e) {
            // log if you want: \Log::error($e);
            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to save data.',
            ], 500);
        }

        // Prepare display-friendly value
        $display = '';
        if ($field === 'birthday') {
            $display = $storeValue ? Carbon::parse($storeValue)->format('m/d') : 'Add Birthday';
        } else { // first_name
            $display = $storeValue ?? '';
        }

        return response()->json([
            'status'        => 'ok',
            'message'       => 'Profile updated',
            'field'         => $field,
            'value'         => $storeValue,
            'value_display' => $display,
        ], 200);
    }
}
