@extends('admin.layouts.app')

@section('title', 'School Payments | All Payments')

@push('styles')
    <link rel="stylesheet" href="{{ asset('adminpage/assets/css/lib/dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminpage/assets/css/lib/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminpage/assets/css/lib/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('adminpage/assets/css/lib/audioplayer.css') }}">
@endpush

@php
    $imgpath = 'storage/front/images/';
@endphp

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Payments</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Payments</li>
            </ul>
        </div>

        <div class="card basic-data-table">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">All Payments</h5>
                <h5 class="card-title mb-0">
                    <a href="{{ route('admin.payments.create') }}"
                        class="btn btn-outline-primary-600 radius-8 px-20 py-11 d-flex align-items-center gap-2">
                        <iconify-icon icon="ei:plus" class="text-xl"></iconify-icon> Add New
                    </a>
                </h5>
            </div>

            @if (session('success'))
                <div
                    class="alert alert-success my-4 bg-success-100 text-success-600 border-success-600 border-start-width-4-px px-24 py-13 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between">
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
                                <th>Reference</th>
                                <th>Student</th>
                                <th>Amount Paid</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                                <tr>
                                    <td>{{ $payment->reference }}</td>
                                    <td>{{ $payment->student->fullname ?? 'N/A' }}</td>
                                    <td>{{ number_format($payment->amount_paid, 2) }}</td>
                                    <td>
                                        @if ($payment->status === 'paid')
                                            <span class="badge bg-success-100 text-success-600">Paid</span>
                                        @elseif ($payment->status === 'pending')
                                            <span class="badge bg-warning-100 text-warning-700">Pending</span>
                                        @else
                                            <span class="badge bg-danger-100 text-danger-600">Failed</span>
                                        @endif
                                    </td>
                                    <td>{{ $payment->payment_date }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button
                                                class="btn btn-outline-primary-600 radius-8 d-flex align-items-center gap-2 dropdown-toggle"
                                                type="button" data-bs-toggle="dropdown" aria-expanded="false"
                                                title="Actions">
                                                <iconify-icon icon="carbon:overflow-menu-horizontal"
                                                    class="text-xl"></iconify-icon>
                                            </button>
                                            <ul class="dropdown-menu" data-popper-placement="top-start" data-popper-reference-hidden="" style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(0px, -36px, 0px);">
                                                <li>
                                                    <a href="{{ route('admin.payments.edit', $payment->id) }}"
                                                        class="dropdown-item d-flex align-items-center gap-1 text-primary">
                                                        <iconify-icon icon="akar-icons:edit" class="text-lg"></iconify-icon>
                                                        Edit
                                                    </a>
                                                </li>

                                                 <li>
                                                    <a href="{{ route('admin.payments.edit', $payment->id) }}"
                                                        class="dropdown-item d-flex align-items-center gap-1 text-secondary">
                                                        <iconify-icon icon="fluent:print-20-regular"
                                                            class="text-lg"></iconify-icon>
                                                        Print
                                                    </a>
                                                </li>

                                                <li>
                                                    <form action="{{ route('admin.payments.destroy', $payment->id) }}"
                                                        method="POST" class="form-delete">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="dropdown-item d-flex align-items-center gap-1 text-danger">
                                                            <iconify-icon icon="mingcute:delete-2-line"
                                                                class="text-lg"></iconify-icon>
                                                            Delete
                                                        </button>
                                                    </form>
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
