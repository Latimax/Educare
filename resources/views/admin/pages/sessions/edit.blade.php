@extends('admin.layouts.app')

@section('title', 'Edit Session')

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Sessions</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Edit Session</li>
            </ul>
        </div>

        <div class="card basic-data-table">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Edit Session</h5>
                <a href="{{ route('admin.sessions.index') }}"
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
                <!-- Edit Session Form -->
                <form action="{{ route('admin.sessions.update', $sessionData->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Session Name -->
                        <div class="col-sm-6 mb-20">
                            <label for="session_name" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Session Name <span class="text-danger-600">*</span>
                            </label>
                            <input type="text" class="form-control radius-8 @error('session_name') is-invalid @enderror"
                                id="session_name" name="session_name" placeholder="Enter Session Name"
                                value="{{ old('session_name', $sessionData->session_name) }}">
                            @error('session_name')
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
                                <option value="active" {{ old('status', $sessionData->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="disabled" {{ old('status', $sessionData->status) == 'disabled' ? 'selected' : '' }}>Disabled</option>
                            </select>
                            @error('status')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Update Session</button>
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
