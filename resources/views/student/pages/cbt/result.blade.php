@extends('student.layouts.app')

@section('title', 'Test Result')

@push('styles')
    <style>
        body {
            overflow-x: hidden;
            overflow-y: auto;
        }

    </style>
@endpush

@section('content')

    <div class="faq1256">
        <div class="container">
             <!-- Status Message -->
                @if (session('success'))
                    <div class="alert alert-success d-flex justify-content-between align-items-center px-4 py-3 mb-4">
                        <div><i class="uil uil-smile"></i> {{ session('success') }}</div>
                        <button class="btn btn-sm btn-link text-danger remove-button"><i class="uil uil-times"></i></button>
                    </div>
                    {{ session()->forget('success') }}
                @endif
            <div class="row justify-content-md-center">
                <div class="col-md-8">
                    <div class="certi_form rght1528">
                        <div class="test_result_bg">
                            <ul class="test_result_left">
                                <li>
                                    <div class="result_dt">
                                        <i class="uil uil-check right_ans"></i>
                                        <p>Correct<span>({{ $correct }})</span></p>
                                    </div>
                                </li>
                                <li>
                                    <div class="result_dt">
                                        <i class="uil uil-times wrong_ans"></i>
                                        <p>Wrong<span>({{ $wrong }})</span></p>
                                    </div>
                                </li>
                                <li>
                                    <div class="result_dt">
                                        <h4 class="fw-bold">{{ $score }}</h4>
                                        <p>Out of {{ $total_questions < 20 ? 20 : $total_questions }}</p>
                                    </div>
                                </li>
                            </ul>
                            <div class="result_content text-center mt-4">
                                <h2>Congratulations, {{ Auth::guard('student')->user()->firstname }}!</h2>
                                <p class="mb-4">You have completed the test</p>
                                <p class="mb-4 fw-bold ">Your score is: <span class="text-danger"> {{ $score }} </span> </p>



                                <div class="mt-4">
                                    <a href="{{ route('student.dashboard') }}" class="btn btn-secondary">
                                        <i class="uil uil-estate"></i> Return to Dashboard
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
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
