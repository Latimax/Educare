
@extends('admin.layouts.app')

@section('title', 'Create New Subject')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Subjects</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">New Subject</li>
        </ul>
    </div>

    <div class="card basic-data-table">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="card-title mb-0">Create New Subject</h5>
            <a href="{{ route('admin.subjects.index') }}"
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

        <div class="card-body">
            <form action="{{ route('admin.subjects.store') }}" method="POST">
                @csrf
                <div class="row">

                    <!-- Subject Name -->
                    <div class="col-sm-6 mb-20">
                        <label for="subject_name" class="form-label fw-semibold text-primary-light text-sm mb-8">
                            Subject Name <span class="text-danger-600">*</span>
                        </label>
                        <input type="text" class="form-control radius-8 @error('subject_name') is-invalid @enderror"
                               id="subject_name" name="subject_name" placeholder="Enter Subject Name" value="{{ old('subject_name') }}">
                        @error('subject_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Subject Code -->
                    <div class="col-sm-6 mb-20">
                        <label for="subject_code" class="form-label fw-semibold text-primary-light text-sm mb-8">
                            Subject Code <span class="text-danger-600">*</span>
                        </label>
                        <input type="text" class="form-control radius-8 @error('subject_code') is-invalid @enderror"
                               id="subject_code" name="subject_code" placeholder="Enter Subject Code" value="{{ old('subject_code') }}">
                        @error('subject_code')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Staff (Teacher) -->
                    <div class="col-sm-6 mb-20">
                        <label for="staff_id" class="form-label fw-semibold text-primary-light text-sm mb-8">
                            Staff <span class="text-danger-600">*</span>
                        </label>
                        <select name="staff_id" id="staff_id" class="form-select radius-8 @error('staff_id') is-invalid @enderror">
                            <option value="">-- Select Staff --</option>
                            @foreach($staffs as $staff)
                                <option value="{{ $staff->id }}" {{ old('staff_id') == $staff->id ? 'selected' : '' }}>
                                    {{ $staff->fullname }}
                                </option>
                            @endforeach
                        </select>
                        @error('staff_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Level -->
                    <div class="col-sm-6 mb-20">
                        <label for="level_id" class="form-label fw-semibold text-primary-light text-sm mb-8">
                            Level <span class="text-danger-600">*</span>
                        </label>
                        <select name="level_id" id="level_id" class="form-select radius-8 @error('level_id') is-invalid @enderror">
                            <option value="">-- Select Level --</option>
                            @foreach ($levels as $level)
                                <option value="{{ $level->id }}" {{ old('level_id') == $level->id ? 'selected' : '' }}>
                                    {{ $level->level_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('level_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Create Subject</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('.remove-button').on('click', function() {
        $(this).closest('.alert').addClass('d-none');
    });
</script>
@endpush
