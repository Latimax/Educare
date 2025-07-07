<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\SchoolInfo;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;
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
        if (Auth::guard('student')->check()) {
            return redirect()->route('student.dashboard')
                ->with('status', 'You are already logged in!');
        }

        $schoolinfo = SchoolInfo::first();

        // Show the login form
        return view('student.auth.login', compact('schoolinfo'));
    }

    /**
     * Handle student login request with enhanced validation and security
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
            'studentId' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:4'],
        ], [
            'studentId.required' => 'Please enter your studentId.',
            'password.required' => 'Please enter your password.',
            'password.min' => 'Password must be at least 4 characters.',
        ]);

        // Attempt to log the user in
        if (Auth::guard('student')->attempt($credentials)) {
            // Clear rate limiter on successful login
            RateLimiter::clear($this->throttleKey($request));

            // Regenerate session ID to prevent session fixation
            $request->session()->regenerate();

            // Log successful login for security auditing
            Log::info('Student logged in successfully', [
                'student_id' => Auth::id(),
                'studentId' => $request->studentId,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            // Redirect to student dashboard after successful login
            return redirect()->intended(route('student.dashboard'))
                ->with('status', 'You have been successfully logged in!');
        }

        // Increment failed login attempts
        RateLimiter::hit($this->throttleKey($request));

        // Authentication failed
        throw ValidationException::withMessages([
            'studentId' => ['The provided credentials do not match our records.'],
        ]);
    }

    /**
     * Show the student profile page.
     *
     * @return \Illuminate\View\View
     */
    public function showProfile()
    {
        $student = Auth::guard('student')->user();
        $schoolinfo = SchoolInfo::first();

        $student->load('parent');
        $student->load('studentClass');

        // Set default active tab to 'profile'
        $activeTab = 'profile';
        return view('student.pages.profile', compact('student', 'schoolinfo', 'activeTab'));
    }


    public function changePassword(Request $request)
    {
        $student = Auth::guard('student')->user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:4|confirmed',
        ]);

        if (!Hash::check($request->current_password, $student->password)) {
            // Validation failed, return the current page with errors and set activeTab to 'change'
            return redirect()->back()
                ->withErrors(['current_password' => 'Current password does not match our records.'])
                ->withInput() // This keeps the input data
                ->with('activeTab', 'change');
        }

        $student->update([
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
                'studentId' => ['Too many login attempts. Please try again in ' . $seconds . ' seconds.'],
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
        return Str::lower($request->input('studentId')) . '|' . $request->ip();
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
            Log::info('Student logged out', [
                'student_id' => Auth::id(),
                'ip' => $request->ip()
            ]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('student.login')
            ->with('status', 'You have been successfully logged out!');
    }
}
