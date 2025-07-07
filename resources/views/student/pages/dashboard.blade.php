@extends('student.layouts.app')

@section('title', 'Student Dashboard')

@push('styles')
 <link href="{{ asset('studentpage/css/instructor-dashboard.css') }}" rel="stylesheet">
 <link href="{{ asset('studentpage/css/instructor-responsive.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="sa4d25">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="st_title"><i class="uil uil-apps"></i> Student Dashboard</h2>
                </div>

                <!-- Status Message -->
                @if (session('status'))
                    <div class="alert alert-success d-flex justify-content-between align-items-center px-4 py-3 mb-4">
                        <div><i class="uil uil-smile"></i> {{ session('status') }}</div>
                        <button class="btn btn-sm btn-link text-danger remove-button"><i class="uil uil-times"></i></button>
                    </div>
                @endif

                <!-- Stat Cards in card_dash style -->
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="card_dash">
                            <div class="card_dash_left">
                                <h5>Subjects Offered</h5>
                                <h2>{{ number_format($subjectCount) }}</h2>
                                <span class="crdbg_1">Total Subject{{ $subjectCount == 1 ? '' : 's' }}</span>
                            </div>
                            <div class="card_dash_right">
                                <img src="{{ asset('studentpage/images/dashboard/online-course.svg') }}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="card_dash">
                            <div class="card_dash_left">
                                <h5>Current Session</h5>
                                <h2>{{ $activeSession ?? 'None' }}</h2>
                                <span class="crdbg_2">Current</span>
                            </div>
                            <div class="card_dash_right">
                                <img src="{{ asset('studentpage/images/dashboard/promotion.svg') }}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="card_dash">
                            <div class="card_dash_left">
                                <h5>Active Term</h5>
                                <h2>{{ ucfirst($activeTerm) ?? 'None' }}</h2>
                                <span class="crdbg_3">Current</span>
                            </div>
                            <div class="card_dash_right">
                                <img src="{{ asset('studentpage/images/dashboard/knowledge.svg') }}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="card_dash">
                            <div class="card_dash_left">
                                <h5>Total Payments</h5>
                                <h2>{{ $payments->count() }}</h2>
                                <span class="crdbg_4">Payment{{ $payments->count() == 1 ? '' : 's' }}</span>
                            </div>
                            <div class="card_dash_right">
                                <img src="{{ asset('studentpage/images/dashboard/graduation-cap.svg') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment History Table -->
                <div class="table-responsive mt-30">
                    <table class="table ucp-table">
                        <thead class="thead-s">
                            <tr>
                                <th class="text-center" scope="col">Item No.</th>
                                <th class="cell-ta" scope="col">Reference</th>
                                <th class="cell-ta" scope="col">Amount</th>
                                <th class="cell-ta" scope="col">Purpose</th>
                                <th class="text-center" scope="col">Method</th>
                                <th class="text-center" scope="col">Status</th>
                                <th class="text-center" scope="col">Session</th>
                                <th class="text-center" scope="col">Term</th>
                                <th class="text-center" scope="col">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($payments as $index => $payment)
                                <tr>
                                    <td class="text-center">{{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}</td>
                                    <td class="cell-ta">{{ $payment->reference }}</td>
                                    <td class="cell-ta">₦{{ number_format($payment->amount_paid, 2) }}</td>
                                    <td class="cell-ta">{{ $payment->purpose }}</td>
                                    <td class="text-center">{{ ucfirst($payment->payment_method) }}</td>
                                    <td class="text-center">
                                        <span
                                            class="badge bg-{{ $payment->status === 'completed' ? 'success' : 'warning' }}">
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                    </td>
                                    <td class="text-center">{{ $payment->session }}</td>
                                    <td class="text-center">{{ $payment->term }}</td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No payment records available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script src="{{ asset('studentpage/js/custom1.js') }}"></script>
    <script>
        $('.remove-button').on('click', function() {
            $(this).closest('.alert').addClass('d-none');
        });
    </script>
@endpush
