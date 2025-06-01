{{-- resources/views/admin/pages/cbt-configuration.blade.php --}}

@extends('admin.layouts.app')

@section('title', 'CBT Configuration | Settings')

@php
    // Check if the request has an 'activeTab' parameter or if there are errors in the CBT status fields
    $cbtStatusError = $errors->has('ft_status') || $errors->has('st_status') || $errors->has('exam_status');
    // Default to 'status' unless the request indicates another tab or there are CBT status errors

    $activeTab = session('activeTab') ? session('activeTab') : ($cbtStatusError ? 'status' : 'status');
@endphp

@push('styles')
    <link rel="stylesheet" href="{{ asset('adminpage/assets/css/lib/toastr.min.css') }}">
@endpush

@section('content')

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">CBT Configuration</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">CBT Configuration</li>
            </ul>
        </div>

        @if (session('success'))
            <div class="alert alert-info my-4 bg-success-100 text-success-600 border-success-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-0 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between"
                role="alert">
                <div class="d-flex align-items-center gap-2">
                    <iconify-icon icon="mingcute:emoji-line" class="icon text-xl"></iconify-icon>
                    {{ session('success') }}
                </div>
                <button class="remove-button text-success-600 text-xxl line-height-1">
                    <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon>
                </button>
            </div>
        @endif


        <div class="card basic-data-table">
           <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">All Subjects</h5>

            </div>

            <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card h-100">
                                <div class="row align-content-center justify-content-between">
                                    <!-- Junior Subjects -->

                                    <div class="col-sm-5 border-1 p-24 mr-2 radius-8">
                                        <h6 class="text-md text-primary-light mb-16">Junior Subjects <span
                                                class="badge bg-info">
                                                {{ count($junior_subjects) }}</span></h6>
                                        <hr>
                                        @foreach ($junior_subjects as $subject)
                                            <div class="mb-20 d-flex align-items-center justify-content-between">
                                                <label for="junior_subject_{{ $subject->id }}"
                                                    class="form-label fw-semibold text-primary-light text-sm">
                                                    {{ $subject->subject_name }}
                                                </label>

                                                <div class="switch-primary form-switch d-flex align-items-center gap-2">
                                                    <span class="badge bg-danger">Off</span>
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        name="junior_subjects[{{ $subject->id }}]"
                                                        id="junior_subject_{{ $subject->id }}" data-subject-toggle
                                                        data-subject-id="{{ $subject->id }}" data-subject-type="junior"
                                                        {{ $subject->status == 'active' ? 'checked' : '' }}>
                                                    <span class="badge bg-success">On</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <!-- Senior Subjects -->
                                    <div class="col-sm-5 border-1 p-24 radius-8">
                                        <h6 class="text-md text-primary-light mb-16">Senior Subjects <span
                                                class="badge bg-primary">{{ count($senior_subjects) }}</span></h6>
                                        <hr>
                                        @foreach ($senior_subjects as $subject)
                                            <div class="mb-20 d-flex align-items-center justify-content-between">
                                                <label for="senior_subject_{{ $subject->id }}"
                                                    class="form-label fw-semibold text-primary-light text-sm">
                                                    {{ $subject->subject_name }}
                                                </label>
                                                <div class="switch-primary form-switch d-flex align-items-center gap-2">
                                                    <span class="badge bg-danger">Off</span>
                                                    <input class="form-check-input" type="checkbox"
                                                        name="senior_subjects[{{ $subject->id }}]"
                                                        id="senior_subject_{{ $subject->id }}" data-subject-toggle
                                                        data-subject-id="{{ $subject->id }}" data-subject-type="senior"
                                                        {{ $subject->status == 'active' ? 'checked' : '' }}>
                                                    <span class="badge bg-success">On</span></span>
                                                </div>
                                            </div>
                                        @endforeach
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
    <script src="{{ asset('adminpage/assets/js/lib/toastr.min.js') }}"></script>
    <script>
        $('.remove-button').on('click', function() {
            $(this).closest('.alert').addClass('d-none')
        });

        // AJAX toggle for subject status
        $(document).on('change', '.form-check-input[data-subject-toggle]', function() {

            var checkbox = $(this);
            var subjectId = checkbox.data('subject-id');
            var isChecked = checkbox.is(':checked') ? "active" : "disabled";

            $.ajax({
                url: '/admin/cbtconfig/subject-toggle',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    subject_id: subjectId,
                    active: isChecked
                },
                success: function(response) {
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "positionClass": "toast-top-right",
                        "timeOut": "3000"
                    };
                    toastr.success(response.message || 'Status updated successfully!');
                },
                error: function(xhr) {
                    alert('Failed to update status. Please try again.');
                }
            });
        });
    </script>
@endpush
