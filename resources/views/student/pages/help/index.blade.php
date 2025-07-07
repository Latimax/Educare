@extends('student.layouts.app')

@section('title', 'Help')

@push('styles')
    <style>

    </style>
@endpush

@section('content')

    <div class="faq1256" style="margin-bottom: 150px">
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

                            <div class="result_content text-center mt-4">
                                <p class="mb-4">Coming soon!!!</p>

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
