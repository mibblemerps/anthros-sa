<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AccessController extends Controller
{
    public function access(Request $request)
    {
        $body = json_decode($request->getContent(), true);

        Log::info("Generating access link for {$body['name']} ({$body['id']})..." );

        $user = User::where('discord_id', $body['id'])->first();
        if ($user === null) {
            // Need to create user
            $user = new User();
            $user->discord_id = $body['id'];
        }

        // Update user details
        $user->name = $body['name'];
        $user->avatar = $body['avatar'];

        // Generate OTP
        $user->otp = Str::random(16);
        $user->otp_expiry = now()->addHour();

        $user->save();

        return [
            'link' => url('/login?to=uploader&otp=' . $user->otp),
        ];
    }
}
