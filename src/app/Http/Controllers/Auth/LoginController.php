<?php

namespace App\Http\Controllers\Auth;

use App\Models\Role;
use App\Http\Controllers\Controller;
use App\Events\Lockout;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected function redirectTo()
    {
        $user = Auth::user();
        
        if (!$user) {
            return route('frontend.home');
        }

        // Get user's role name
        $roleName = $user->role ? $user->role->name : '';

        return match (strtolower($roleName ?? '')) {
            'administrator' => route('administrator.home'),
            'users' => route('user.home'),
            'saler' => route('saler.home'),
            'shipper' => route('shipper.home'),
            'manager' => route('manager.home'),
            default => route('frontend.home'),
        };
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function username()
    {
        $login = request()->input('email');
        
        if (!$login) {
            return 'email';
        }

        $fieldType = $this->findLoginField($login);
        
        // Merge appropriate field into request
        request()->merge([$fieldType => $login]);
        
        return $fieldType;
    }

    protected function findLoginField(string $login): string
    {
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            return 'email';
        }
        if (preg_match('/^[0-9]{9,15}$/', $login)) {
            return 'phone';
        }
        if (preg_match('/^[0-9]{12}$/', $login)) {
            return 'id_card';
        }
        return 'username';
    }

    protected function credentials(Request $request)
    {
        $fieldName = $this->username();
        $credentials = $request->only($fieldName, 'password');
        
        // Add is_active condition
        $credentials['is_active'] = 1;
        
        return $credentials;
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // Check if too many login attempts
        if (RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            $request->session()->regenerate();
            $this->clearLoginAttempts($request);

            return redirect()->intended($this->redirectPath());
        }

        // Increment the login attempts and redirect back with error
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string|min:6',
        ], [
            'email.required' => 'Please enter your email/username.',
            'password.required' => 'Please enter your password.',
            'password.min' => 'Password must be at least 6 characters.',
        ]);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = ['email' => 'The provided credentials are incorrect or the account has not been activated.'];

        if ($request->expectsJson()) {
            throw ValidationException::withMessages($errors);
        }

        return redirect()->back()
            ->withInput($request->only('email'))
            ->withErrors($errors);
    }

    protected function sendLockoutResponse(Request $request)
    {
        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        $errors = ['email' => ["Account temporarily locked. Please try again after {$seconds} seconds."]];

        if ($request->expectsJson()) {
            throw ValidationException::withMessages($errors);
        }

        return redirect()->back()
            ->withInput($request->only('email'))
            ->withErrors($errors);
    }


    protected function fireLockoutEvent(Request $request)
    {
        event(new Lockout($request));
    }


    protected function throttleKey(Request $request)
    {
        return Str::lower($request->input($this->username())).'|'.$request->ip();
    }

    
    public function maxAttempts()
    {
        return 5;
    }

    public function decayMinutes()
    {
        return 1;
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Logged out successfully.']);
        }

        return redirect()->route('frontend.home')->with('success', 'Logged out successfully!');
    }
}