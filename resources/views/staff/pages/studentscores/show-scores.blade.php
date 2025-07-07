@extends('staff.layouts.app')

@section('title', 'Student Scores')

@push('styles')
    <link rel="stylesheet" href="{{ asset('adminpage/assets/css/lib/toastr.min.css') }}">
@endpush

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Student Scores</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('staff.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Student Scores</li>
            </ul>
        </div>

        <div class="card basic-data-table">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Scores for {{ $subject->subject_name }} - {{ $class->class_name }} ({{ ucfirst($term) }} {{ $session }})</h5>
                <h5 class="card-title mb-0">
                    <div class="row">
                        <div class="col-12 mb-20">
                            <a href="{{ route('staff.studentscores.subjects', ['level' => $class->level_id, 'classId' => $class->id]) }}"
                                class="btn btn-outline-primary-600 radius-8 px-20 py-11 d-flex align-items-center gap-2">
                                <iconify-icon icon="icons8:left-round" class="text-xl"></iconify-icon> Back
                            </a>
                        </div>
                    </div>
                </h5>
            </div>

            @if (session('success'))
                <div class="alert alert-success my-4 bg-success-100 text-success-600 border-success-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-0 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between"
                    role="alert">
                    <div class="d-flex align-items-center gap-2">
                        <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
                        {{ session('success') }}
                    </div>
                    <button class="remove-button text-success-600 text-xxl line-height-1">
                        <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon>
                    </button>
                </div>
            @endif

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table bordered-table mb-0" id="dataTable" data-page-length='10'>
                        <thead>
                            <tr>
                                <th scope="col">
                                    <div class="form-check style-check d-flex align-items-center">
                                        <input class="form-check-input" type="checkbox">
                                        <label class="form-check-label"> S.L </label>
                                    </div>
                                </th>
                                <th scope="col">Student Name</th>
                                <th scope="col">First Test</th>
                                <th scope="col">Second Test</th>
                                <th scope="col">Exam</th>
                                <th scope="col">Exam Inc</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $index => $student)
                                @php
                                    $score = $scores->firstWhere('student_id', $student->id);
                                @endphp
                                <tr>
                                    <td>
                                        <div class="form-check style-check d-flex align-items-center">
                                            <input class="form-check-input" type="checkbox">
                                            <label class="form-check-label">{{ $index + 1 }}</label>
                                        </div>
                                    </td>
                                    <td>{{ $student->firstname }} {{ $student->middlename }} {{ $student->lastname }}</td>
                                    <td>
                                        <input type="number" class="form-control score-input" name="first_test"
                                            data-student-id="{{ $student->id }}"
                                            value="{{ $score->first_test ?? '' }}"
                                            min="{{ $class->level->ft_min_score ?? 0 }}"
                                            max="{{ $class->level->ft_max_score ?? 20 }}"
                                            data-max="{{ $class->level->ft_max_score ?? 20 }}">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control score-input" name="second_test"
                                            data-student-id="{{ $student->id }}"
                                            value="{{ $score->second_test ?? '' }}"
                                            min="{{ $class->level->st_min_score ?? 0 }}"
                                            max="{{ $class->level->st_max_score ?? 20 }}"
                                            data-max="{{ $class->level->st_max_score ?? 20 }}">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control score-input" name="exam"
                                            data-student-id="{{ $student->id }}"
                                            value="{{ $score->exam ?? '' }}"
                                            min="{{ $class->level->exam_min_score ?? 0 }}"
                                            max="{{ $class->level->exam_max_score ?? 60 }}"
                                            data-max="{{ $class->level->exam_max_score ?? 60 }}"
                                            data-original="{{ $score->exam ?? 0 }}"
                                            readonly>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control score-input" name="exam_inc"
                                            data-student-id="{{ $student->id }}"
                                            value="{{ $score->exam_inc ?? '' }}"
                                            min="-20" max="40" data-max="40">
                                    </td>
                                    <td>
                                        <button class="btn btn-success update-scores-btn d-flex align-items-center gap-2"
                                            data-student-id="{{ $student->id }}"
                                            data-subject-id="{{ $subject->id }}"
                                            data-class-id="{{ $class->id }}">
                                            <iconify-icon icon="mdi:content-save" class="text-lg"></iconify-icon> Update
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('adminpage/assets/js/lib/toastr.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            let table = new DataTable('#dataTable');

            // Remove alert
            $('.remove-button').on('click', function() {
                $(this).closest('.alert').addClass('d-none');
            });

            // Configure toastr
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "3000"
            };

            // Live update exam score based on exam_inc
            $(document).on('input', 'input[name="exam_inc"]', function() {
                let row = $(this).closest('tr');
                let base = parseFloat(row.find('input[name="exam"]').attr('data-original')) || 0;
                let inc = parseFloat($(this).val()) || 0;
                let maxExam = parseFloat(row.find('input[name="exam"]').attr('data-max')) || 60;

                if (inc > 40) {
                    toastr.error('Exam increment cannot exceed 40');
                    $(this).val(40);
                    inc = 40;
                }

                let total = base + inc;
                if (total > 100) {
                    toastr.error('Total exam score cannot exceed 100');
                    $(this).val(100 - base);
                    total = 100;
                }

                row.find('input[name="exam"]').val(total);
            });

            // Client-side validation for score inputs
            $(document).on('blur', '.score-input', function() {
                let max = parseFloat($(this).attr('data-max')) || 100;
                let value = parseFloat($(this).val()) || 0;
                let min = parseFloat($(this).attr('min')) || 0;

                if (value > max) {
                    toastr.error(`The ${$(this).attr('name')} score cannot exceed ${max}`);
                    $(this).val(max);
                } else if (value < min) {
                    toastr.error(`The ${$(this).attr('name')} score cannot be less than ${min}`);
                    $(this).val(min);
                }
            });

            // Handle update scores
            $('.update-scores-btn').on('click', function() {
                let button = $(this);
                let studentId = button.data('student-id');
                let subjectId = button.data('subject-id');
                let classId = button.data('class-id');
                let row = button.closest('tr');

                // Validate inputs before submission
                let isValid = true;
                row.find('.score-input').each(function() {
                    let value = parseFloat($(this).val()) || 0;
                    let max = parseFloat($(this).attr('data-max')) || 100;
                    let min = parseFloat($(this).attr('min')) || 0;
                    let name = $(this).attr('name');

                    if (value > max) {
                        toastr.error(`The ${name} score cannot exceed ${max}`);
                        isValid = false;
                    } else if (value < min) {
                        toastr.error(`The ${name} score cannot be less than ${min}`);
                        isValid = false;
                    }
                });

                if (!isValid) {
                    return;
                }

                let scores = {
                    first_test: row.find('input[name="first_test"]').val(),
                    second_test: row.find('input[name="second_test"]').val(),
                    exam: row.find('input[name="exam"]').val(),
                    exam_inc: row.find('input[name="exam_inc"]').val(),
                    student_id: studentId,
                    subject_id: subjectId,
                    class_id: classId,
                    term: '{{ $term }}',
                    session: '{{ $session }}'
                };

                $.ajax({
                    url: "{{ route('staff.studentscores.scores.update') }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: scores,
                    success: function(response) {
                        toastr.success('Scores updated successfully!');
                        row.find('input[name="exam"]').attr('data-original', row.find('input[name="exam"]').val());
                        row.find('input[name="exam_inc"]').val(0); // Reset increment
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            for (const key in errors) {
                                toastr.error(errors[key][0]);
                            }
                        } else {
                            toastr.error('Failed to update scores. Please try again.');
                        }
                    }
                });
            });

            // Show success notification if present
            @if (session('success'))
                toastr.success('{{ session('success') }}');
            @endif
        });
    </script>
@endpush
