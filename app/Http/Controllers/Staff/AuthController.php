<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\SchoolInfo;
use App\Models\Staff;
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
        if (Auth::guard('staff')->check()) {
            return redirect()->route('staff.dashboard')
                ->with('status', 'You are already logged in!');
        }

        // Show the login form
        return view('staff.auth.login');
    }

    /**
     * Handle staff login request with enhanced validation and security
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
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:4'],
        ], [
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'Please enter your password.',
            'password.min' => 'Password must be at least 4 characters.',
        ]);

        // Add remember me functionality
        $remember = $request->boolean('remember');



        // Attempt to log the user in
        if (Auth::guard('staff')->attempt($credentials, $remember)) {
            // Clear rate limiter on successful login
            RateLimiter::clear($this->throttleKey($request));

            // Regenerate session ID to prevent session fixation
            $request->session()->regenerate();

            // Log successful login for security auditing
            Log::info('Staff logged in successfully', [
                'staff_id' => Auth::id(),
                'email' => $request->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            // Redirect to staff dashboard after successful login
            return redirect()->intended(route('staff.dashboard'))
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
     * Show the staff profile page.
     *
     * @return \Illuminate\View\View
     */
    public function showProfile()
    {
        $staff = Auth::guard('staff')->user();
        $schoolinfo = SchoolInfo::first();

        $staff->load('department');

        // Set default active tab to 'profile'
        $activeTab = 'profile';
        return view('staff.pages.profile', compact('staff', 'schoolinfo', 'activeTab'));
    }

    /**
     * Update the staff profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
    {

        $staff = Auth::guard('staff')->user();

        // Validate input data based on form fields
        $validatedData = $request->validate([
            'fullname'         => 'required|string|max:255',
            'email'            => 'required|string|email|max:255|unique:staffs,email,' . $staff->id,
            'phone'            => 'nullable|string|max:20',
            'dob'              => 'nullable|date',
            'state'            => 'nullable|string|max:100',
            'country'          => 'nullable|string|max:100',
            'gender'           => 'nullable|in:Male,Female,Other',
            'subject_specialty' => 'nullable|string|max:255',
            'photo'            => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle profile photo upload if provided
        if ($request->hasFile('photo')) {
            // Delete old photo if it exists
            if ($staff->photo && Storage::disk('public')->exists($staff->photo)) {
                Storage::disk('public')->delete($staff->photo);
            }

            // Store the new photo
            $file = $request->file('photo');
            $filename = 'staff_' . $staff->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('staff/photos', $filename, 'public');
            $validatedData['photo'] = $path;
        }

        // Update the staff record with the validated data
        Staff::where('id', $staff->id )->update($validatedData);

        // Return back with success message and active tab
        return redirect()->back()
            ->with(['success' => 'Profile updated successfully.', 'activeTab' => 'profile']);
    }

    /**
     * Change the staff password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function changePassword(Request $request)
    {
        $staff = Auth::guard('staff')->user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:4|confirmed',
        ]);

        if (!Hash::check($request->current_password, $staff->password)) {
            // Validation failed, return the current page with errors and set activeTab to 'change'
            return redirect()->back()
                ->withErrors(['current_password' => 'Current password does not match our records.'])
                ->withInput() // This keeps the input data
                ->with('activeTab', 'change');
        }

        $staff->update([
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
            Log::info('Staff logged out', [
                'staff_id' => Auth::id(),
                'ip' => $request->ip()
            ]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('staff.login')
            ->with('status', 'You have been successfully logged out!');
    }
}
