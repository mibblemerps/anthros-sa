<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if (!$request->query('otp')) {
            return view('login');
        }

        $to = $request->query('to') ?? 'uploader';

        $otp = trim($request->query('otp'));

        $user = User::where('otp', $otp)->first();
        if ($user === null || $user->otp_expiry < now()) {
            // Unknown or expired OTP
            if ($request->user() !== null) {
                // We're already logged in. Ignore the invalid OTP and continue as current user.
                return redirect()->route($to);
            }

            return view('login');
        }

        // Delete OTP (one-use)
        $user->otp = null;
        $user->otp_expiry = null;
        $user->save();

        // Login user
        Auth::login($user);
        Session::regenerate();

        Log::info("User {$user->name} logged in via OTP link.");

        return redirect()->route($to);
    }
}
