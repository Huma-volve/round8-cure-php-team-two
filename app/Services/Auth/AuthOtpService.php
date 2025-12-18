<?php

namespace App\Services\Auth;

use App\Models\Otp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AuthOtpService
{
    public function sendOtp(int $userId, string $phone, bool $forceResend = false): array
    {

        $user = User::find($userId);
    
    if (!$user) {
        return ['status' => false, 'message' => 'User not found.'];
    }

        if ($user->phone !== $phone) {
        return [
            'status' => false,
            'message' => 'Phone number does not match user record.'
        ];
    }


        $existing = Otp::where('user_id', $userId)
            ->where('expires_at', '>', now())
            ->first();

        if ($existing && !$forceResend) {
            return ['status' => false, 'message' => 'OTP already sent.'];
        }

        Otp::where('user_id', $userId)->delete();

        $otp = 1234;

        Otp::create([
            'user_id'    => $userId,
            'phone'      => $phone,
            'otp'        => $otp,
            'expires_at' => Carbon::now()->addMinutes(5),
        ]);

        
        $message = "Your verification code is: $otp";

            return [
            'status'  => true,
            'message' => 'OTP sent successfully.',
            'otp'     => $otp 
        ];
    }

     public function resendOtp(int $userId, string $phone): array
    {
        return $this->sendOtp($userId, $phone, forceResend: true);
    }


    public function verifyOtp(int $userId, int $otp): array
    {
        
        $record = Otp::where('user_id', $userId)
                     ->where('otp', $otp)
                     ->orderBy('id', 'desc')
                     ->first();

        if (!$record) {
            return ['status' => false, 'message' => 'Invalid OTP.'];
        }

        if (now()->greaterThan($record->expires_at)) {
            $record->delete();
            return ['status' => false, 'message' => 'OTP expired.'];
        }

        $user = User::find($userId);
        if (!$user) {
            return ['status' => false, 'message' => 'User not found.'];
        }

        $user->status = true;
        $user->save();

        $record->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'status'     => true,
            'message'    => 'OTP verified successfully.',
            'data'       => $user,
            'token'      => $token,
            'token_type' => 'Bearer'
        ];
    }
}  