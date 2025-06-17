@extends('admin.layouts.app')

@section('title', 'CBT Questions | All Questions for {{ $subject_name }}')

@php
    $imgpath = 'storage/front/images/';
@endphp

@push('styles')
    <link rel="stylesheet" href="{{ asset('adminpage/assets/css/lib/dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminpage/assets/css/lib/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminpage/assets/css/lib/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('adminpage/assets/css/lib/audioplayer.css') }}">
@endpush

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Cbt Questions</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium"> CBT Questions</li>
            </ul>
        </div>

        <div class="card basic-data-table">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">{{ $subject_name }}</h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.cbtquestions.index') }}"
                        class="btn btn-outline-secondary radius-8 px-20 py-11 d-flex align-items-center gap-2">
                        <iconify-icon icon="ic:round-arrow-back" class="text-xl"></iconify-icon> Back
                    </a>
                    <a href="{{ route('admin.cbtquestions.subjects.create', ['subjectId' => $subjectId, 'classId' => $classId]) }}"
                        class="btn btn-outline-primary-600 radius-8 px-20 py-11 d-flex align-items-center gap-2">
                        <iconify-icon icon="ei:plus" class="text-xl"></iconify-icon> Add New
                    </a>
                </div>
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
                                <th>ID</th>
                                <th>Description</th>
                                <th>Option A</th>
                                <th>Option B</th>
                                <th>Option C</th>
                                <th>Option D</th>
                                <th>Answer</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($questions as $question)
                                <tr>
                                    <td>
                                        <div class="form-check style-check d-flex align-items-center">
                                            <input class="form-check    -input" type="checkbox"
                                                id="question_{{ $question->id }}">
                                            <label class="form-check-label"
                                                for="question_{{ $question->id }}">{{ $question->id }}</label>
                                        </div>
                                    </td>
                                    <td>{{ \Illuminate\Support\Str::limit(strip_tags($question->description), 10, '...') ?? \Illuminate\Support\Str::limit(strip_tags($question->question), 2, '...') }}
                                    </td>
                                    <td>{{ \Illuminate\Support\Str::limit(strip_tags($question->option_a), 5, '...') }}
                                    </td>
                                    <td>{{ \Illuminate\Support\Str::limit(strip_tags($question->option_b), 5, '...') }}
                                    </td>
                                    <td>{{ \Illuminate\Support\Str::limit(strip_tags($question->option_c), 5, '...') }}
                                    </td>
                                    <td>{{ \Illuminate\Support\Str::limit(strip_tags($question->option_d), 5, '...') }}
                                    </td>
                                    <td>{{ htmlspecialchars($question->answer) }}</td>
                                    <td>
                                        <!-- Example actions: Edit/Delete -->
                                        <a href="{{ route('admin.cbtquestions.edit', $question->id) }}"
                                            class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('admin.cbtquestions.destroy', $question->id) }}"
                                            method="POST" class="d-inline form-delete">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
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
    <!-- Buttons Extension JS -->
    <script src="{{ asset('adminpage/assets/js/lib/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('adminpage/assets/js/lib/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('adminpage/assets/js/lib/buttons.print.min.js') }}"></script>

    <!-- FileSaver and jszip/pdfmake for Excel/PDF -->
    <script src="{{ asset('adminpage/assets/js/lib/jszip.min.js') }}"></script>
    <script src="{{ asset('adminpage/assets/js/lib/pdfmake.min.js') }}"></script>
    <script src="{{ asset('adminpage/assets/js/lib/vfs_fonts.js') }}"></script>

    <script>
        $('.remove-button').on('click', function() {
            $(this).closest('.alert').addClass('d-none');
        });

        let table = new DataTable('#dataTable', {
            dom: 'Bfrtip',
            buttons: [
                'copy',
                'excel',
                'pdf',
                'print'
            ]
        });

        $(document).ready(function() {
            $('.form-delete').on('submit', function(e) {
                e.preventDefault();
                var form = this;

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
