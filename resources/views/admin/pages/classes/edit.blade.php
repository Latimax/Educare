@extends('admin.layouts.app')

@section('title', 'Edit Class')

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Classes</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Edit Class</li>
            </ul>
        </div>

        <div class="card basic-data-table">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Edit Class</h5>
                <a href="{{ route('admin.classes.index') }}"
                   class="btn btn-outline-primary-600 radius-8 px-20 py-11 d-flex align-items-center gap-2">
                    <iconify-icon icon="icons8:left-round" class="text-xl"></iconify-icon> Back
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success my-4 bg-success-100 text-success-600 border-success-600 border-start-width-4-px px-24 py-13 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between" role="alert">
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
                <!-- Edit Class Form -->
                <form action="{{ route('admin.classes.update', $class->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Class Name -->
                        <div class="col-sm-6 mb-20">
                            <label for="class_name" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Class Name <span class="text-danger-600">*</span>
                            </label>
                            <input type="text" class="form-control radius-8 @error('class_name') is-invalid @enderror"
                                   id="class_name" name="class_name" placeholder="Enter Class Name"
                                   value="{{ old('class_name', $class->class_name) }}">
                            @error('class_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Section -->
                        <div class="col-sm-6 mb-20">
                            <label for="section" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Section <span class="text-danger-600">*</span>
                            </label>
                            <select name="section" id="section" class="form-select radius-8 @error('section') is-invalid @enderror">
                                <option value="">-- Select Section --</option>
                                @foreach (['A', 'B', 'C', 'D', 'E'] as $sec)
                                    <option value="{{ $sec }}" {{ old('section', $class->section) == $sec ? 'selected' : '' }}>{{ $sec }}</option>
                                @endforeach
                            </select>
                            @error('section')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Class Teacher -->
                        <div class="col-sm-6 mb-20">
                            <label for="class_teacher_id" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Class Teacher
                            </label>
                            <select name="class_teacher_id" id="class_teacher_id" class="form-select radius-8 @error('class_teacher_id') is-invalid @enderror">
                                <option value="">-- Select Teacher --</option>
                                @foreach ($staffs as $staff)
                                    <option value="{{ $staff->id }}" {{ old('class_teacher_id', $class->class_teacher_id) == $staff->id ? 'selected' : '' }}>
                                        {{ $staff->fullname }}
                                    </option>
                                @endforeach
                            </select>
                            @error('class_teacher_id')
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
                                    <option value="{{ $level->id }}" {{ old('level_id', $class->level_id) == $level->id ? 'selected' : '' }}>
                                        {{ $level->level_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('level_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Update Class</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('.remove-button').on('click', function () {
            $(this).closest('.alert').addClass('d-none');
        });
    </script>
@endpush
