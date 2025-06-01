
@extends('admin.layouts.app')

@section('title', 'Edit Student')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Edit Student Information</h6>
    </div>

    <div class="card h-100 p-0 radius-12 overflow-hidden">
        <div class="card-body p-40">

            @if (session('success'))
                <div class="alert alert-success my-4">{{ session('success') }}</div>
            @endif

            <form action="{{ route('admin.students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Personal Information -->
                <h6 class="mb-3 mt-2">Personal Information</h6>
                <div class="row">
                    <div class="col-sm-4 mb-3">
                        <label for="firstname" class="form-label">First Name</label>
                        <input type="text"
                               class="form-control @error('firstname') is-invalid @enderror"
                               id="firstname"
                               name="firstname"
                               value="{{ old('firstname', $student->firstname) }}"
                               required>
                        @error('firstname')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4 mb-3">
                        <label for="middlename" class="form-label">Middle Name</label>
                        <input type="text"
                               class="form-control @error('middlename') is-invalid @enderror"
                               id="middlename"
                               name="middlename"
                               value="{{ old('middlename', $student->middlename) }}">
                        @error('middlename')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4 mb-3">
                        <label for="lastname" class="form-label">Last Name</label>
                        <input type="text"
                               class="form-control @error('lastname') is-invalid @enderror"
                               id="lastname"
                               name="lastname"
                               value="{{ old('lastname', $student->lastname) }}"
                               required>
                        @error('lastname')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4 mb-3">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="date"
                               class="form-control @error('dob') is-invalid @enderror"
                               id="dob"
                               name="dob"
                               value="{{ old('dob', $student->dob) }}">
                        @error('dob')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4 mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror">
                            <option value="">-- Select --</option>
                            <option value="male" {{ old('gender', $student->gender) == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $student->gender) == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('gender')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4 mb-3">
                        <label for="blood_group" class="form-label">Blood Group</label>
                        <input type="text"
                               class="form-control @error('blood_group') is-invalid @enderror"
                               id="blood_group"
                               name="blood_group"
                               value="{{ old('blood_group', $student->blood_group) }}">
                        @error('blood_group')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="religion" class="form-label">Religion</label>
                        <select name="religion" id="religion" class="form-control @error('religion') is-invalid @enderror">
                            <option value="">-- Select Religion --</option>
                            <option value="muslim" {{ old('religion', $student->religion) == 'muslim' ? 'selected' : '' }}>Muslim</option>
                            <option value="christian" {{ old('religion', $student->religion) == 'christian' ? 'selected' : '' }}>Christian</option>
                        </select>
                        @error('religion')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="photo" class="form-label">Photo</label>
                        <input type="file"
                               class="form-control @error('photo') is-invalid @enderror"
                               id="photo"
                               name="photo" accept="image/*">
                        @if($student->photo)
                            <img src="{{ asset('storage/' . $student->photo) }}" alt="Current Photo" class="mt-2" style="height: 80px; border-radius: 8px;">
                        @endif

                        @error('photo')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-12 mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea name="address" rows="2" class="form-control @error('address') is-invalid @enderror"
                            id="address"
                            placeholder="Enter address">{{ old('address', $student->address) }}</textarea>
                        @error('address')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="state" class="form-label">State</label>
                        <input type="text"
                               class="form-control @error('state') is-invalid @enderror"
                               id="state"
                               name="state"
                               value="{{ old('state', $student->state) }}">
                        @error('state')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="country" class="form-label">Country</label>
                        <input type="text"
                               class="form-control @error('country') is-invalid @enderror"
                               id="country"
                               name="country"
                               value="{{ old('country', $student->country ?? 'Nigeria') }}" readonly>
                        @error('country')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Admission Details -->
                <h6 class="mb-3 mt-4">Admission Details</h6>
                <div class="row">
                    <div class="col-sm-4 mb-3">
                        <label for="class_id" class="form-label">Class</label>
                        <select name="class_id" id="class_id" class="form-control @error('class_id') is-invalid @enderror">
                            <option value="">-- Select Class --</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}" {{ old('class_id', $student->class_id) == $class->id ? 'selected' : '' }}>
                                    {{ $class->class_name ?? $class->name ?? 'Class '.$class->id }}
                                </option>
                            @endforeach
                        </select>
                        @error('class_id')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4 mb-3">
                        <label for="admission_number" class="form-label">Admission Number</label>
                        <input type="text"
                               class="form-control @error('admission_number') is-invalid @enderror"
                               id="admission_number"
                               name="admission_number"
                               value="{{ old('admission_number', $student->admission_number) }}" readonly>
                        @error('admission_number')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4 mb-3">
                        <label for="admission_date" class="form-label">Admission Date</label>
                        <input type="date"
                               class="form-control @error('admission_date') is-invalid @enderror"
                               id="admission_date"
                               name="admission_date"
                               value="{{ old('admission_date', $student->admission_date) }}">
                        @error('admission_date')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="previous_school" class="form-label">Previous School</label>
                        <input type="text"
                               class="form-control @error('previous_school') is-invalid @enderror"
                               id="previous_school"
                               name="previous_school"
                               value="{{ old('previous_school', $student->previous_school) }}">
                        @error('previous_school')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Parent/Guardian Information -->
                <h6 class="mb-3 mt-4">Parent/Guardian Information</h6>
                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <label for="parent_id" class="form-label">Parent/Guardian</label>
                        <select name="parent_id" id="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
                            <option value="">-- Select Parent/Guardian --</option>
                            @foreach ($parents as $parent)
                                <option value="{{ $parent->id }}" {{ old('parent_id', $student->parent_id) == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->fullname ?? $parent->name ?? 'Parent '.$parent->id }}
                                </option>
                            @endforeach
                        </select>
                        @error('parent_id')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Account Information -->
                <h6 class="mb-3 mt-4">Account Information</h6>
                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="active" {{ old('status', $student->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="suspended" {{ old('status', $student->status) == 'suspended' ? 'selected' : '' }}>Suspended</option>
                        </select>
                        @error('status')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="role" class="form-label">Role</label>
                        <input type="text"
                               class="form-control @error('role') is-invalid @enderror"
                               id="role"
                               name="role"
                               value="{{ old('role', $student->role) }}">
                        @error('role')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="password" class="form-label">Password <small>(leave blank to keep current)</small></label>
                        <input type="text"
                               class="form-control @error('password') is-invalid @enderror"
                               id="password"
                               name="password">
                        @error('password')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Submit --}}
                <div class="d-flex align-items-center justify-content-center gap-3 mt-24">
                    <a href="{{ route('admin.students.index') }}" class="btn btn-danger text-md px-24 py-12 radius-8">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary text-md px-24 py-12 radius-8">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
