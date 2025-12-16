<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
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

        // dd("got it");


        if (\App\Models\Doctor::where('email', $email)->exists()) {
             if (Auth::guard('doctor')->attempt(['email' => $email, 'password' => $password], $remember)) {
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
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('doctor')->check()) {
            Auth::guard('doctor')->logout();
        } else {
            Auth::guard('web')->logout();
        }
        // Ideally logout all just to be safe?
        // Auth::guard('web')->logout();
        // Auth::guard('admin')->logout();
        // Auth::guard('doctor')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
