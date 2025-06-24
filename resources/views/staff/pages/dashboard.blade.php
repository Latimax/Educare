@extends('staff.layouts.app')

@section('title', 'Staff Dashboard')

@push('styles')
    <link href="{{ asset('adminpage/assets/css/main.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="dashboard-main-body">
        <!-- Header Section -->
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Staff Dashboard</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('staff.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
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
                                </div>
                                <p class="text-sm mb-0">Enrolled Students</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Classes -->
                    <div class="col-xxl-4 col-sm-6">
                        <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-2">
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
                                </div>
                                <p class="text-sm mb-0">Active Classes</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Subjects -->
                    <div class="col-xxl-4 col-sm-6">
                        <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-3">
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
                                </div>
                                <p class="text-sm mb-0">Offered Subjects</p>
                            </div>
                        </div>
                    </div>

                    <!-- Active Session -->
                    <div class="col-xxl-4 col-sm-6">
                        <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-4">
                            <div class="card-body p-0">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="mb-0 w-48-px h-48-px bg-cyan text-white flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                                            <iconify-icon icon="mdi:calendar" class="icon"></iconify-icon>
                                        </span>
                                        <div>
                                            <span class="mb-2 fw-medium text-secondary-light text-sm">Active Session</span>
                                            <h6 class="fw-semibold">{{ $activeSession ? $activeSession : 'None' }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm mb-0">Current Academic Session</p>
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
