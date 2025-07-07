{{-- resources/views/admin/pages/profile.blade.php --}}

@extends('staff.layouts.app')

@section('title', 'Staff Profile')

@php
    $imgpath = 'storage/front/images/';
    // Check if the request has an 'activeTab' parameter or if there are errors in the change password fields
    $changePasswordError =
        $errors->has('current_password') || $errors->has('new_password') || $errors->has('new_password_confirmation');
    // default to 'profile' unless the request indicates 'change' or there are password errors
    $activeTab = request('activeTab') ? request('activeTab') : ($changePasswordError ? 'change' : 'profile');
@endphp

@section('content')

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">View Staff Profile</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('staff.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">View Staff Profile</li>
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
                    @if ($staff->photo)
                        <img src="{{ asset('storage/' . $staff->photo) }}" alt=""
                            class="w-100 mb-12 object-fit-cover">
                    @else
                        <img src="{{ asset($imgpath . 'default-avatar.png') }}" alt="default"
                            class="w-100 mb-12 object-fit-cover">
                    @endif
                    <div class="pb-24 ms-16 mb-24 me-16  mt--100">
                        <div class="text-center mt-12 border border-top-0 border-start-0 border-end-0">
                            <h6 class="mb-0 mt-32">{{ $staff->fullname }}</h6>
                            <span class="text-secondary-light mb-16">{{ $staff->position }}</span>
                        </div>
                        <div class="mt-32">
                            <h6 class="text-xl mb-16">Personal Info</h6>
                            <ul>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Staff ID</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{ $staff->staffId }}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Full Name</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{ $staff->fullname }}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Email</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{ $staff->email }}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Phone Number</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{ $staff->phone }}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Date of Birth</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{ $staff->dob }}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">State</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{ $staff->state }}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Country</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{ $staff->country }}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Gender</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{ $staff->gender }}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Highest Qualification</span>
                                    <span class="w-70 text-secondary-light fw-medium">:
                                        {{ $staff->highest_qualification }}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Position</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{ $staff->position }}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Department</span>
                                    <span class="w-70 text-secondary-light fw-medium">:
                                        {{ $staff->departmentLevel->level_name }}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Subject Specialty</span>
                                    <span class="w-70 text-secondary-light fw-medium">:
                                        {{ $staff->subject_specialty }}</span>
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
                                <h6 class="text-md text-primary-light mb-16">Profile Image</h6>
                                <form action="{{ route('staff.profile') }}" method="POST"
                                    enctype="multipart/form-data">
                                    <div class="mb-24 mt-16">
                                        <div class="avatar-upload"
                                            style="background-image: url('{{ asset('storage/' . $staff->photo) }}'); background-size: cover; background-position: center; height: 150px; width: 150px; border-radius: 50%;">
                                            <div class="position-absolute bottom-0 end-0 me-24 mt-16 z-1 cursor-pointer">
                                                <input type='file' id="profile_image" name="photo"
                                                    accept=".png, .jpg, .jpeg" hidden>
                                                <label for="profile_image"
                                                    class="w-32-px h-32-px d-flex justify-content-center align-items-center bg-primary-50 text-primary-600 border border-primary-600 bg-hover-primary-100 text-lg rounded-circle">
                                                    <iconify-icon icon="solar:camera-outline"
                                                        class="icon"></iconify-icon>
                                                </label>
                                            </div>
                                            <div class="avatar-preview">
                                                <div id="imagePreview"></div>
                                            </div>
                                        </div>
                                        @error('photo')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-20">
                                                <label for="fullname"
                                                    class="form-label fw-semibold text-primary-light text-sm mb-8">
                                                    Full Name <span class="text-danger-600">*</span>
                                                </label>
                                                <input type="text" name="fullname"
                                                    class="form-control radius-8 @error('fullname') is-invalid @enderror"
                                                    id="fullname" placeholder="Enter Full Name"
                                                    value="{{ old('fullname', $staff->fullname ?? '') }}">
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
                                                    value="{{ old('email', $staff->email ?? '') }}">
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
                                                    id="phone" placeholder="Enter Phone Number"
                                                    value="{{ old('phone', $staff->phone ?? '') }}">
                                                @error('phone')
                                                    <span class="text-danger text-sm">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="mb-20">
                                                <label for="dob"
                                                    class="form-label fw-semibold text-primary-light text-sm mb-8">
                                                    Date of Birth
                                                </label>
                                                <input type="date" name="dob"
                                                    class="form-control radius-8 @error('dob') is-invalid @enderror"
                                                    id="dob" placeholder="Select Date of Birth"
                                                    value="{{ old('dob', $staff->dob ?? '') }}">
                                                @error('dob')
                                                    <span class="text-danger text-sm">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="mb-20">
                                                <label for="state"
                                                    class="form-label fw-semibold text-primary-light text-sm mb-8">
                                                    State
                                                </label>
                                                <input type="text" name="state"
                                                    class="form-control radius-8 @error('state') is-invalid @enderror"
                                                    id="state" placeholder="Enter State"
                                                    value="{{ old('state', $staff->state ?? '') }}">
                                                @error('state')
                                                    <span class="text-danger text-sm">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="mb-20">
                                                <label for="country"
                                                    class="form-label fw-semibold text-primary-light text-sm mb-8">
                                                    Country
                                                </label>
                                                <input type="text" name="country"
                                                    class="form-control radius-8 @error('country') is-invalid @enderror"
                                                    id="country" placeholder="Enter Country"
                                                    value="{{ old('country', $staff->country ?? '') }}">
                                                @error('country')
                                                    <span class="text-danger text-sm">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="mb-20">
                                                <label for="gender"
                                                    class="form-label fw-semibold text-primary-light text-sm mb-8">
                                                    Gender
                                                </label>
                                                <select name="gender"
                                                    class="form-control radius-8 @error('gender') is-invalid @enderror"
                                                    id="gender">
                                                    <option value="">Select Gender</option>
                                                    <option value="Male"
                                                        {{ old('gender', $staff->gender ?? '') == 'male' ? 'selected' : '' }}>
                                                        Male</option>
                                                    <option value="Female"
                                                        {{ old('gender', $staff->gender ?? '') == 'female' ? 'selected' : '' }}>
                                                        Female</option>
                                                    <option value="Other"
                                                        {{ old('gender', $staff->gender ?? '') == 'other' ? 'selected' : '' }}>
                                                        Other</option>
                                                </select>
                                                @error('gender')
                                                    <span class="text-danger text-sm">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="mb-20">
                                                <label for="subject_specialty"
                                                    class="form-label fw-semibold text-primary-light text-sm mb-8">
                                                    Subject Specialty
                                                </label>
                                                <input type="text" name="subject_specialty"
                                                    class="form-control radius-8 @error('subject_specialty') is-invalid @enderror"
                                                    id="subject_specialty" placeholder="Enter Subject Specialty"
                                                    value="{{ old('subject_specialty', $staff->subject_specialty ?? '') }}">
                                                @error('subject_specialty')
                                                    <span class="text-danger text-sm">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-center gap-3">
                                        <a href="{{ route('staff.dashboard') }}"
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

                            <form action="{{ route('staff.change-password') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="tab-pane fade {{ $activeTab == 'change' ? 'show active' : '' }}"
                                    id="pills-change-passwork" role="tabpanel"
                                    aria-labelledby="pills-change-passwork-tab" tabindex="0">
                                    <div class="mb-20">
                                        <label for="current_password"
                                            class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            Old Password <span class="text-danger-600">*</span>
                                        </label>
                                        <div class="position-relative">
                                            <input type="password" name="current_password"
                                                class="form-control radius-8 @error('current_password') is-invalid @enderror"
                                                id="current_password" placeholder="Enter Old Password*">
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
                                                id="new_password" placeholder="Enter New Password*">
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
                                                id="new_password_confirmation" placeholder="Confirm Password*">
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
            $(this).closest('.alert').addClass('d-none')
        });

        // ======================== Upload Image Start =====================
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                    $('#imagePreview').hide();
                    $('#imagePreview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#profile_image").change(function() {
            readURL(this);
        });
        // ======================== Upload Image End =====================

        // ================== Password Show Hide Js Start ==========
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
        // ========================= Password Show Hide Js End ===========================
    </script>
@endpush
