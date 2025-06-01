@extends('admin.layouts.app')

@section('title', 'Create New Student')

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Students</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">New Student</li>
            </ul>
        </div>

        <div class="card basic-data-table">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Create New Student</h5>
                <a href="{{ route('admin.students.index') }}"
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
                <form action="{{ route('admin.students.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Personal Information -->
                    <h6 class="mb-3 mt-2">Personal Information</h6>
                    <div class="row">
                        <div class="col-sm-4 mb-20">
                            <label for="firstname" class="form-label">First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('firstname') is-invalid @enderror"
                                name="firstname" value="{{ old('firstname') }}" placeholder="Enter first name">
                            @error('firstname')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-4 mb-20">
                            <label for="middlename" class="form-label">Middle Name</label>
                            <input type="text" class="form-control @error('middlename') is-invalid @enderror"
                                name="middlename" value="{{ old('middlename') }}" placeholder="Enter middle name">
                            @error('middlename')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-4 mb-20">
                            <label for="lastname" class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('lastname') is-invalid @enderror"
                                name="lastname" value="{{ old('lastname') }}" placeholder="Enter last name">
                            @error('lastname')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-4 mb-20">
                            <label for="dob" class="form-label">Date of Birth <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('dob') is-invalid @enderror" name="dob"
                                value="{{ old('dob') }}">
                            @error('dob')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-4 mb-20">
                            <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                            <select name="gender" class="form-select @error('gender') is-invalid @enderror">
                                <option value="">-- Select Gender --</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('gender')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-4 mb-20">
                            <label for="blood_group" class="form-label">Blood Group</label>
                            <input type="text" class="form-control @error('blood_group') is-invalid @enderror"
                                name="blood_group" value="{{ old('blood_group') }}" placeholder="e.g. A+, O-, etc.">
                            @error('blood_group')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-6 mb-20">
                            <label for="religion" class="form-label">Religion  <span class="text-danger">*</span></label>
                            <select name="religion" class="form-select @error('religion') is-invalid @enderror">
                                <option value="">-- Select Religion --</option>
                                <option value="muslim" {{ old('religion') == 'muslim' ? 'selected' : '' }}>Muslim</option>
                                <option value="christian" {{ old('religion') == 'christian' ? 'selected' : '' }}>Christian
                                </option>
                            </select>
                            @error('religion')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-6 mb-20">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                name="photo" accept="image/*">
                            @error('photo')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-12 mb-20">
                            <label for="address" class="form-label">Address</label>
                            <textarea name="address" rows="2" class="form-control @error('address') is-invalid @enderror"
                                placeholder="Enter address">{{ old('address') }}</textarea>
                            @error('address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-6 mb-20">
                            <label for="state" class="form-label">State</label>
                            <input type="text" class="form-control @error('state') is-invalid @enderror"
                                name="state" value="{{ old('state') }}" placeholder="Enter state">
                            @error('state')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-6 mb-20">
                            <label for="country" class="form-label">Country</label>
                            <input type="text" class="form-control" name="country" value="Nigeria" readonly>
                        </div>
                    </div>

                    <!-- Admission Details -->
                    <h6 class="mb-3 mt-4">Admission Details</h6>
                    <div class="row">
                        <div class="col-sm-6 mb-20">
                            <label for="class_id" class="form-label">Class <span class="text-danger">*</span></label>
                            <select name="class_id" class="form-select @error('class_id') is-invalid @enderror">
                                <option value="">-- Select Class --</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}"
                                        {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->class_name ?? ($class->name ?? 'Class ' . $class->id) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('class_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-6 mb-20">
                            <label for="admission_number" class="form-label">Admission Number <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('admission_number') is-invalid @enderror"
                                name="admission_number" value="{{ $admission_number }}" readonly
                                placeholder="Enter admission number">
                            @error('admission_number')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-6 mb-20">
                            <label for="admission_date" class="form-label">Admission Date <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('admission_date') is-invalid @enderror"
                                name="admission_date" value="{{ old('admission_date') }}">
                            @error('admission_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-6 mb-20">
                            <label for="previous_school" class="form-label">Previous School</label>
                            <input type="text" class="form-control @error('previous_school') is-invalid @enderror"
                                name="previous_school" value="{{ old('previous_school') }}"
                                placeholder="Enter previous school">
                            @error('previous_school')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Parent/Guardian Information -->
                    <h6 class="mb-3 mt-4">Parent/Guardian Information</h6>
                    <div class="row">
                        <div class="col-sm-6 mb-20">
                            <label for="parent_id" class="form-label">Parent/Guardian </label>
                            <select name="parent_id" class="form-select @error('parent_id') is-invalid @enderror">
                                <option value="">-- Select Parent/Guardian --</option>
                                @foreach ($parents as $parent)
                                    <option value="{{ $parent->id }}"
                                        {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->fullname ?? ($parent->name ?? 'Parent ' . $parent->id) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Account Information -->
                    <h6 class="mb-3 mt-4">Account Information</h6>
                    <div class="row">

                        <div class="col-sm-6 mb-20">
                            <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('role') is-invalid @enderror"
                                name="role" value="{{ old('role') ?? 'Student' }}"
                                placeholder="Enter role (e.g. student)">
                            @error('role')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-6 mb-20">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('password') is-invalid @enderror"
                                name="password" value="{{ old('password') ?? '1234' }}" placeholder="Enter password">
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary">Create Student</button>
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
