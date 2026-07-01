<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class VerifyOtpMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->method() === 'GET' && $request->query('otp') !== null) {
            // Request has an OTP, we'll now try and verify it
            $otp = trim($request->query('otp'));

            $user = User::where('otp', $otp)->first();
            if ($user === null || $user->otp_expiry < now()) {
                // Unknown or expired OTP
                if ($request->user() !== null) {
                    // We're already logged in. Ignore the invalid OTP and pass on the request.
                    return $next($request);
                }

                return redirect()->route('login');
            }

            // Delete OTP (one-use)
            $user->otp = null;
            $user->otp_expiry = null;
            $user->save();

            // Login user
            Auth::login($user);
            Session::regenerate();
        }

        return $next($request);
    }
}
