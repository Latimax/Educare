@extends('staff.layouts.app')

@section('title', 'Compute Result | All Levels')

@php
    $imgpath = 'storage/front/images/';
@endphp

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Compute Result</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('staff.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium"> Compute Result</li>
            </ul>
        </div>

        <div class="card basic-data-table">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Select Level</h5>

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
                                <th scope="col">Level Name</th>
                                <th scope="col">Short Name</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($levels as $index => $level)
                                <tr>
                                    <td>
                                        <div class="form-check style-check d-flex align-items-center">
                                            <input class="form-check-input" type="checkbox">
                                            <label class="form-check-label">{{ $index + 1 }}</label>
                                        </div>
                                    </td>
                                    <td><a href="{{ route('staff.studentresults.classes', $level->id) }}"
                                            class="text-primary-600">{{ $level->level_name }}</a></td>
                                    <td>{{ $level->short_name }}</td>


                                    <td class="d-flex gap-2 align-items-center">
                                        {{-- Edit Button --}}
                                        <a href="{{ route('staff.studentresults.classes', $level->id) }}"
                                            class="btn btn-outline-primary-600 radius-8 text-primary-600 d-inline-flex align-items-center justify-content-center gap-1">
                                            <iconify-icon icon="akar-icons:edit" class="text-xl"></iconify-icon>
                                            <span>View Classes [{{ count($level->classes) }}]</span>
                                        </a>
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
        $('.remove-button').on('click', function() {
            $(this).closest('.alert').addClass('d-none');
        });

        let table = new DataTable('#dataTable');

    </script>
@endpush
