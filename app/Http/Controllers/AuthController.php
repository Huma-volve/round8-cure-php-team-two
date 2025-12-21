<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteAccountRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\SendOtpRequest;
use App\Http\Requests\VerifyOtpRequest;
use App\Models\Otp;
use App\Models\User;
use App\Services\Auth\AuthOtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Reverb\Loggers\Log;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{

    protected $authOtpService;

    public function __construct(AuthOtpService $authOtpService)
    {
        $this->authOtpService = $authOtpService;
    }
    //Registration function
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $user = User::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $user->assignRole('patient');
        $otpResult = $this->authOtpService->sendOtp($user->id, $user->phone);
        return apiResponse(true, 'Account created. OTP sent to your WhatsApp.', ['user_id' => $user->id, 'otp' => $otpResult['otp'] ?? null], 201);

    }


    //Login function 
    public function login(LoginRequest $request)
    {
        $creds = $request->validated();
        $user = User::where('phone', $creds['phone'])->first();
        if (!$user || !Hash::check($creds['password'], $user->password)) {
            return apiResponse(false, 'Invalid login details', null, 401);
        }
        if (!$user->status) {
            return apiResponse(false, 'Account not verified. Please verify OTP first.', null, 403);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return apiResponse(true, 'Logged in successfully', [
            'data' => $user,
            'token' => $token,
            'token_type' => 'Bearer'
        ], 200);

    }


    // Resend OTP function
    public function resendOtp(SendOtpRequest $request)
    {
        $data = $request->validated();
        $result = $this->authOtpService->sendOtp($data['user_id'], $data['phone'], true);
        return apiResponse($result['status'], $result['message'], ['otp' => $result['otp'] ?? null], $result['status'] ? 200 : 400);
    }
    // Verify OTP function
    public function verifyOtp(VerifyOtpRequest $request)
    {
        $data = $request->validated();
        $result = $this->authOtpService->verifyOtp($data['user_id'], $data['otp']);
        $statusCode = $result['status'] ? 200 : ($result['message'] === 'User not found.' ? 404 : 400);
        return apiResponse($result['status'], $result['message'], $result['data']  ?? null, $statusCode);
    }


    // Forgot Password function
    public function forgotPassword(ForgotPasswordRequest $request)
    {

        $data = $request->validated();
        $user = User::where('phone', $data['phone'])->first();
        if (!$user) {
            return apiResponse(false, 'User not found.', null, 404);
        }
        $otpResult = $this->authOtpService->sendOtp($user->id, $user->phone);
        return apiResponse(true, 'OTP sent to your WhatsApp for password reset.', ['otp' => $otpResult ], 200);
    }


    // Reset Password function
    public function resetPassword(ResetPasswordRequest $request)
    {
        $data = $request->validated();
        // Get latest OTP
        $record = Otp::where('user_id', $data['user_id'])
            ->where('otp', $data['otp'])
            ->orderBy('id', 'desc')
            ->first();

        // Check if OTP is valid
        if (!$record) {
            return apiResponse(false, 'Invalid OTP.', null, 400);

        }


        if (now()->greaterThan($record->expires_at)) {
            $record->delete();
            return apiResponse(false, 'OTP expired.', null, 400);
        }

        $user = User::find($data['user_id']);

        if (!$user) {
            return apiResponse(false, 'User not found.', null, 404);
        }

        $user->password = Hash::make($data['password']);
        $user->save();

        $record->delete();

        $user->tokens()->delete();
        return apiResponse(true, 'Password reset successfully. Please login with your new password.', null, 200);

    }



    // Logout function
    public function logout(Request $request)
    {
        $user = $request->user();
        if ($user && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
            return apiResponse(true, 'User logged out successfully', null, 200);
        }
        return apiResponse(false, 'No authenticated user found', null, 401);
    }
    public function set_password_page()
    {
        
            return view('dashboard.doctor-booking.set-password');
        
    }
    public function set_password(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed'],
        ]);

        $doctor = $request->user();
        $doctor->password = Hash::make($request->password);
        $doctor->save();

        return redirect()->route('doctor.dashboard')->with('status', 'Password set successfully!');
    }


    // Delete Account function
    public function deleteAccount(DeleteAccountRequest $request)
    {
        $data = $request->validated();
        $user = $request->user();
        $password = $data['password'];
        if (!Hash::check($password, $user->password)) {
            return apiResponse(false, 'Wrong password', null, 403);
        }
        // revoke tokens and delete
        $user->tokens()->delete();
        $user->delete();
        return apiResponse(true, 'Account deleted successfully', null, 200);
    }




    public function googleRedirect()
    {
        return Socialite::driver('google')->stateless()->redirect()->getTargetUrl();
    }

    public function googleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Check existing user
        $user = User::where('provider_id', $googleUser->id)
            ->orWhere('email', $googleUser->email)
            ->first();

        if ($user) {
            // Link provider_id if missing
            if (!$user->provider_id) {
                $user->update([
                    'provider_id' => $googleUser->id,
                    'email_verified_at' => $user->email_verified_at ?? now(),
                ]);
            }
        } else {
            // Create new user
            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'phone' => '010xxxxx', // Placeholder phone
                'provider_id' => $googleUser->id,
                'password' => Hash::make(Str::random(32)),
                'status' => true,
                'email_verified_at' => now(),
            ]);

            $user->assignRole('patient');
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return apiResponse(true, 'Logged in successfully via Google', [
            'data' => $user,
            'token' => $token,
            'token_type' => 'Bearer'
        ], 200);
    }


}