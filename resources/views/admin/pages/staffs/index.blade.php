@extends('admin.layouts.app')

@section('title', 'School Staffs | All Staffs')

@php
    $imgpath = 'storage/front/images/';
@endphp

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Staffs</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium"> Staffs</li>
        </ul>
    </div>

    <div class="card basic-data-table">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="card-title mb-0">All School Staffs</h5>
            <h5 class="card-title mb-0">
                <a href="{{ route('admin.staffs.create') }}"
                    class="btn btn-outline-primary-600 radius-8 px-20 py-11 d-flex align-items-center gap-2">
                    <iconify-icon icon="ei:plus" class="text-xl"></iconify-icon> Add New
                </a>
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
                            <th>Photo</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Position</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($staffs as $staff)
                            <tr>
                                <td>
                                    @if ($staff->photo)
                                        <img src="{{ asset('storage/'.$staff->photo) }}" alt="photo" width="50" height="50" class="rounded-circle">
                                    @else
                                        <img src="{{ asset($imgpath.'default-avatar.png') }}" alt="default" width="50" height="50" class="rounded-circle">
                                    @endif
                                </td>
                                <td>{{ $staff->fullname }}</td>
                                <td>{{ $staff->email }}</td>
                                <td>{{ $staff->phone }}</td>
                                <td>{{ $staff->position }}</td>
                                <td>
                                    @if ($staff->status === 'active')
                                        <span class="badge bg-success-100 text-success-600">Active</span>
                                    @else
                                        <span class="badge bg-danger-100 text-danger-600">Disabled</span>
                                    @endif
                                </td>
                                <td class="d-flex gap-2 align-items-center">
                                    <a href="{{ route('admin.staffs.edit', $staff->id) }}"
                                        class="btn btn-outline-primary-600 radius-8 text-primary-600 d-inline-flex align-items-center justify-content-center gap-1">
                                        <iconify-icon icon="akar-icons:edit" class="text-xl"></iconify-icon>
                                        <span>Edit</span>
                                    </a>

                                    <form action="{{ route('admin.staffs.destroy', $staff->id) }}" method="POST" class="d-inline form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-outline-danger radius-8 text-danger d-inline-flex align-items-center justify-content-center gap-1">
                                            <iconify-icon icon="mingcute:delete-2-line" class="text-xl"></iconify-icon>
                                            <span>Delete</span>
                                        </button>
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
<script>
    $('.remove-button').on('click', function () {
        $(this).closest('.alert').addClass('d-none');
    });

    let table = new DataTable('#dataTable');

    $(document).ready(function () {
        $('.form-delete').on('submit', function (e) {
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
            }).then(function (result) {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
