@extends('admin.layouts.app')

@section('title', 'Create New Staff')

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
                <li class="fw-medium">New Staff</li>
            </ul>
        </div>

        <div class="card basic-data-table">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Create New Staff</h5>
                <a href="{{ route('admin.staffs.index') }}"
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
                <form action="{{ route('admin.staffs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Full Name -->
                        <div class="col-sm-6 mb-20">
                            <label for="fullname" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Full Name <span class="text-danger-600">*</span>
                            </label>
                            <input type="text" class="form-control radius-8 @error('fullname') is-invalid @enderror"
                                id="fullname" name="fullname" placeholder="Enter Full Name" value="{{ old('fullname') }}">
                            @error('fullname')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-sm-6 mb-20">
                            <label for="email" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Email <span class="text-danger-600">*</span>
                            </label>
                            <input type="email" class="form-control radius-8 @error('email') is-invalid @enderror"
                                id="email" name="email" placeholder="Enter Email" value="{{ old('email') }}">
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="col-sm-6 mb-20">
                            <label for="password" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Password <span class="text-danger-600">*</span>
                            </label>
                            <input type="text" class="form-control radius-8 @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="Enter Password">
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Photo -->
                        <div class="col-sm-6 mb-20">
                            <label for="photo" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Photo
                            </label>
                            <input type="file" class="form-control radius-8 @error('photo') is-invalid @enderror"
                                id="photo" name="photo" accept="image/*">
                            @error('photo')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="col-sm-6 mb-20">
                            <label for="phone" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Phone
                            </label>
                            <input type="text" class="form-control radius-8 @error('phone') is-invalid @enderror"
                                id="phone" name="phone" placeholder="Enter Phone" value="{{ old('phone') }}">
                            @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Date of Birth -->
                        <div class="col-sm-6 mb-20">
                            <label for="dob" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Date of Birth
                            </label>
                            <input type="date" class="form-control radius-8 @error('dob') is-invalid @enderror"
                                id="dob" name="dob" value="{{ old('dob') }}">
                            @error('dob')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Gender -->
                        <div class="col-sm-6 mb-20">
                            <label for="gender" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Gender <span class="text-danger-600">*</span>
                            </label>
                            <select name="gender" id="gender"
                                class="form-select radius-8 @error('gender') is-invalid @enderror">
                                <option value="">-- Select Gender --</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="col-sm-6 mb-20">
                            <label for="status" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Status <span class="text-danger-600">*</span>
                            </label>
                            <select name="status" id="status"
                                class="form-select radius-8 @error('status') is-invalid @enderror">
                                <option value="">-- Select Status --</option>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="disabled" {{ old('status') == 'disabled' ? 'selected' : '' }}>Disabled
                                </option>
                            </select>
                            @error('status')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Type -->
                        <div class="col-sm-6 mb-20">
                            <label for="user_type" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Staff Type <span class="text-danger-600">*</span>
                            </label>
                            <select name="user_type" id="user_type"
                                class="form-select radius-8 @error('user_type') is-invalid @enderror">
                                <option value="">-- Select Type --</option>
                                <option value="teacher" {{ old('user_type') == 'teacher' ? 'selected' : '' }}>Teacher
                                </option>
                                <option value="non-teaching" {{ old('user_type') == 'non-teaching' ? 'selected' : '' }}>
                                    Non-Teaching</option>
                                <option value="cleaner" {{ old('user_type') == 'cleaner' ? 'selected' : '' }}>Cleaner
                                </option>
                                <option value="driver" {{ old('user_type') == 'driver' ? 'selected' : '' }}>Driver
                                </option>
                                <option value="security" {{ old('user_type') == 'security' ? 'selected' : '' }}>Security
                                </option>
                                <option value="other" {{ old('user_type') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('user_type')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>



                        <!-- Department (Level) -->
                        <div class="col-sm-6 mb-20">
                            <label for="department" class="form-label">Department (Level)</label>
                            <select name="department" id="department"
                                class="form-control @error('department') is-invalid @enderror">
                                <option value="">-- Select Level --</option>
                                @foreach ($levels as $level)
                                    <option value="{{ $level->id }}"
                                        {{ old('department') == $level->id ? 'selected' : '' }}>
                                        {{ $level->level_name }}</option>
                                @endforeach
                            </select>
                            @error('department')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Position -->
                        <div class="col-sm-6 mb-20">
                            <label for="position" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Position
                            </label>
                            <input type="text" class="form-control radius-8 @error('position') is-invalid @enderror"
                                id="position" name="position" placeholder="Enter Position"
                                value="{{ old('position') }}">
                            @error('position')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Highest Qualification -->
                        <div class="col-sm-6 mb-20">
                            <label for="highest_qualification"
                                class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Highest Qualification
                            </label>
                            <input type="text"
                                class="form-control radius-8 @error('highest_qualification') is-invalid @enderror"
                                id="highest_qualification" name="highest_qualification"
                                placeholder="Enter Highest Qualification" value="{{ old('highest_qualification') }}">
                            @error('highest_qualification')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- State -->
                        <div class="col-sm-6 mb-20">
                            <label for="state" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                State
                            </label>
                            <input type="text" class="form-control radius-8 @error('state') is-invalid @enderror"
                                id="state" name="state" placeholder="Enter State" value="{{ old('state') }}">
                            @error('state')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Country -->
                        <div class="col-sm-6 mb-20">
                            <label for="country" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Country
                            </label>
                            <input type="text" class="form-control radius-8 @error('country') is-invalid @enderror"
                                id="country" name="country" placeholder="Enter Country" value="{{ old('country') }}">
                            @error('country')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Employment Date -->
                        <div class="col-sm-6 mb-20">
                            <label for="employment_date" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Employment Date
                            </label>
                            <input type="date"
                                class="form-control radius-8 @error('employment_date') is-invalid @enderror"
                                id="employment_date" name="employment_date" value="{{ old('employment_date') }}">
                            @error('employment_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Subject Specialty -->
                        <div class="col-sm-6 mb-20">
                            <label for="subject_specialty" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Subject Specialty
                            </label>
                            <input type="text"
                                class="form-control radius-8 @error('subject_specialty') is-invalid @enderror"
                                id="subject_specialty" name="subject_specialty" placeholder="Enter Subject Specialty"
                                value="{{ old('subject_specialty') }}">
                            @error('subject_specialty')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Create Staff</button>
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
