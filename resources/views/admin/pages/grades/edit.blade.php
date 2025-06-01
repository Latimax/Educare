@extends('admin.layouts.app')

@section('title', 'Edit Grade')

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Grades</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Edit Grade</li>
            </ul>
        </div>

        <div class="card basic-data-table">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Edit Grade</h5>
                <a href="{{ route('admin.grades.index') }}"
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
                <!-- Edit Grade Form -->
                <form action="{{ route('admin.grades.update', $grade->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Grade Name -->
                        <div class="col-sm-6 mb-20">
                            <label for="grade_name" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Grade Name <span class="text-danger-600">*</span>
                            </label>
                            <input type="text" class="form-control radius-8 @error('grade_name') is-invalid @enderror"
                                id="grade_name" name="grade_name" placeholder="Enter Grade Name"
                                value="{{ old('grade_name', $grade->grade_name) }}">
                            @error('grade_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="col-sm-6 mb-20">
                            <label for="description" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Description
                            </label>
                            <input type="text" class="form-control radius-8 @error('description') is-invalid @enderror"
                                id="description" name="description" placeholder="Enter Description"
                                value="{{ old('description', $grade->description) }}">
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Min Score -->
                        <div class="col-sm-6 mb-20">
                            <label for="min_score" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Min Score <span class="text-danger-600">*</span>
                            </label>
                            <input type="number" class="form-control radius-8 @error('min_score') is-invalid @enderror"
                                id="min_score" name="min_score" placeholder="Enter Minimum Score"
                                value="{{ old('min_score', $grade->min_score) }}">
                            @error('min_score')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Max Score -->
                        <div class="col-sm-6 mb-20">
                            <label for="max_score" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Max Score <span class="text-danger-600">*</span>
                            </label>
                            <input type="number" class="form-control radius-8 @error('max_score') is-invalid @enderror"
                                id="max_score" name="max_score" placeholder="Enter Maximum Score"
                                value="{{ old('max_score', $grade->max_score) }}">
                            @error('max_score')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Update Grade</button>
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
