@extends('student.layouts.app')

@section('title', 'CBT Test Instructions')

@push('styles')
    <link href="{{ asset('studentpage/css/instructor-dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('studentpage/css/instructor-responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('studentpage/vendor/jquery-ui-1.12.1/jquery-ui.css') }}" rel="stylesheet">

    <style>
        .instruction-card {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .start-btn {
            background-color: #AF1F24;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
        }

        .start-btn:hover {
            background-color: #ffffff;
            color: #AF1F24;
            border: 1px solid #AF1F24;
            text-decoration: none;
            transition: 0.4s ease;
        }

        .disabled-link {
            pointer-events: none;
            opacity: 0.5;
            cursor: not-allowed;
        }

        .test-details-card {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 15px;
            text-align: center;
        }

        .test-details-card strong {
            color: #333;
        }
    </style>
@endpush

@section('content')
    <div class="sa4d25">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">

                    <!-- Status Message -->
                    @if (session('status'))
                        <div class="alert alert-success d-flex justify-content-between align-items-center px-4 py-3 mb-4">
                            <div><i class="uil uil-smile"></i> {{ session('status') }}</div>
                            <button class="btn btn-sm btn-link text-danger remove-button"><i
                                    class="uil uil-times"></i></button>
                        </div>
                    @endif

                    <div class="instruction-card p-4 mb-5">
                        <div class="text-center mb-4">
                            <p class="text-muted">Computer-Based Test (CBT) Instructions</p>
                        </div>

                        <div class="mb-4">
                            <h4 class="fw-bold">Test Details</h4>
                            <div class="section3126 mt-20">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="test-details-card">
                                            <strong class="fw-bold">Student</strong><br>
                                            {{ $student->firstname }} {{ $student->lastname }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="test-details-card">
                                            <strong class="fw-bold">Subject</strong><br>
                                            {{ $subject->subject_name }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="test-details-card">
                                            <strong class="fw-bold">Test Type</strong><br>
                                            {{ ucfirst($type == 'ft' ? 'First Test' : ($type == 'st' ? 'Second Test' : 'Examination')) }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="test-details-card">
                                            <strong class="fw-bold">Number of Questions</strong><br>
                                            {{ $type == 'ft' ? $cbt_configs->ft_total_questions : ($type == 'st' ? $cbt_configs->st_total_questions : $cbt_configs->exam_total_questions) }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="test-details-card">
                                            <strong class="fw-bold">Time Limit</strong><br>
                                            {{ $cbt_configs->total_time }} minutes
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="test-details-card">
                                            <strong class="fw-bold">Attempts Allowed</strong><br>
                                            {{ $cbt_configs->attempts_allowed }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h4 class="fw-bold">Test Rules</h4>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">ℹ️ All questions are multiple-choice with options labeled
                                    <strong>A, B, C, D</strong>.
                                </li>
                                <li class="list-group-item">ℹ️ Ensure a stable internet connection throughout the test.</li>
                                <li class="list-group-item">ℹ️ Do not refresh or close the browser during the test.</li>
                                <li class="list-group-item"> ℹ️ Complete the test within the
                                    {{ $cbt_configs->total_time }}-minute time limit.</li>
                            </ul>
                        </div>

                        <div class="text-center">
                            <a href="{{ route('student.cbt.index') }}" class="btn btn-default steps_btn">Back</a>

                            @if (
                                $enable_exam &&
                                    (($type == 'ft' && $cbt_configs->ft_status == '1') ||
                                        ($type == 'st' && $cbt_configs->st_status == '1') ||
                                        ($type == 'exam' && $cbt_configs->exam_status == '1')))
                                <a href="{{ route('student.cbt.start', ['type' => $type, 'subject_id' => $subject->id]) }}"
                                    class="start-btn">
                                    Start Test
                                </a>
                            @else
                                <a href="#" class="start-btn disabled-link" tabindex="-1" aria-disabled="true">
                                    Start Test
                                </a>
                                @if (!$enable_exam)
                                    <p class="text-danger mt-2">
                                        Test cannot be started. Not enough questions are available for this subject.
                                    </p>
                                @else
                                    <p class="text-warning mt-2">
                                        Test is currently disabled by the administrator.
                                    </p>
                                @endif
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('studentpage/vendor/jquery-ui-1.12.1/jquery-ui.js') }}"></script>
@endpush
