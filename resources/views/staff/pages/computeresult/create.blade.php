@extends('staff.layouts.app')

@section('title', 'Create Student Result')

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Student Results</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('staff.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Create Result</li>
            </ul>
        </div>

        <div class="card basic-data-table">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Create Student Result</h5>
                <a href="{{ route('staff.studentresults.filter', $class->id) }}"
                    class="btn btn-outline-primary-600 radius-8 px-20 py-11 d-flex align-items-center gap-2">
                    <iconify-icon icon="icons8:left-round" class="text-xl"></iconify-icon> Back
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success my-4 bg-success-100 text-success-600 border-success-600 border-start-width-4-px px-24 py-13 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between"
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

            @if ($errors->any())
                <div class="alert alert-danger my-4 bg-danger-100 text-danger-600 border-danger-600 border-start-width-4-px px-24 py-13 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between"
                    role="alert">
                    <div class="d-flex align-items-center gap-2">
                        <iconify-icon icon="akar-icons:alert" class="icon text-xl"></iconify-icon>
                        Please correct the errors below.
                    </div>
                    <button class="remove-button text-danger-600 text-xxl line-height-1">
                        <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon>
                    </button>
                </div>
            @endif

            <div class="card-body">
                <form action="{{ route('staff.studentresults.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- First Row: Class, Student, Total Time School Open, Total Time Present -->
                    <div class="row">
                        <div class="col-sm-3 mb-20">
                            <label for="class_id" class="form-label">Class <span class="text-danger">*</span></label>
                            <input type="text" class="form-control"
                                value="{{ $class->class_name ?? ($class->name ?? 'Class ' . $class->id) }}" readonly>
                            <input type="hidden" name="class_id" value="{{ $class->id }}">
                            @error('class_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-3 mb-20">
                            <label for="student_id" class="form-label">Student <span class="text-danger">*</span></label>
                            <select name="student_id" id="student_id"
                                class="form-select @error('student_id') is-invalid @enderror">
                                <option value="">-- Select Student --</option>
                                @foreach ($students as $student)
                                    <option value="{{ $student->id }}"
                                        {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                        {{ $student->firstname }} {{ $student->lastname }} {{ $student->middlename }}
                                    </option>
                                @endforeach
                            </select>
                            @error('student_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-3 mb-20">
                            <label for="school_opened" class="form-label">Total Time School Open</label>
                            <input type="text" class="form-control" value="{{ $schoolinfo->school_opened }}" readonly>
                            <input type="hidden" name="school_opened" value="{{ $schoolinfo->school_opened }}">
                            @error('school_opened')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-3 mb-20">
                            <label for="total_time_present" class="form-label">Total Time Present <span
                                    class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('total_time_present') is-invalid @enderror"
                                name="total_time_present" value="{{ old('total_time_present', 0) }}"
                                placeholder="Enter days present">
                            @error('total_time_present')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Second Row: Current Term, Current Session -->
                    <div class="row">
                        <div class="col-sm-6 mb-20">
                            <label for="term" class="form-label">Current Term</label>
                            <input type="text" class="form-control" value="{{ ucfirst($schoolinfo->current_term) }}"
                                readonly>
                            <input type="hidden" name="term" value="{{ $schoolinfo->current_term }}">
                            @error('term')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-6 mb-20">
                            <label for="session" class="form-label">Current Session</label>
                            <input type="text" class="form-control" value="{{ $schoolinfo->current_session }}" readonly>
                            <input type="hidden" name="session" value="{{ $schoolinfo->current_session }}">
                            @error('session')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Subjects Table -->
                    <h6 class="mb-3 mt-4">Subject Scores</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>First Test</th>
                                    <th>Second Test</th>
                                    <th>Exam</th>
                                    <th>Total</th>
                                    <th>Grade</th>
                                    <th>Offer Subject</th>
                                </tr>
                            </thead>
                            <tbody id="subject-scores">
                                @foreach ($subjects as $subject)
                                    <tr class="subject-row" data-subject-id="{{ $subject->id }}">
                                        <td>{{ $subject->subject_name }}</td>
                                        <td>
                                            <input type="number" class="form-control first-test"
                                                name="scores[{{ $subject->id }}][first_test]"
                                                min="{{ $level_config->ft_min_score ?? 0 }}" max="{{ $level_config->ft_max_score ?? 0 }}"
                                                value="{{ old('scores.' . $subject->id . '.first_test', 0) }}">
                                            @error('scores.' . $subject->id . '.first_test')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="number" class="form-control second-test"
                                                name="scores[{{ $subject->id }}][second_test]"
                                                min="{{ $level_config->st_min_score ?? 0 }}" max="{{ $level_config->st_max_score ?? 0 }}"
                                                value="{{ old('scores.' . $subject->id . '.second_test', 0) }}">
                                            @error('scores.' . $subject->id . '.second_test')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="number" class="form-control exam"
                                                name="scores[{{ $subject->id }}][exam]"
                                                min="{{ $level_config->exam_min_score ?? 0 }}" max="{{ $level_config->exam_max_score ?? 0 }}"
                                                value="{{ old('scores.' . $subject->id . '.exam', 0) }}">
                                            @error('scores.' . $subject->id . '.exam')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="text" class="form-control total"
                                                name="scores[{{ $subject->id }}][total]" readonly
                                                value="{{ old('scores.' . $subject->id . '.total', 0) }}"
                                                max="100">
                                            @error('scores.' . $subject->id . '.total')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="text" class="form-control grade"
                                                name="scores[{{ $subject->id }}][grade]" readonly
                                                value="{{ old('scores.' . $subject->id . '.grade') }}">
                                            @error('scores.' . $subject->id . '.grade')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="checkbox" class="form-check-input offer-subject"
                                                name="scores[{{ $subject->id }}][offer]"
                                                {{ old('scores.' . $subject->id . '.offer', 1) ? 'checked' : '' }}>
                                            @error('scores.' . $subject->id . '.offer')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Overall Totals -->
                    <div class="row mt-4">
                        <div class="col-sm-3 mb-20">
                            <label class="form-label">First Test Total</label>
                            <input type="text" class="form-control" id="first_test_total" readonly
                                value="{{ old('first_test_total', 0) }}">
                            @error('first_test_total')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-3 mb-20">
                            <label class="form-label">Second Test Total</label>
                            <input type="text" class="form-control" id="second_test_total" readonly
                                value="{{ old('second_test_total', 0) }}">
                            @error('second_test_total')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-3 mb-20">
                            <label class="form-label">Exam Total</label>
                            <input type="text" class="form-control" id="exam_total" readonly
                                value="{{ old('exam_total', 0) }}">
                            @error('exam_total')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-3 mb-20">
                            <label class="form-label">Overall Total</label>
                            <input type="text" name="overall_total" class="form-control" id="overall_total" readonly
                                value="{{ old('overall_total', 0) }}">
                            @error('overall_total')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Psychomotor and Effective Area Tables -->
                    <h6 class="mb-3 mt-4">Psychomotor and Effective Areas</h6>
                    <div class="row">
                        <div class="col-sm-6 mb-20">
                            <h6>Psychomotor</h6>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Psychomotor</th>
                                        <th>Excellent</th>
                                        <th>Good</th>
                                        <th>Fair</th>
                                        <th>Poor</th>
                                        <th>V.Poor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (['handwriting', 'verbal', 'sports', 'drawing', 'craftwork'] as $index => $field)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ ucwords(str_replace('_', ' ', $field)) }}</td>
                                            @foreach (['excellent', 'good', 'fair', 'poor', 'v_poor'] as $value)
                                                <td>
                                                    <input type="radio"
                                                        name="{{ $field }}[{{ $field }}]"
                                                        value="{{ $value }}" class="form-check-input"
                                                        {{ old($field . '.' . $field, 'fair') === $value ? 'checked' : '' }}>
                                                </td>
                                            @endforeach
                                        </tr>
                                        @error($field . '.' . $field)
                                            <tr>
                                                <td colspan="7" class="text-danger">{{ $message }}</td>
                                            </tr>
                                        @enderror
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-6 mb-20">
                            <h6>Effective Area</h6>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Effective Area</th>
                                        <th>Excellent</th>
                                        <th>Good</th>
                                        <th>Fair</th>
                                        <th>Poor</th>
                                        <th>V.Poor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (['punctuality', 'regularity', 'neatness', 'politeness', 'honesty', 'cooperation', 'emotional', 'health', 'behaviour', 'attentiveness'] as $index => $field)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ ucwords(str_replace('_', ' ', $field)) }}</td>
                                            @foreach (['excellent', 'good', 'fair', 'poor', 'v_poor'] as $value)
                                                <td>
                                                    <input type="radio"
                                                        name="{{ $field }}[{{ $field }}]"
                                                        value="{{ $value }}" class="form-check-input"
                                                        {{ old($field . '.' . $field, 'fair') === $value ? 'checked' : '' }}>
                                                </td>
                                            @endforeach
                                        </tr>
                                        @error($field . '.' . $field)
                                            <tr>
                                                <td colspan="7" class="text-danger">{{ $message }}</td>
                                            </tr>
                                        @enderror
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Summary Row -->
                    <div class="row">
                        <div class="col-sm-3 mb-20">
                            <label for="noofsubjectpass" class="form-label">Number of Subjects Passed</label>
                            <input type="text" class="form-control" id="noofsubjectpass" name="noofsubjectpass"
                                readonly value="{{ old('noofsubjectpass', 0) }}">
                            @error('noofsubjectpass')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-3 mb-20">
                            <label for="average" class="form-label">Average</label>
                            <input type="text" class="form-control" id="average" name="average" readonly
                                value="{{ old('average', 0) }}">
                            @error('average')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-3 mb-20">
                            <label for="grade" class="form-label">Grade</label>
                            <input type="text" class="form-control" id="grade" name="grade" readonly
                                value="{{ old('grade') }}">
                            @error('grade')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-3 mb-20">
                            <label for="conduct" class="form-label">Conduct</label>
                            <input type="text" class="form-control" id="conduct" name="conduct" readonly
                                value="{{ old('conduct') }}">
                            @error('conduct')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Comments -->
                    <div class="row">
                        <div class="col-sm-6 mb-20">
                            <label for="class_teacher_comment" class="form-label">Teacher's Comment</label>
                            <select name="class_teacher_comment" id="class_teacher_comment"
                                class="form-select @error('class_teacher_comment') is-invalid @enderror">
                                <option value="">-- Select Comment --</option>
                                @foreach ($comments as $comment)
                                    <option value="{{ $comment->id }}"
                                        {{ old('class_teacher_comment') == $comment->id ? 'selected' : '' }}>
                                        {{ $comment->comment }}
                                    </option>
                                @endforeach
                            </select>
                            @error('class_teacher_comment')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-6 mb-20">
                            <label for="principal_comment" class="form-label">Principal's Comment</label>
                            <select name="principal_comment" id="principal_comment"
                                class="form-select @error('principal_comment') is-invalid @enderror">
                                <option value="">-- Select Comment --</option>
                                @foreach ($comments as $comment)
                                    <option value="{{ $comment->id }}"
                                        {{ old('principal_comment') == $comment->id ? 'selected' : '' }}>
                                        {{ $comment->comment }}
                                    </option>
                                @endforeach
                            </select>
                            @error('principal_comment')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary">Save Result</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Grades and comments data from backend
        const grades = @json($grades);
        const comments = @json($comments);

        // Function to calculate total for a subject row
        function calculateRowTotal(row) {
            const firstTest = parseFloat(row.find('.first-test').val()) || 0;
            const secondTest = parseFloat(row.find('.second-test').val()) || 0;
            const exam = parseFloat(row.find('.exam').val()) || 0;
            const total = firstTest + secondTest + exam;
            row.find('.total').val(total);

            // Determine grade based on total
            let grade = '';
            for (let g of grades) {
                if (total >= g.min_score && total <= g.max_score) {
                    grade = g.grade_name;
                    break;
                }
            }
            row.find('.grade').val(grade);
            return total;
        }

        // Function to update comment dropdowns based on grade
        function updateComments(gradeName) {
            // Find the grade ID corresponding to the grade name
            const grade = grades.find(g => g.grade_name === gradeName);
            const gradeId = grade ? grade.id : null;

            // Filter comments by grade_id
            const filteredComments = gradeId ? comments.filter(comment => comment.grade_id === gradeId) : [];

            // Update both dropdowns
            ['#class_teacher_comment', '#principal_comment'].forEach(selector => {
                const $select = $(selector);
                const currentValue = $select.val(); // Preserve current selection
                $select.empty(); // Clear existing options
                $select.append('<option value="">-- Select Comment --</option>');

                if (filteredComments.length > 0) {
                    filteredComments.forEach(comment => {
                        const selected = comment.id == currentValue ? 'selected' : '';
                        $select.append(`<option value="${comment.id}" ${selected}>${comment.comment}</option>`);
                    });
                } else {
                    $select.append('<option value="">No comments available</option>');
                }
            });
        }

        // Function to calculate overall totals and summary
        function calculateOverall() {
            let firstTestTotal = 0,
                secondTestTotal = 0,
                examTotal = 0,
                overallTotal = 0,
                passCount = 0;
            let subjectCount = 0;

            $('#subject-scores .subject-row').each(function() {
                const row = $(this);
                if (row.find('.offer-subject').is(':checked')) {
                    const firstTest = parseFloat(row.find('.first-test').val()) || 0;
                    const secondTest = parseFloat(row.find('.second-test').val()) || 0;
                    const exam = parseFloat(row.find('.exam').val()) || 0;
                    const total = calculateRowTotal(row);
                    firstTestTotal += firstTest;
                    secondTestTotal += secondTest;
                    examTotal += exam;
                    overallTotal += total;
                    subjectCount++;
                    if (total >= 50) passCount++; // Assuming 50 is the pass mark
                }
            });



            $('#first_test_total').val(firstTestTotal.toFixed(2));
            $('#second_test_total').val(secondTestTotal.toFixed(2));
            $('#exam_total').val(examTotal.toFixed(2));
            $('#overall_total').val(overallTotal.toFixed(2));
            $('#noofsubjectpass').val(passCount);

            const average = subjectCount > 0 ? (overallTotal / subjectCount).toFixed(2) : 0;
            $('#average').val(average);

            // Determine overall grade
            let overallGrade = '';
            for (let g of grades) {
                if (average >= g.min_score && average <= g.max_score) {
                    overallGrade = g.grade_name;
                    break;
                }
            }
            $('#grade').val(overallGrade);

            // Determine conduct based on grade
            const conductMap = {
                'A': 'Distinction',
                'B': 'Credit',
                'C': 'Merit',
                'D': 'Pass',
                'F': 'Fail'
            };
            $('#conduct').val(conductMap[overallGrade] || '');

            // Update comments based on overall grade
            updateComments(overallGrade);
        }

        // Toggle subject fields based on offer checkbox
        $('#subject-scores').on('change', '.offer-subject', function() {
            const row = $(this).closest('.subject-row');
            const inputs = row.find('.first-test, .second-test, .exam');
            inputs.prop('readonly', !this.checked);
            if (!this.checked) {
                inputs.val(0);
                row.find('.total').val(0);
                row.find('.grade').val('');
            }
            calculateOverall();
        });

        // Recalculate on input change
        $('#subject-scores').on('input', '.first-test, .second-test, .exam', function() {
            const row = $(this).closest('.subject-row');
            if (row.find('.offer-subject').is(':checked')) {
                calculateRowTotal(row);
            }
            calculateOverall();
        });

        // AJAX to fetch student scores
        $('#student_id').on('change', function() {
            const studentId = $(this).val();
            if (studentId) {
                $.ajax({
                    url: '{{ url('/staff/studentresults/compute/getscores') }}/' + studentId,
                    method: 'GET',
                    success: function(response) {
                        // Reset all fields
                        $('#subject-scores .subject-row').each(function() {
                            const row = $(this);
                            row.find('.first-test, .second-test, .exam, .total').val(0);
                            row.find('.grade').val('');
                            row.find('.offer-subject').prop('checked', true).prop('readonly',
                                false);
                        });

                        // Populate scores
                        if (response.scores) {
                            response.scores.forEach(score => {
                                const row = $(
                                    `#subject-scores .subject-row[data-subject-id="${score.subject_id}"]`
                                );
                                row.find('.first-test').val(score.first_test || 0);
                                row.find('.second-test').val(score.second_test || 0);
                                row.find('.exam').val(score.exam || 0);
                                row.find('.offer-subject').prop('checked', true);
                                calculateRowTotal(row);
                            });
                        }

                        calculateOverall();
                    },
                    error: function() {
                        alert('Failed to fetch student scores.');
                    }
                });
            }
        });

        // Hide alert on close
        $('.remove-button').on('click', function() {
            $(this).closest('.alert').addClass('d-none');
        });
    </script>
@endpush
