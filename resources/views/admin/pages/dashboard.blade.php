@extends('admin.layouts.app')

@section('title', 'School Management Dashboard')

@push('styles')

    <link href="{{ asset('adminpage/assets/css/main.min.css') }}" rel="stylesheet">

@endpush
@section('content')
    <div class="dashboard-main-body">
        <!-- Header Section -->
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Admin Dashboard</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
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
                    <!-- Total Students -->
                    <div class="col-xxl-4 col-sm-6">
                        <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-1">
                            <div class="card-body p-0">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="mb-0 w-48-px h-48-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6">
                                            <iconify-icon icon="mingcute:user-2-fill" class="icon"></iconify-icon>
                                        </span>
                                        <div>
                                            <span class="mb-2 fw-medium text-secondary-light text-sm">Total Students</span>
                                            <h6 class="fw-semibold">{{ number_format($totalStudents) }}</h6>
                                        </div>
                                    </div>
                                    <div id="students-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                                </div>
                                <p class="text-sm mb-0">New this month: <span class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm">{{ $monthlyStudents }}</span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Staff -->
                    <div class="col-xxl-4 col-sm-6">
                        <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-2">
                            <div class="card-body p-0">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="mb-0 w-48-px h-48-px bg-success-main flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6">
                                            <iconify-icon icon="mdi:teacher" class="icon"></iconify-icon>
                                        </span>
                                        <div>
                                            <span class="mb-2 fw-medium text-secondary-light text-sm">Total Staff</span>
                                            <h6 class="fw-semibold">{{ number_format($totalStaff) }}</h6>
                                        </div>
                                    </div>
                                    <div id="staff-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                                </div>
                                <p class="text-sm mb-0">Active Staff</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Parents -->
                    <div class="col-xxl-4 col-sm-6">
                        <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-3">
                            <div class="card-body p-0">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="mb-0 w-48-px h-48-px bg-yellow text-white flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                                            <iconify-icon icon="mdi:account-group" class="icon"></iconify-icon>
                                        </span>
                                        <div>
                                            <span class="mb-2 fw-medium text-secondary-light text-sm">Total Parents</span>
                                            <h6 class="fw-semibold">{{ number_format($totalParents) }}</h6>
                                        </div>
                                    </div>
                                    <div id="parents-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                                </div>
                                <p class="text-sm mb-0">Registered Parents</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Classes -->
                    <div class="col-xxl-4 col-sm-6">
                        <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-4">
                            <div class="card-body p-0">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="mb-0 w-48-px h-48-px bg-purple text-white flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                                            <iconify-icon icon="mdi:school" class="icon"></iconify-icon>
                                        </span>
                                        <div>
                                            <span class="mb-2 fw-medium text-secondary-light text-sm">Total Classes</span>
                                            <h6 class="fw-semibold">{{ number_format($totalClasses) }}</h6>
                                        </div>
                                    </div>
                                    <div id="classes-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                                </div>
                                <p class="text-sm mb-0">Active Classes</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Levels -->
                    <div class="col-xxl-4 col-sm-6">
                        <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-5">
                            <div class="card-body p-0">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="mb-0 w-48-px h-48-px bg-pink text-white flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                                            <iconify-icon icon="mdi:stairs" class="icon"></iconify-icon>
                                        </span>
                                        <div>
                                            <span class="mb-2 fw-medium text-secondary-light text-sm">Total Levels</span>
                                            <h6 class="fw-semibold">{{ number_format($totalLevels) }}</h6>
                                        </div>
                                    </div>
                                    <div id="levels-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                                </div>
                                <p class="text-sm mb-0">Academic Levels</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Sessions -->
                    <div class="col-xxl-4 col-sm-6">
                        <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-6">
                            <div class="card-body p-0">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="mb-0 w-48-px h-48-px bg-cyan text-white flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                                            <iconify-icon icon="mdi:calendar" class="icon"></iconify-icon>
                                        </span>
                                        <div>
                                            <span class="mb-2 fw-medium text-secondary-light text-sm">Total Sessions</span>
                                            <h6 class="fw-semibold">{{ number_format($totalSessions) }}</h6>
                                        </div>
                                    </div>
                                    <div id="sessions-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                                </div>
                                <p class="text-sm mb-0">Active: {{ $activeSession ? $activeSession : 'None' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Subjects -->
                    <div class="col-xxl-4 col-sm-6">
                        <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-7">
                            <div class="card-body p-0">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="mb-0 w-48-px h-48-px bg-orange text-white flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                                            <iconify-icon icon="mdi:book-open-page-variant" class="icon"></iconify-icon>
                                        </span>
                                        <div>
                                            <span class="mb-2 fw-medium text-secondary-light text-sm">Total Subjects</span>
                                            <h6 class="fw-semibold">{{ number_format($totalSubjects) }}</h6>
                                        </div>
                                    </div>
                                    <div id="subjects-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                                </div>
                                <p class="text-sm mb-0">Offered Subjects</p>
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
                                    <div id="payments-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                                </div>
                                <p class="text-sm mb-0">Amount: <span class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm">₦{{ number_format($totalPaymentAmount, 2) }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Widgets Column (Calendar, Time, Date) -->
            <div class="col-xxl-4">
                <div class="row gy-4">
                    <!-- Calendar Widget -->
                    <div class="col-xxl-12 col-sm-6">
                        <div class="card h-100 radius-8 border-0">
                            <div class="card-body p-24">
                                <h6 class="mb-2 fw-bold text-lg">School Calendar</h6>
                                <div id="calendar" class="mt-3"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Time and Date Widget -->
                    <div class="col-xxl-12 col-sm-6">
                        <div class="card h-100 radius-8 border-0">
                            <div class="card-body p-24">
                                <h6 class="mb-2 fw-bold text-lg">Current Time & Date</h6>
                                <div class="mt-3 text-center">
                                    <p class="text-lg fw-semibold" id="current-time"></p>
                                    <p class="text-sm text-secondary-light">{{ now()->format('l, F j, Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="col-xxl-6">
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
                                                       ($payment->status == 'completed' ? 'bg-success-focus text-success-main' : 'bg-danger-focus text-danger-main') }}">
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

            <!-- Payment Statistics -->
            <div class="col-xxl-6">
                <div class="card h-100 radius-8 border-0">
                    <div class="card-body p-24">
                        <h6 class="mb-2 fw-bold text-lg">Payment Statistics</h6>
                        <div class="mt-20 d-flex justify-content-center flex-wrap gap-3">
                            <div class="d-inline-flex align-items-center gap-2 p-2 radius-8 border pe-36 br-hover-primary group-item">
                                <span class="bg-neutral-100 w-44-px h-44-px text-xxl radius-8 d-flex justify-content-center align-items-center text-secondary-light group-hover:bg-primary-600 group-hover:text-white">
                                    <iconify-icon icon="mdi:currency-ngn" class="icon"></iconify-icon>
                                </span>
                                <div>
                                    <span class="text-secondary-light text-sm fw-medium">Total Payments</span>
                                    <h6 class="text-md fw-semibold mb-0">{{ number_format($totalPayments) }}</h6>
                                </div>
                            </div>
                            <div class="d-inline-flex align-items-center gap-2 p-2 radius-8 border pe-36 br-hover-primary group-item">
                                <span class="bg-neutral-100 w-44-px h-44-px text-xxl radius-8 d-flex justify-content-center align-items-center text-secondary-light group-hover:bg-primary-600 group-hover:text-white">
                                    <iconify-icon icon="mdi:check-circle" class="icon"></iconify-icon>
                                </span>
                                <div>
                                    <span class="text-secondary-light text-sm fw-medium">Completed</span>
                                    <h6 class="text-md fw-semibold mb-0">{{ number_format($completedPayments) }}</h6>
                                </div>
                            </div>
                            <div class="d-inline-flex align-items-center gap-2 p-2 radius-8 border pe-36 br-hover-primary group-item">
                                <span class="bg-neutral-100 w-44-px h-44-px text-xxl radius-8 d-flex justify-content-center align-items-center text-secondary-light group-hover:bg-primary-600 group-hover:text-white">
                                    <iconify-icon icon="mdi:clock-outline" class="icon"></iconify-icon>
                                </span>
                                <div>
                                    <span class="text-secondary-light text-sm fw-medium">Pending</span>
                                    <h6 class="text-md fw-semibold mb-0">{{ number_format($pendingPayments) }}</h6>
                                </div>
                            </div>
                        </div>
                        <div id="payment-chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('adminpage/assets/js/homeTwoChart.js') }}"></script>
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

        // Real-time Clock
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('en-US', { hour12: true });
            document.getElementById('current-time').textContent = timeString;
        }
        setInterval(updateTime, 1000);
        updateTime();
    </script>
@endpush
