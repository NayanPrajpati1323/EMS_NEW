<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\RegisterEmployeesModel; // or your User model
use Illuminate\Support\Facades\Cache;


class ForgotPasswordController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:employees,email']);
        $otp = rand(100000, 999999);

        // Store OTP in cache for 10 minutes
        Cache::put('otp_' . $request-> email, $otp, now()->addMinutes(10));

        // Send OTP via email
        Mail::raw("Your password reset OTP is: $otp", function ($message) use ($request){
            $message->to($request->email)
                ->subject('Password Reset OTP');
        });
        return response()->json(['message' => 'OTP sent to your email.']);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:employees,email',
            'otp' => 'required|digits:6',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $cachedOtp = Cache::get('otp_' . $request->email);
        if ($cachedOtp != $request->otp) {
            return response()->json(['message' => 'Invalid OTP.'], 400);
        }

        $user = RegisterEmployeesModel::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Invalidate the OTP
        Cache::forget('otp_' . $request->email);

        return response()->json(['message' => 'Password reset successful.']);
    }
}
