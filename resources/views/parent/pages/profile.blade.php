@extends('parent.layouts.app')

@section('title', 'Parent Profile')

@php
    // Check if the request has an 'activeTab' parameter or if there are errors in the change password fields
    $changePasswordError = $errors->has('current_password') || $errors->has('new_password') || $errors->has('new_password_confirmation');
    // Default to 'profile' unless the request indicates 'change' or there are password errors
    $activeTab = request('activeTab') ? request('activeTab') : ($changePasswordError ? 'change' : 'profile');
@endphp

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Your Profile</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('parent.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Your Profile</li>
            </ul>
        </div>

        @if (session('success'))
            <div class="alert alert-info my-4 bg-success-100 text-success-600 border-success-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-0 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between"
                role="alert">
                <div class="d-flex align-items-center gap-2">
                    <iconify-icon icon="mingcute:emoji-line" class="icon text-xl"></iconify-icon>
                    {{ session('success') }}
                </div>
                <button class="remove-button text-success-600 text-xxl line-height-1">
                    <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon>
                </button>
            </div>
        @endif

        <div class="row gy-4">
            <div class="col-lg-4">
                <div class="user-grid-card position-relative border overflow-hidden bg-base h-100">
                    <img src="{{ asset('front/images/about/about-company.jpg') }}" alt=""
                        class="w-100 mb-12 object-fit-cover">
                    <div class="pb-24 ms-16 mb-24 me-16 mt--100">
                        <div class="text-center mt-12 border border-top-0 border-start-0 border-end-0">
                            <h6 class="mb-0 mt-32">{{ Auth::guard('parent')->user()->name }}</h6>
                            <span class="text-secondary-light mb-16">Parent</span>
                        </div>
                        <div class="mt-32">
                            <h6 class="text-xl mb-16">Personal Info</h6>
                            <ul>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Full Name</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{ Auth::guard('parent')->user()->fullname }}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Email</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{ Auth::guard('parent')->user()->email }}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Phone Number</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{ Auth::guard('parent')->user()->phone ?? 'N/A' }}</span>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="card-body p-24">
                        <ul class="nav border-gradient-tab nav-pills mb-20 d-inline-flex" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button
                                    class="nav-link d-flex align-items-center px-24 {{ $activeTab == 'profile' ? 'active' : '' }}"
                                    id="pills-edit-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-edit-profile"
                                    type="button" role="tab" aria-controls="pills-edit-profile"
                                    aria-selected="{{ $activeTab == 'profile' ? 'true' : 'false' }}">
                                    Edit Profile
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button
                                    class="nav-link d-flex align-items-center px-24 {{ $activeTab == 'change' ? 'active' : '' }}"
                                    id="pills-change-passwork-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-change-passwork" type="button" role="tab"
                                    aria-controls="pills-change-passwork"
                                    aria-selected="{{ $activeTab == 'change' ? 'true' : 'false' }}" tabindex="-1">
                                    Change Password
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade {{ $activeTab == 'profile' ? 'show active' : '' }}"
                                id="pills-edit-profile" role="tabpanel" aria-labelledby="pills-edit-profile-tab"
                                tabindex="0">
                                <h6 class="text-md text-primary-light mb-16">Profile Details</h6>
                                <form action="{{ route('parent.profile.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-20">
                                                <label for="name"
                                                    class="form-label fw-semibold text-primary-light text-sm mb-8">
                                                    Full Name <span class="text-danger-600">*</span>
                                                </label>
                                                <input type="text" name="fullname"
                                                    class="form-control radius-8 @error('fullname') is-invalid @enderror"
                                                    id="name" placeholder="Enter Full Name"
                                                    value="{{ old('fullname', Auth::guard('parent')->user()->fullname) }}">
                                                @error('fullname')
                                                    <span class="text-danger text-sm">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="mb-20">
                                                <label for="email"
                                                    class="form-label fw-semibold text-primary-light text-sm mb-8">
                                                    Email <span class="text-danger-600">*</span>
                                                </label>
                                                <input type="email" name="email"
                                                    class="form-control radius-8 @error('email') is-invalid @enderror"
                                                    id="email" placeholder="Enter email address"
                                                    value="{{ old('email', Auth::guard('parent')->user()->email) }}">
                                                @error('email')
                                                    <span class="text-danger text-sm">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="mb-20">
                                                <label for="phone"
                                                    class="form-label fw-semibold text-primary-light text-sm mb-8">
                                                    Phone Number
                                                </label>
                                                <input type="text" name="phone"
                                                    class="form-control radius-8 @error('phone') is-invalid @enderror"
                                                    id="phone" placeholder="Enter phone number"
                                                    value="{{ old('phone', Auth::guard('parent')->user()->phone ?? '') }}">
                                                @error('phone')
                                                    <span class="text-danger text-sm">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-center gap-3">
                                        <a href="{{ route('parent.dashboard') }}"
                                            class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8">
                                            Cancel
                                        </a>
                                        <button type="submit"
                                            class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8">
                                            Save
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <form action="{{ route('parent.password.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="tab-pane fade {{ $activeTab == 'change' ? 'show active' : '' }}"
                                    id="pills-change-passwork" role="tabpanel"
                                    aria-labelledby="pills-change-passwork-tab" tabindex="0">
                                    <div class="mb-20">
                                        <label for="current_password"
                                            class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            Current Password <span class="text-danger-600">*</span>
                                        </label>
                                        <div class="position-relative">
                                            <input type="password" name="current_password"
                                                class="form-control radius-8 @error('current_password') is-invalid @enderror"
                                                id="current_password" placeholder="Enter Current Password">
                                            <span
                                                class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light"
                                                data-toggle="#current_password"></span>
                                        </div>
                                        @error('current_password')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-20">
                                        <label for="new_password"
                                            class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            New Password <span class="text-danger-600">*</span>
                                        </label>
                                        <div class="position-relative">
                                            <input type="password" name="new_password"
                                                class="form-control radius-8 @error('new_password') is-invalid @enderror"
                                                id="new_password" placeholder="Enter New Password">
                                            <span
                                                class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light"
                                                data-toggle="#new_password"></span>
                                        </div>
                                        @error('new_password')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-20">
                                        <label for="new_password_confirmation"
                                            class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            Confirm Password <span class="text-danger-600">*</span>
                                        </label>
                                        <div class="position-relative">
                                            <input type="password" name="new_password_confirmation"
                                                class="form-control radius-8 @error('new_password_confirmation') is-invalid @enderror"
                                                id="new_password_confirmation" placeholder="Confirm New Password">
                                            <span
                                                class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light"
                                                data-toggle="#new_password_confirmation"></span>
                                        </div>
                                        @error('new_password_confirmation')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="d-flex align-items-center justify-content-center gap-3">
                                        <button type="submit"
                                            class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8">
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
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

        // Password Show/Hide Functionality
        function initializePasswordToggle(toggleSelector) {
            $(toggleSelector).on('click', function() {
                $(this).toggleClass("ri-eye-off-line");
                var input = $($(this).attr("data-toggle"));
                if (input.attr("type") === "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });
        }
        // Call the function
        initializePasswordToggle('.toggle-password');
    </script>
@endpush
