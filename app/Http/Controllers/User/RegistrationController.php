<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    public function referrer_link(Request $request)
    {
        $referrel_code= $request->referrel_code;

        return view('frontend.pages.referrals.join', [
            'referrer_code' => $referrel_code
        ]);
    }
    public function store (Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'referral_code' => 'nullable|string|exists:users,code',
        ]);

        $referrer = User::where('code', $request->referral_code)->first();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'referred_by' => $referrer ? $referrer->id : null,
        ]);

        return redirect()->route('login')->with('success', 'Registration successful. Please login.');
    }
}
