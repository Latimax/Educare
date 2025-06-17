@extends('admin.layouts.app')

@section('title', 'Student Scores | Query Scores')

@php
    $imgpath = 'storage/front/images/';
@endphp

@push('styles')
    <link rel="stylesheet" href="{{ asset('adminpage/assets/css/lib/dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminpage/assets/css/lib/buttons.dataTables.min.css') }}">
@endpush

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Student Scores</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Student Scores</li>
            </ul>
        </div>

        <div class="card basic-data-table">
            <div class="card-header">
                <h5 class="card-title mb-0">Score Query</h5>
            </div>
            <div class="card-body">
                <form id="scoreQueryForm" class="mb-4">
                    @csrf
                    <div class="row g-3 pb-4">
                        <div class="col-sm-3">
                            <label for="level" class="form-label">Section</label>
                            <select class="form-select" id="level" name="level_id">
                                <option value="">Select Section</option>
                                @foreach ($levels as $level)
                                    <option value="{{ $level->id }}">{{ $level->level_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label for="class" class="form-label">Class</label>
                            <select class="form-select" id="class" name="class_id" data-level="" disabled>
                                <option value="">Select Class</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label for="subject" class="form-label">Subject</label>
                            <select class="form-select" id="subject" name="subject_id" disabled>
                                <option value="">Select Subject</option>
                            </select>
                        </div>
                        {{-- <div class="col-sm-2">
                            <label for="session" class="form-label">Session</label>
                            <select class="form-select" id="session" name="session" disabled>
                                <option value="">Select Session</option>
                            </select>
                        </div> --}}
                        {{-- <div class="col-sm-2">
                            <label for="term" class="form-label">Term</label>
                            <select class="form-select" id="term" name="term" disabled>
                                <option value="">Select Term</option>
                                <option value="first">First Term</option>
                                <option value="second">Second Term</option>
                                <option value="third">Third Term</option>
                            </select>
                        </div> --}}
                        <div class="col-sm-3">
                            <label for="submitQuery" class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-outline-primary w-100" id="submitQuery" disabled>
                                Query Scores
                            </button>
                        </div>
                    </div>
                    {{-- <div class="row">
                        <div class="col-sm-12 my-4">
                            <button type="submit" class="btn btn-outline-primary w-100" id="submitQuery" disabled>
                                Query Scores
                            </button>
                        </div>
                    </div> --}}
                </form>

                <div class="table-responsive">
                    <table class="table bordered-table mb-0" id="scoresTable" data-page-length='10'>
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Subject</th>
                                <th>Student Name</th>
                                <th>Reg No</th>
                                <th>1st Test</th>
                                <th>2nd Test</th>
                                <th>Exam</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Populated by AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('adminpage/assets/js/lib/dataTables.min.js') }}"></script>
    <script src="{{ asset('adminpage/assets/js/lib/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('adminpage/assets/js/lib/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('adminpage/assets/js/lib/buttons.print.min.js') }}"></script>
    <script src="{{ asset('adminpage/assets/js/lib/jszip.min.js') }}"></script>
    <script src="{{ asset('adminpage/assets/js/lib/pdfmake.min.js') }}"></script>
    <script src="{{ asset('adminpage/assets/js/lib/vfs_fonts.js') }}"></script>
    <script src="{{ asset('adminpage/assets/js/lib/select2.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2
           // $('#level, #class, #subject, #session, #term').select2();
           $('#level, #class, #subject').select2();

            // Initialize DataTable
            let table = $('#scoresTable').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'excel', 'pdf', 'print'],
                pageLength: 10
            });

            // Function to clear table and reset dependent fields
            function resetDependentFields(startFrom) {
                clearTable();

                //const fields = ['#class', '#subject', '#session', '#term'];
                const fields = ['#class', '#subject'];
                const startIndex = fields.indexOf(startFrom);

                if (startIndex >= 0) {
                    for (let i = startIndex; i < fields.length; i++) {
                        $(fields[i]).val('').trigger('change.select2');
                        $(fields[i]).prop('disabled', true);
                    }
                }

                $('#submitQuery').prop('disabled', true);
            }

            // Function to clear table
            function clearTable() {
                table.clear().draw();
            }

            // Level change handler
            $('#level').on('change', function() {
                resetDependentFields('#class');

                let levelId = $(this).val();
                if (levelId) {
                    $.ajax({
                        url: '{{ url('/admin/studentscores/getclasses') }}/' + levelId,
                        method: 'GET',
                        success: function(response) {
                            $('#class').prop('disabled', false);
                            $('#class').html('<option value="">Select Class</option>');
                            response.classes.forEach(function(cls) {
                                $('#class').append(
                                    `<option value="${cls.id}">${cls.class_name}</option>`
                                );
                                $('#class').prop('data-level', cls.level_id);
                            });
                            $('#class').trigger('change.select2');
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to fetch classes. Please try again.'
                            });
                        }
                    });
                }
            });

            // Class change handler
            $('#class').on('change', function() {
                resetDependentFields('#subject');

                let classId = $(this).val();
                let levelId = $(this).prop('data-level');

                if (classId) {
                    $.ajax({
                        url: '{{ url('/admin/studentscores/getsubjects') }}/' + levelId,
                        method: 'GET',
                        success: function(response) {
                            $('#subject').prop('disabled', false).html(
                                '<option value="">Select Subject</option>');
                            response.subjects.forEach(function(subject) {
                                $('#subject').append(
                                    `<option value="${subject.id}">${subject.subject_name}</option>`
                                );
                            });
                            $('#subject').trigger('change.select2');

                            $('#session').prop('disabled', false).html(
                                '<option value="">Select Session</option>');
                            response.sessions.forEach(function(session) {
                                $('#session').append(
                                    `<option value="${session.session_name}">${session.session_name}</option>`
                                );
                            });
                            $('#session').trigger('change.select2');
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to fetch subjects and sessions. Please try again.'
                            });
                        }
                    });
                }
            });

            // Subject change handler
            $('#subject').on('change', function() {
                resetDependentFields('#term');
               $('#submitQuery').prop('disabled', !$(this).val());
            });

            // // Session change handler
            // $('#session').on('change', function() {
            //     resetDependentFields('#term');
            //     $('#term').prop('disabled', !$(this).val() || !$('#subject').val());
            // });

            // // Term change handler
            // $('#term').on('change', function() {
            //     clearTable();
            //     $('#submitQuery').prop('disabled', !$(this).val());
            // });

            // Form submission
            $('#scoreQueryForm').on('submit', function(e) {
                e.preventDefault();
                clearTable();

                $.ajax({
                    url: '{{ route('admin.studentscores.query') }}',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        table.clear().draw();

                        if (response.scores && response.scores.length > 0) {
                            response.scores.forEach(function(score) {
                                let photo = score.student.photo ?
                                    `<img src="{{ asset('storage/') }}/${score.student.photo}" alt="photo" width="50" height="50" class="rounded-circle">` :
                                    `<img src="{{ asset($imgpath . 'default-avatar.png') }}" alt="default" width="50" height="50" class="rounded-circle">`;

                                table.row.add([
                                    photo,
                                    score.subject.subject_name,
                                    `${score.student.firstname} ${score.student.lastname}`,
                                    score.student.studentId,
                                    score.first_test ?? 'N/A',
                                    score.second_test ?? 'N/A',
                                    score.exam ?? 'N/A'
                                ]).draw();
                            });
                        } else {
                            // Show "No records found" message
                            Swal.fire({
                            icon: 'error',
                            title: 'Information',
                            text: 'No records found'
                        });

                        }
                    },
                    error: function(error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to fetch scores. Please try again.'
                        });
                    }
                });
            });
        });
    </script>
@endpush
