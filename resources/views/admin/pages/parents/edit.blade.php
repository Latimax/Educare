
@extends('admin.layouts.app')

@section('title', 'Edit Parent')

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Parents</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Edit Parent</li>
            </ul>
        </div>

        <div class="card basic-data-table">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Edit Parent</h5>
                <a href="{{ route('admin.parents.index') }}"
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
                <!-- Edit Parent Form -->
                <form action="{{ route('admin.parents.update', $parent->id) }}" method="POST" autocomplete="off">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        <!-- Fullname -->
                        <div class="col-sm-6 mb-20">
                            <label for="fullname" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Full Name <span class="text-danger-600">*</span>
                            </label>
                            <input type="text" class="form-control radius-8 @error('fullname') is-invalid @enderror"
                                id="fullname" name="fullname" placeholder="Enter Full Name"
                                value="{{ old('fullname', $parent->fullname) }}">
                            @error('fullname')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-sm-6 mb-20">
                            <label for="email" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Email
                            </label>
                            <input type="email" class="form-control radius-8 @error('email') is-invalid @enderror"
                                id="email" name="email" placeholder="Enter Email"
                                value="{{ old('email', $parent->email) }}">
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Optional</small>
                        </div>

                        <!-- Password (Leave blank if not updating) -->
                        <div class="col-sm-6 mb-20">
                            <label for="password" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Password
                            </label>
                            <input type="password" class="form-control radius-8 @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="Enter New Password (Leave blank to keep current)">
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Leave blank if you do not want to change the password.</small>
                        </div>

                        <!-- Occupation -->
                        <div class="col-sm-6 mb-20">
                            <label for="occupation" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Occupation <span class="text-danger-600">*</span>
                            </label>
                            <input type="text" class="form-control radius-8 @error('occupation') is-invalid @enderror"
                                id="occupation" name="occupation" placeholder="Enter Occupation"
                                value="{{ old('occupation', $parent->occupation) }}">
                            @error('occupation')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- State -->
                        <div class="col-sm-6 mb-20">
                            <label for="state" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                State <span class="text-danger-600">*</span>
                            </label>
                            <input type="text" class="form-control radius-8 @error('state') is-invalid @enderror"
                                id="state" name="state" placeholder="Enter State"
                                value="{{ old('state', $parent->state) }}">
                            @error('state')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nationality -->
                        <div class="col-sm-6 mb-20">
                            <label for="nationality" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Nationality <span class="text-danger-600">*</span>
                            </label>
                            <input type="text" class="form-control radius-8 @error('nationality') is-invalid @enderror"
                                id="nationality" name="nationality" placeholder="Enter Nationality"
                                value="{{ old('nationality', $parent->nationality) }}">
                            @error('nationality')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="col-sm-6 mb-20">
                            <label for="phone" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Phone <span class="text-danger-600">*</span>
                            </label>
                            <input type="text" class="form-control radius-8 @error('phone') is-invalid @enderror"
                                id="phone" name="phone" placeholder="Enter Phone Number"
                                value="{{ old('phone', $parent->phone) }}">
                            @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Relationship -->
                        <div class="col-sm-6 mb-20">
                            <label for="relationship" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Relationship <span class="text-danger-600">*</span>
                            </label>
                            <select name="relationship" id="relationship" class="form-select radius-8 @error('relationship') is-invalid @enderror">
                                <option value="">-- Select Relationship --</option>
                                <option value="parent" {{ old('relationship', $parent->relationship) == 'parent' ? 'selected' : '' }}>Parent</option>
                                <option value="guardian" {{ old('relationship', $parent->relationship) == 'guardian' ? 'selected' : '' }}>Guardian</option>
                            </select>
                            @error('relationship')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Update Parent</button>
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
