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
    use Carbon\Carbon;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Str;
    use Laravel\Socialite\Facades\Socialite;

    class AuthController extends Controller
    {


   //Registration function
    public function register(RegisterRequest  $request){
            //validation
            $data = $request->validated();
            $user = User::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => false, 
            ]);
            $user->assignRole('patient');

        $otpdata = $this->sendOtp(new Request([
                'phone' => $user->phone,
                'user_id' => $user->id,
            ]));
            $otp = $otpdata->getData(true);

            return response()->json([
            'message' => 'Account created. OTP sent to your WhatsApp.',
            'user_id' => $user->id,
            'otp ' => $otp['otp'] //for testing purposes only
            ], 201);

            }


        //Login function 
        public function login(LoginRequest $request)
        {
        $creds = $request->validated();

        $user = User::where('phone', $creds['phone'])->first();

        if (!$user || !Hash::check($creds['password'], $user->password)) {
        return response()->json([
            'status'  => false,
            'message' => 'Invalid login details'
        ], 401);
    }

    if (!$user->status) {
        return response()->json([
            'status'  => false,
            'message' => 'Account not verified. Please verify OTP first.'
        ], 403);
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'status'     => true,
        'message'    => 'Logged in successfully',
        'data'       => $user,
        'token'      => $token,
        'token_type' => 'Bearer'
    ], 200);

    }


    // Send OTP function
    public function sendOtp(Request $request)
{
    //validation
    $data = $request->validate([
        'phone'   => 'required|string',
        'user_id' => 'required|integer|exists:users,id',
    ]);

    // Delete any existing OTPs for this user
    Otp::where('user_id', $data['user_id'])->delete();
    
    $otp = random_int(1000, 9999);

    Otp::create([
        'user_id'    => $data['user_id'],
        'phone'      => $data['phone'],
        'otp'        => $otp,
        'expires_at' => Carbon::now()->addMinutes(5),
    ]);

    $message = "Your verification code is: $otp";
    // $this->whatsapp->send($data['phone'], $message); // Send OTP via WhatsApp

    return response()->json([
        'status'  => true,
        'message' => 'OTP sent successfully.',
        'otp'     => $otp //for testing purposes only
    ]);
}




    // Verify OTP function
    public function verifyOtp(VerifyOtpRequest $request)
    {
    $data = $request->validated();
    // Get latest OTP
    $record = Otp::where('user_id', $data['user_id'])
                 ->where('otp', $data['otp'])
                 ->orderBy('id', 'desc')
                 ->first();

    if (!$record) {
        return response()->json([
            'status' => false,
            'message' => 'Invalid OTP.'
        ], 400);
    }
    // Check expiry
    if (now()->greaterThan($record->expires_at)) {
    $record->delete(); 
    return response()->json([
        'status'  => false,
        'message' => 'OTP expired.'
    ], 400);
    }
    // Verify user
    $user = User::find($data['user_id']);
    if (!$user) {
        return response()->json([
            'status'  => false,
            'message' => 'User not found.'
        ], 404);
    }    
    $user->status = true;
    $user->save();
    // Delete this OTP after success
    $record->delete();
    // Generate token
    $token = $user->createToken('auth_token')->plainTextToken;
    return response()->json([
        'status' => true,
        'message' => 'OTP verified successfully.',
        'data' => $user,
        'token' => $token,
        'token_type' => 'Bearer'
    ]);
    }


    // Forgot Password function
    public function forgotPassword(ForgotPasswordRequest $request)
    {
    $user = User::where('phone', $request->phone)->first();
    if (!$user) {
        return response()->json([
            'status'  => false,
            'message' => 'User not found.'
        ], 404);
    }

    if (!$user->status) {
        return response()->json([
            'status'  => false,
            'message' => 'Account not verified.'
        ], 403);
    }

    $this->sendOtp(new Request([
        'phone'   => $user->phone,
        'user_id' => $user->id,
    ]));

    return response()->json([
        'status'  => true,
        'message' => 'OTP sent to your WhatsApp for password reset.',
        'user_id' => $user->id
    ]);
    }





    // Reset Password function
    public function resetPassword(ResetPasswordRequest $request)
    {
        // Get latest OTP
    $record = Otp::where('user_id', $request->user_id)
                 ->where('otp', $request->otp)
                 ->orderBy('id', 'desc')
                 ->first();
        // Check if OTP is valid
    if (!$record) {
        return response()->json([
            'status'  => false,
            'message' => 'Invalid OTP.'
        ], 400);
    }

    if (now()->greaterThan($record->expires_at)) {
        $record->delete();
        return response()->json([
            'status'  => false,
            'message' => 'OTP expired.'
        ], 400);
    }

    $user = User::find($request->user_id);

   if (!$user) {
        return response()->json([
            'status'  => false,
            'message' => 'User not found.'
        ], 404);
    } 

    $user->password = Hash::make($request->password);
    $user->save();

    $record->delete();

    $user->tokens()->delete();

    return response()->json([
        'status'  => true,
        'message' => 'Password reset successfully. Please login with your new password.'
    ]);

}



        // Logout function
        public function logout(Request $request)
        {
        $user = $request->user(); 
        if ($user && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
            return response()->json(['message'=>'User logged out successfully'], 200);
        }
        return response()->json(['message'=>'No authenticated user found'], 401);
        }



        // Delete Account function
     public function deleteAccount(DeleteAccountRequest $request)
        {
        $user = $request->user();
        $password = $request->password;
        if (!Hash::check($password, $user->password)) {
            return response()->json(['message' => 'Wrong password'], 403);
        }
        // revoke tokens and delete
        $user->tokens()->delete();
        $user->delete();
        return response()->json(['message' => 'Account deleted successfully'] , 200);
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

            return response()->json([
            'status' => true,
            'message' => 'Logged in successfully via Google',
            'data' => $user,
            'token' => $token,
            'token_type' => 'Bearer'
        ]);
    }


    }