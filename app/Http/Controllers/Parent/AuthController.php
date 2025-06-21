<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\SchoolInfo;
use App\Models\StudentParent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Show the login form
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        // Check if the user is already logged in
        if (Auth::guard('parent')->check()) {
            return redirect()->route('parent.dashboard')
                ->with('status', 'You are already logged in!');
        }

        // Show the login form
        return view('parent.auth.login');
    }

    /**
     * Handle parent login request with enhanced validation and security
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        // Apply rate limiting to prevent brute force attacks
        $this->checkRateLimiting($request);

        // Validate login data with more specific rules
        $credentials = $request->validate([
            'email' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:4'],
        ], [
            'email.required' => 'Please enter your email address.',
            'password.required' => 'Please enter your password.',
            'password.min' => 'Password must be at least 4 characters.',
        ]);

        // Add remember me functionality
        $remember = $request->boolean('remember');

        // Check if the user exists and is a parent

        $parent = StudentParent::where('email', $request->email)->first() ?? StudentParent::where('phone', $request->email)->first();

        // Attempt to log the user in
        if (Auth::guard('parent')->attempt($credentials, $remember)) {
            // Clear rate limiter on successful login
            RateLimiter::clear($this->throttleKey($request));

            // Regenerate session ID to prevent session fixation
            $request->session()->regenerate();

            // Log successful login for security auditing
            Log::info('Parent logged in successfully', [
                'id' => Auth::id(),
                'email' => $request->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            // Redirect to parent dashboard after successful login
            return redirect()->intended(route('parent.dashboard'))
                ->with('status', 'You have been successfully logged in!');
        }

        // Increment failed login attempts
        RateLimiter::hit($this->throttleKey($request));

        // Authentication failed
        throw ValidationException::withMessages([
            'email' => ['The provided credentials do not match our records.'],
        ]);
    }

    /**
     * Show the parent profile page.
     *
     * @return \Illuminate\View\View
     */
    public function showProfile()
    {
        $parent = Auth::guard('parent')->user();
        $schoolinfo = SchoolInfo::first();
        // Set default active tab to 'profile'
        $activeTab = 'profile';
        return view('parent.pages.profile', compact('parent', 'schoolinfo', 'activeTab'));
    }

    /**
     * Update the parent profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
    {
        $parent = Auth::guard('parent')->user();

        // Validate input data including optional phone and profile_image
        $validatedData = $request->validate([
            'fullname'          => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:parents,email,' . $parent->id,
            'phone' => 'required|unique:parents,phone,' . $parent->id,
        ]);

        // Update the parent record with the validated data
        $parent->update($validatedData);

        // Return back with the profile tab active
        return redirect()->back()
            ->with(['success' => 'Profile updated successfully.', 'activeTab' => 'profile']);
    }

    /**
     * Change the parent password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function changePassword(Request $request)
    {
        $parent = Auth::guard('parent')->user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:4|confirmed',
        ]);

        if (!Hash::check($request->current_password, $parent->password)) {
            // Validation failed, return the current page with errors and set activeTab to 'change'
            return redirect()->back()
                ->withErrors(['current_password' => 'Current password does not match our records.'])
                ->withInput() // This keeps the input data
                ->with('activeTab', 'change');
        }

        $parent->update([
            'password' => Hash::make($request->new_password),
        ]);

        // Return back with the change tab active on success
        return redirect()->back()
            ->with(['success' => 'Password changed successfully.', 'activeTab' => 'change']);
    }

    /**
     * Check rate limiting for login attempts
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    private function checkRateLimiting(Request $request)
    {
        $throttleKey = $this->throttleKey($request);

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            throw ValidationException::withMessages([
                'email' => ['Too many login attempts. Please try again in ' . $seconds . ' seconds.'],
            ]);
        }
    }

    /**
     * Get the rate limiting throttle key for the request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    private function throttleKey(Request $request)
    {
        return Str::lower($request->input('email')) . '|' . $request->ip();
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // Log logout for security auditing
        if (Auth::check()) {
            Log::info('Parent logged out', [
                'id' => Auth::id(),
                'ip' => $request->ip()
            ]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('parent.login')
            ->with('status', 'You have been successfully logged out!');
    }
}
