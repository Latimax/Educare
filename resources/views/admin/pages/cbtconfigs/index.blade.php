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


        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="card h-100">
                    <div class="card-body p-24">
                        <ul class="nav border-gradient-tab nav-pills mb-20 d-inline-flex" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button
                                    class="nav-link d-flex align-items-center px-24 {{ $activeTab == 'status' ? 'active' : '' }}"
                                    id="pills-cbt-status-tab" data-bs-toggle="pill" data-bs-target="#pills-cbt-status"
                                    type="button" role="tab" aria-controls="pills-cbt-status"
                                    aria-selected="{{ $activeTab == 'status' ? 'true' : 'false' }}">
                                    CBT Status
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button
                                    class="nav-link d-flex align-items-center px-24 {{ $activeTab == 'subjects' ? 'active' : '' }}"
                                    id="pills-subjects-tab" data-bs-toggle="pill" data-bs-target="#pills-subjects"
                                    type="button" role="tab" aria-controls="pills-subjects"
                                    aria-selected="{{ $activeTab == 'subjects' ? 'true' : 'false' }}" tabindex="-1">
                                    Subjects
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button
                                    class="nav-link d-flex align-items-center px-24 {{ $activeTab == 'other' ? 'active' : '' }}"
                                    id="pills-other-tab" data-bs-toggle="pill" data-bs-target="#pills-other" type="button"
                                    role="tab" aria-controls="pills-other"
                                    aria-selected="{{ $activeTab == 'other' ? 'true' : 'false' }}" tabindex="-1">
                                    Other
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                            <!-- CBT Status Tab -->
                            <div class="tab-pane fade {{ $activeTab == 'status' ? 'show active' : '' }}"
                                id="pills-cbt-status" role="tabpanel" aria-labelledby="pills-cbt-status-tab" tabindex="0">
                                <form action="{{ route('admin.cbtconfig.update', $cbt_config->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="mb-20">
                                                <label for="ft_status"
                                                    class="form-label fw-semibold text-primary-light text-sm mb-8">
                                                    First Test Status <span class="text-danger-600">*</span>
                                                </label>
                                                <select name="ft_status"
                                                    class="form-control radius-8 @error('ft_status') is-invalid @enderror"
                                                    id="ft_status">
                                                    <option value="1"
                                                        {{ old('ft_status', $cbt_config->ft_status ?? '') == '1' ? 'selected' : '' }}>
                                                        Active</option>
                                                    <option value="0"
                                                        {{ old('ft_status', $cbt_config->ft_status ?? '') == '0' ? 'selected' : '' }}>
                                                        Disable</option>
                                                </select>
                                                @error('ft_status')
                                                    <span class="text-danger text-sm">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="mb-20">
                                                <label for="st_status"
                                                    class="form-label fw-semibold text-primary-light text-sm mb-8">
                                                    Second Test Status <span class="text-danger-600">*</span>
                                                </label>
                                                <select name="st_status"
                                                    class="form-control radius-8 @error('st_status') is-invalid @enderror"
                                                    id="st_status">
                                                    <option value="1"
                                                        {{ old('st_status', $cbt_config->st_status ?? '') == '1' ? 'selected' : '' }}>
                                                        Active</option>
                                                    <option value="0"
                                                        {{ old('st_status', $cbt_config->st_status ?? '') == '0' ? 'selected' : '' }}>
                                                        Disable</option>
                                                </select>
                                                @error('st_status')
                                                    <span class="text-danger text-sm">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="mb-20">
                                                <label for="exam_status"
                                                    class="form-label fw-semibold text-primary-light text-sm mb-8">
                                                    Exam Status <span class="text-danger-600">*</span>
                                                </label>
                                                <select name="exam_status"
                                                    class="form-control radius-8 @error('exam_status') is-invalid @enderror"
                                                    id="exam_status">
                                                    <option value="1"
                                                        {{ old('exam_status', $cbt_config->exam_status ?? '') == '1' ? 'selected' : '' }}>
                                                        Active</option>
                                                    <option value="0"
                                                        {{ old('exam_status', $cbt_config->exam_status ?? '') == '0' ? 'selected' : '' }}>
                                                        Disable</option>
                                                </select>
                                                @error('exam_status')
                                                    <span class="text-danger text-sm">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Additional Fields -->
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="mb-20">
                                                <label for="total_time"
                                                    class="form-label fw-semibold text-primary-light text-sm mb-8">
                                                    Total Time (minutes)
                                                </label>
                                                <input type="number" name="total_time" id="total_time"
                                                    class="form-control radius-8"
                                                    value="{{ old('total_time', $cbt_config->total_time ?? '') }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="mb-20">
                                                <label for="attempts_allowed"
                                                    class="form-label fw-semibold text-primary-light text-sm mb-8">
                                                    Attempts Allowed
                                                </label>
                                                <input type="number" name="attempts_allowed" id="attempts_allowed"
                                                    class="form-control radius-8"
                                                    value="{{ old('attempts_allowed', $cbt_config->attempts_allowed ?? '') }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="mb-20">
                                                <label for="ft_total_questions"
                                                    class="form-label fw-semibold text-primary-light text-sm mb-8">
                                                    First Test Total Questions
                                                </label>
                                                <input type="number" name="ft_total_questions" id="ft_total_questions"
                                                    class="form-control radius-8"
                                                    value="{{ old('ft_total_questions', $cbt_config->ft_total_questions ?? '') }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="mb-20">
                                                <label for="st_total_questions"
                                                    class="form-label fw-semibold text-primary-light text-sm mb-8">
                                                    Second Test Total Questions
                                                </label>
                                                <input type="number" name="st_total_questions" id="st_total_questions"
                                                    class="form-control radius-8"
                                                    value="{{ old('st_total_questions', $cbt_config->st_total_questions ?? '') }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="mb-20">
                                                <label for="exam_total_questions"
                                                    class="form-label fw-semibold text-primary-light text-sm mb-8">
                                                    Exam Total Questions
                                                </label>
                                                <input type="number" name="exam_total_questions"
                                                    id="exam_total_questions" class="form-control radius-8"
                                                    value="{{ old('exam_total_questions', $cbt_config->exam_total_questions ?? '') }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="mb-20">
                                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                                                    Shuffle Questions
                                                </label>
                                                <div class="form-check form-switch d-flex align-items-center gap-2">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="shuffle_questions" id="shuffle_questions"
                                                        {{ old('shuffle_questions', $cbt_config->shuffle_questions ?? false) ? 'checked' : '' }}>
                                                    <span class="ms-2"><span class="badge bg-secondary">Off</span> /
                                                        <span class="badge bg-success">On</span></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="mb-20">
                                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                                                    Shuffle Answers
                                                </label>
                                                <div class="form-check form-switch d-flex align-items-center gap-2">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="shuffle_answers" id="shuffle_answers"
                                                        {{ old('shuffle_answers', $cbt_config->shuffle_answers ?? false) ? 'checked' : '' }}>
                                                    <span class="ms-2"><span class="badge bg-secondary">Off</span> /
                                                        <span class="badge bg-success">On</span></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="mb-20">
                                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                                                    Show Correct Answers
                                                </label>
                                                <div class="form-check form-switch d-flex align-items-center gap-2">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="show_correct_answers" id="show_correct_answers"
                                                        {{ old('show_correct_answers', $cbt_config->show_correct_answers ?? false) ? 'checked' : '' }}>
                                                    <span class="ms-2"><span class="badge bg-secondary">Off</span> /
                                                        <span class="badge bg-success">On</span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center gap-3">
                                        <a href="{{ route('admin.dashboard') }}"
                                            class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8">
                                            Cancel
                                        </a>
                                        <button type="submit"
                                            class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8">
                                            Save
                                        </button>
                                    </div>

                                </form>
                            </div>

                            <!-- Subjects Tab -->
                            <div class="tab-pane fade {{ $activeTab == 'subjects' ? 'show active' : '' }}"
                                id="pills-subjects" role="tabpanel" aria-labelledby="pills-subjects-tab" tabindex="0">
                                <form action="" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="row align-content-center justify-content-between">
                                        <!-- Junior Subjects -->

                                        <div class="col-sm-5 border-1 p-24 mr-2 radius-8">
                                            <h6 class="text-md text-primary-light mb-16">Junior Subjects <span
                                                    class="badge bg-info"> {{ count($junior_subjects) }}</span></h6>
                                            <hr>
                                            @foreach ($junior_subjects as $subject)
                                                <div class="mb-20 d-flex align-items-center justify-content-between">
                                                    <label for="junior_subject_{{ $subject->id }}"
                                                        class="form-label fw-semibold text-primary-light text-sm">
                                                        {{ $subject->subject_name }}
                                                    </label>

                                                    <div
                                                        class="switch-primary form-switch d-flex align-items-center gap-2">
                                                        <span class="badge bg-danger">Off</span>
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                            name="junior_subjects[{{ $subject->id }}]"
                                                            id="junior_subject_{{ $subject->id }}" data-subject-toggle
                                                            data-subject-id="{{ $subject->id }}"
                                                            data-subject-type="junior"
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
                                                    <div
                                                        class="switch-primary form-switch d-flex align-items-center gap-2">
                                                        <span class="badge bg-danger">Off</span>
                                                        <input class="form-check-input" type="checkbox"
                                                            name="senior_subjects[{{ $subject->id }}]"
                                                            id="senior_subject_{{ $subject->id }}" data-subject-toggle
                                                            data-subject-id="{{ $subject->id }}"
                                                            data-subject-type="senior"
                                                            {{ $subject->status == 'active' ? 'checked' : '' }}>
                                                        <span class="badge bg-success">On</span></span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </form>
                            </div>

                            <!-- Other Tab -->
                            <div class="tab-pane fade {{ $activeTab == 'other' ? 'show active' : '' }}" id="pills-other"
                                role="tabpanel" aria-labelledby="pills-other-tab" tabindex="0">
                                <form action="{{ route('admin.cbtconfig.updatescore') }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="table-responsive">
                                        <table class="table table-bordered radius-8">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="text-primary-light text-sm fw-semibold">Level Name</th>
                                                    <th class="text-primary-light text-sm fw-semibold">First Test Min Score
                                                    </th>
                                                    <th class="text-primary-light text-sm fw-semibold">Second Test Min
                                                        Score</th>
                                                    <th class="text-primary-light text-sm fw-semibold">Exam Min Score</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($levels as $level)
                                                    <tr>
                                                        <td class="align-middle">
                                                            <span class="fw-medium">{{ $level->level_name }}</span>
                                                        </td>
                                                        <td>
                                                            <input type="number"
                                                                name="ft_min_score[{{ $level->id }}]"
                                                                class="form-control radius-8"
                                                                value="{{ old('ft_min_score.' . $level->id, $level->ft_min_score ?? '') }}"
                                                                min="0" max="100" placeholder="Enter score">
                                                        </td>
                                                        <td>
                                                            <input type="number"
                                                                name="st_min_score[{{ $level->id }}]"
                                                                class="form-control radius-8"
                                                                value="{{ old('st_min_score.' . $level->id, $level->st_min_score ?? '') }}"
                                                                min="0" max="100" placeholder="Enter score">
                                                        </td>
                                                        <td>
                                                            <input type="number"
                                                                name="exam_min_score[{{ $level->id }}]"
                                                                class="form-control radius-8"
                                                                value="{{ old('exam_min_score.' . $level->id, $level->exam_min_score ?? '') }}"
                                                                min="0" max="100" placeholder="Enter score">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-center gap-3 mt-3">
                                        <a href="{{ route('admin.dashboard') }}"
                                            class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8">
                                            Cancel
                                        </a>
                                        <button type="submit"
                                            class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8">
                                            Save
                                        </button>
                                    </div>
                                </form>
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
