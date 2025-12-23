<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;

class MyAuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {

        // $request->authenticate();
        $request->ensureIsNotRateLimited();

        $email = $request->email;
        $password = $request->password;
        $remember = $request->boolean('remember');


        if (\App\Models\Admin::where('email', $email)->exists()) {
            if (Auth::guard('admin')->attempt(['email' => $email, 'password' => $password], $remember)) {
                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard', absolute: false));
            }
        }




        if (\App\Models\Doctor::where('email', $email)->exists()) {
            if (Auth::guard('doctor')->attempt(['email' => $email, 'password' => $password], $remember)) {
                //  dd($password);
                if ($password === 'password') {
                    return redirect()->route('doctor.set-password.show');
                }
                $request->session()->regenerate();
                return redirect()->intended(route('doctor.dashboard', absolute: false));
            }
        }


        RateLimiter::hit($request->throttleKey());
        throw \Illuminate\Validation\ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        
        foreach (['admin', 'doctor', 'web'] as $guard) {
            if (Auth::guard($guard)->check()) {
                Auth::guard($guard)->logout();
                break;
            }
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
