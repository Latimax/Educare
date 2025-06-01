<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\SchoolInfo;
use App\Models\Student;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schoolinfo = SchoolInfo::first();

        $payments = Payment::with(['student'])->get();

        return view('admin.pages.payments.index', compact('schoolinfo', 'payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schoolinfo = SchoolInfo::first();

        $students = Student::all();

        return view('admin.pages.payments.create', compact('schoolinfo', 'students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate form data
        $validated = $request->validate([
            'student_id'      => 'required|exists:students,id',
            'amount_paid'          => 'required|numeric|min:100',
            'purpose'         => 'required|string|max:255',
            'balance'         => 'required|numeric|min:0',
            'paid_by'         => 'required|string|max:255',
            'received_by'     => 'required|string|max:255',
            'payment_date'    => 'required|date',
            'payment_method'    => 'required|in:cash,bank,card',
            'status'          => 'required|in:paid,pending,failed',
            'notes'           => 'nullable|string',
            'receipt_number'  => 'nullable|string|max:255',
            'reference'       => 'nullable|string|max:255|unique:payments,reference',
            'session'         => 'nullable|string|max:255',
            'term'            => 'nullable|in:first,second,third'
        ]);

        // Reference, receipt generation
        $reference = $request->input('reference') ?: strtoupper('PAY-' . uniqid() . '-' . rand(1000, 9999));
        $receipt_number = $request->input('receipt_number') ?: strtoupper('RCPT-' . time() . '-' . rand(100, 999));

        // Get school session and term if not supplied in form
        $schoolinfo = SchoolInfo::first();
        $session = $request->input('session') ?: ($schoolinfo->current_session ?? null);
        $term = $request->input('term') ?: ($schoolinfo->current_term ?? null);

        // Save payment to DB
        $validated['reference'] = $reference;
        $validated['receipt_number'] = $receipt_number;

        $validated['session'] = $session;
        $validated['term'] = $term;

        Payment::create($validated);

        // Fetch updated payments list with relationships
        $payments = Payment::with(['student'])->get();
        $schoolinfo = SchoolInfo::first();

        // Redirect back to payments index with success message
        return view('admin.pages.payments.index', compact('schoolinfo', 'payments'))->with('success', 'Payment created successfully for student.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {

        $schoolinfo = SchoolInfo::first();

        //get the payment record
        $payment = Payment::with(['student'])->findOrFail($payment->id);


        return view('admin.pages.payments.edit', compact('schoolinfo', 'payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {

        $schoolinfo = SchoolInfo::first();

        //get the payment record
        $payment = Payment::with(['student'])->findOrFail($payment->id);


        return view('admin.pages.payments.edit', compact('schoolinfo', 'payment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        // Validate form data with unique constraint for reference except for the current payment
        $validated = $request->validate([
            'student_id'      => 'required|exists:students,id',
            'amount_paid'     => 'required|numeric|min:100',
            'purpose'         => 'required|string|max:255',
            'balance'         => 'required|numeric|min:0',
            'paid_by'         => 'required|string|max:255',
            'received_by'     => 'required|string|max:255',
            'payment_date'    => 'required|date',
            'payment_method'  => 'required|in:cash,bank,card',
            'status'          => 'required|in:paid,pending,failed',
            'notes'           => 'nullable|string',
            'receipt_number'  => 'nullable|string|max:255',
            'reference'       => 'nullable|string|max:255|unique:payments,reference,' . $payment->id,
            'session'         => 'nullable|string|max:255',
            'term'            => 'nullable|in:first,second,third'
        ]);

        // Use provided reference/receipt or keep old if not given
        $reference = $request->input('reference') ?: $payment->reference;
        $receipt_number = $request->input('receipt_number') ?: $payment->receipt_number;

        // Get school session and term if not supplied in form
        $schoolinfo = \App\Models\SchoolInfo::first();
        $session = $request->input('session') ?: ($schoolinfo->current_session ?? null);
        $term = $request->input('term') ?: ($schoolinfo->current_term ?? null);

        // Assign processed fields
        $validated['reference'] = $reference;
        $validated['receipt_number'] = $receipt_number;
        $validated['session'] = $session;
        $validated['term'] = $term;

        // Update payment
        $payment->update($validated);

        return redirect()->route('admin.payments.index')
            ->with('success', 'Payment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        // Delete the payment record
        $payment->delete();

        // Redirect back to payments index with success message
        return redirect()->route('admin.payments.index')->with('success', 'Payment deleted successfully.');
    }
}
