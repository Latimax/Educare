@extends('admin.layouts.app')

@section('title', 'Students | All Students')

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
            <h6 class="fw-semibold mb-0">Students</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium"> Students</li>
            </ul>
        </div>

        <div class="card basic-data-table">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">{{ $className ?? 'All Students' }}</h5>

                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('admin.studentresults.classes', $classId) }}"
                        class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1">
                        <iconify-icon icon="ic:round-arrow-back" class="text-sm"></iconify-icon>
                        Back
                    </a>

                    <a href="{{ route('admin.studentresults.rankall', $classId) }}"
                        class="btn btn-outline-warning btn-sm d-flex align-items-center gap-1">
                        <iconify-icon icon="mdi:trophy-outline" class="text-sm"></iconify-icon>
                        Rank All
                    </a>

                    <a href="{{ route('admin.broadsheet.print', $classId) }}" target="_blank"
                        class="btn btn-outline-info btn-sm d-flex align-items-center gap-1">
                        <iconify-icon icon="foundation:results-demographics" class="text-sm"></iconify-icon>
                        Broadsheet
                    </a>

                    <a href="{{ route('admin.studentresults.compute.create', $classId) }}"
                        class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1">
                        <iconify-icon icon="mdi:plus-box-outline" class="text-sm"></iconify-icon>
                        Add New
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
                                <th scope="col">Photo</th>
                                <th>Full Name</th>
                                <th>Average</th>
                                <th>Grade</th>
                                <th>Position</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($studentResults as $result)
                                @php
                                    $summary = json_decode($result->resultData, true)['summary'] ?? null;
                                @endphp
                                <tr>
                                    <td>
                                        @if ($result->student->photo)
                                            <img src="{{ asset('storage/' . $result->student->photo) }}" alt="photo"
                                                width="40" height="40" class="rounded-circle">
                                        @else
                                            <img src="{{ asset($imgpath . 'default-avatar.png') }}" alt="default"
                                                width="40" height="40" class="rounded-circle">
                                        @endif
                                    </td>
                                    <td>{{ $result->student->firstname }} {{ $result->student->lastname }}</td>
                                    <td>{{ number_format($result->average, 1) }}</td>
                                    <td>{{ $summary['grade'] ?? 'N/A' }}</td>
                                    <td>{{ $result->position }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button
                                                class="btn btn-sm btn-outline-primary dropdown-toggle d-flex align-items-center gap-1"
                                                type="button" id="dropdownMenuButton{{ $result->id }}"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <iconify-icon icon="mdi:dots-vertical" class="text-md"></iconify-icon>
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu"
                                                aria-labelledby="dropdownMenuButton{{ $result->id }}">
                                                {{-- Edit --}}
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center gap-1"
                                                        href="{{ route('admin.studentresults.edit', $result->id) }}">
                                                        <iconify-icon icon="mdi:pencil-outline"
                                                            class="text-md"></iconify-icon>
                                                        Edit
                                                    </a>
                                                </li>

                                                {{-- Delete --}}
                                                <li>
                                                    <form action="{{ route('admin.studentresults.destroy', $result->id) }}"
                                                        method="POST" class="form-delete">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="dropdown-item d-flex align-items-center gap-1 text-danger">
                                                            <iconify-icon icon="mdi:delete-outline"
                                                                class="text-md"></iconify-icon>
                                                            Delete
                                                        </button>
                                                    </form>
                                                </li>

                                                {{-- Print --}}
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center gap-1" href="#"
                                                        onclick="printResult('{{ route('admin.studentresults.print', $result->id) }}'); return false;">
                                                        <iconify-icon icon="mdi:printer-outline"
                                                            class="text-md"></iconify-icon>
                                                        Print
                                                    </a>
                                                </li>
                                                {{-- Download PDF --}}
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center gap-1"
                                                        href="{{ route('admin.studentresults.download', $result->id) }}">
                                                        <iconify-icon icon="mdi:file-pdf-box"
                                                            class="text-md"></iconify-icon>
                                                        PDF
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
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

        function printResult(url) {
            const printWindow = window.open(url, '_blank');
            printWindow.onload = function() {
                setTimeout(() => {
                    printWindow.print();
                    printWindow.close();
                }, 500);
            };
        }

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
