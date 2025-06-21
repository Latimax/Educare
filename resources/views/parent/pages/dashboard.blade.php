@extends('parent.layouts.app')

@section('title', 'Parent Dashboard')

@push('styles')
    <link href="{{ asset('adminpage/assets/css/main.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="dashboard-main-body">
        <!-- Header Section -->
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Parent Dashboard</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('parent.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Overview</li>
            </ul>
        </div>

        <!-- Status Message -->
        @if (session('status'))
            <div class="alert mx-4 alert-info my-4 bg-success-100 text-success-600 border-success-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-0 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between" role="alert">
                <div class="d-flex align-items-center gap-2">
                    <iconify-icon icon="mingcute:emoji-line" class="icon text-xl"></iconify-icon>
                    {{ session('status') }}
                </div>
                <button class="remove-button text-success-600 text-xxl line-height-1">
                    <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon>
                </button>
            </div>
        @endif

        <!-- System Statistics -->
        <div class="row gy-4">
            <div class="col-xxl-8">
                <div class="row gy-4">
                    <!-- Total Children -->
                    <div class="col-xxl-4 col-sm-6">
                        <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-1">
                            <div class="card-body p-0">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="mb-0 w-48-px h-48-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6">
                                            <iconify-icon icon="mingcute:user-2-fill" class="icon"></iconify-icon>
                                        </span>
                                        <div>
                                            <span class="mb-2 fw-medium text-secondary-light text-sm">Your Children</span>
                                            <h6 class="fw-semibold">{{ number_format($totalChildren) }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm mb-0">Enrolled Students</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Payments -->
                    <div class="col-xxl-4 col-sm-6">
                        <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-8">
                            <div class="card-body p-0">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="mb-0 w-48-px h-48-px bg-orange text-white flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                                            <iconify-icon icon="mdi:currency-ngn" class="icon"></iconify-icon>
                                        </span>
                                        <div>
                                            <span class="mb-2 fw-medium text-secondary-light text-sm">Total Payments</span>
                                            <h6 class="fw-semibold">{{ number_format($totalPayments) }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm mb-0">Amount: <span class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm">₦{{ number_format($totalPaymentAmount, 2) }}</span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Payments -->
                    <div class="col-xxl-4 col-sm-6">
                        <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-3">
                            <div class="card-body p-0">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="mb-0 w-48-px h-48-px bg-yellow text-white flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                                            <iconify-icon icon="mdi:clock-outline" class="icon"></iconify-icon>
                                        </span>
                                        <div>
                                            <span class="mb-2 fw-medium text-secondary-light text-sm">Pending Payments</span>
                                            <h6 class="fw-semibold">{{ number_format($pendingPayments) }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm mb-0">Payments Due</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Calendar Widget -->
            <div class="col-xxl-4">
                <div class="card h-100 radius-8 border-0">
                    <div class="card-body p-24">
                        <h6 class="mb-2 fw-bold text-lg">School Calendar</h6>
                        <div id="calendar" class="mt-3"></div>
                    </div>
                </div>
            </div>

            <!-- Children's Details -->
            <div class="col-xxl-12">
                <div class="card h-100">
                    <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center justify-content-between">
                        <h6 class="text-lg fw-semibold mb-0">Your Children</h6>
                    </div>
                    <div class="card-body p-24">
                        <div class="table-responsive scroll-sm">
                            <table class="table bordered-table mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Class</th>
                                        <th scope="col">Admission Date</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($children as $child)
                                        <tr>
                                            <td>{{ $child->full_name }}</td>
                                            <td>{{ $child->class_id ? $child->StudentClass->class_name : 'N/A' }}</td>
                                            <td>{{ $child->created_at->format('d M Y') }}</td>
                                            <td>
                                                <span class="px-24 py-4 rounded-pill fw-medium text-sm bg-success-focus text-success-main">
                                                    Active
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="col-xxl-12">
                <div class="card h-100">
                    <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center justify-content-between">
                        <h6 class="text-lg fw-semibold mb-0">Recent Transactions</h6>
                        <a href="javascript:void(0)" class="text-primary-600 hover-text-primary d-flex align-items-center gap-1">
                            View All
                            <iconify-icon icon="solar:alt-arrow-right-linear" class="icon"></iconify-icon>
                        </a>
                    </div>
                    <div class="card-body p-24">
                        <div class="table-responsive scroll-sm">
                            <table class="table bordered-table mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">Transaction ID</th>
                                        <th scope="col">Student</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentPayments as $payment)
                                        <tr>
                                            <td>{{ $payment->id }}</td>
                                            <td>{{ $payment->student ? $payment->student->full_name : 'N/A' }}</td>
                                            <td>{{ $payment->created_at->format('d M Y') }}</td>
                                            <td>
                                                <span class="px-24 py-4 rounded-pill fw-medium text-sm
                                                    {{ $payment->status == 'pending' ? 'bg-warning-focus text-warning-main' :
                                                       ($payment->status == 'paid' ? 'bg-success-focus text-success-main' : 'bg-danger-focus text-danger-main') }}">
                                                    {{ ucfirst($payment->status) }}
                                                </span>
                                            </td>
                                            <td>₦{{ number_format($payment->amount_paid, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('adminpage/assets/js/calendarmain.min.js') }}"></script>
    <script>
        // Alert Dismiss
        $('.remove-button').on('click', function() {
            $(this).closest('.alert').addClass('d-none');
        });

        // Calendar Initialization
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 'auto',
                events: [] // Add events dynamically if needed
            });
            calendar.render();
        });
    </script>
@endpush
