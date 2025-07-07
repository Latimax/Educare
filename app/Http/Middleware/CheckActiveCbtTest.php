<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\CbtAttempt;
use Illuminate\Support\Facades\Auth;

class CheckActiveCbtTest
{
    public function handle($request, Closure $next)
    {
       $student = Auth::guard('student')->user();
        $attempt = CbtAttempt::where('student_id', $student->id)
            ->where('is_submitted', '0')
            ->first();

        if ($attempt) {

            // Store active test in session for quick access
            Session::put('active_cbt_test', [
                'attempt_id' => $attempt->id,
                'type' => $attempt->test_type,
                'subject_id' => $attempt->subject_id,
                'end_time' => Carbon::parse($attempt->end_time)->toDateTimeString(),
            ]);

            // Allow access to test-related routes
            if ($request->routeIs('student.cbt.start') ||
                $request->routeIs('student.cbt.submit') ||
                $request->routeIs('student.cbt.result')) {
                return $next($request);
            }

            // Redirect to test page for other routes
            return redirect()->route('student.cbt.start', [
                'type' => $attempt->test_type,
                'subject_id' => $attempt->subject_id
            ])->with('warning', 'Please complete your active test');
        }

        // Clear session if no active test
        Session::forget('active_cbt_test');
        return $next($request);
    }
}
