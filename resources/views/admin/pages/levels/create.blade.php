@extends('admin.layouts.app')

@section('title', 'Create New Level')

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Levels</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">New Level</li>
            </ul>
        </div>

        <div class="card basic-data-table">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Create New Level</h5>
                <a href="{{ route('admin.levels.index') }}"
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
                <!-- Create Level Form -->
                <form action="{{ route('admin.levels.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <!-- Level Name -->
                        <div class="col-sm-6 mb-20">
                            <label for="level_name" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Level Name <span class="text-danger-600">*</span>
                            </label>
                            <input type="text" class="form-control radius-8 @error('level_name') is-invalid @enderror"
                                id="level_name" name="level_name" placeholder="Enter Level Name"
                                value="{{ old('level_name') }}">
                            @error('level_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Short Name -->
                        <div class="col-sm-6 mb-20">
                            <label for="short_name" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Short Name <span class="text-danger-600">*</span>
                            </label>
                            <input type="text" class="form-control radius-8 @error('short_name') is-invalid @enderror"
                                id="short_name" name="short_name" placeholder="Enter Short Name"
                                value="{{ old('short_name') }}">
                            @error('short_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="col-sm-6 mb-20">
                            <label for="status" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Status <span class="text-danger-600">*</span>
                            </label>
                            <select name="status" id="status" class="form-select radius-8 @error('status') is-invalid @enderror">
                                <option value="">-- Select Status --</option>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="disabled" {{ old('status') == 'disabled' ? 'selected' : '' }}>Disabled</option>
                            </select>
                            @error('status')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Create Level</button>
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
