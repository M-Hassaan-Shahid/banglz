<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    
   
  public function login(Request $request)
{
    if ($request->isMethod('post')) {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Add 'type' => 'admin' to credentials
        $credentials = $request->only('email', 'password');
        $credentials['type'] = 'admin';

        if (Auth::attempt($credentials)) {
            return redirect()->route('admin.dashboard')
                             ->with('success', 'Logged In Successfully');
        }

        return back()->with('error', 'Wrong Credentials');
    }

    return view('admin.auth.login');
}
   public function logout(){
        Auth::logout();
        return redirect('admin/login')->with('success', 'Logged Out Successfully');
    }

}
