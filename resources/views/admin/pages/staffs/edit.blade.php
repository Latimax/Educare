
@extends('admin.layouts.app')

@section('title', 'Edit Staff')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Edit Staff Information</h6>
    </div>

    <div class="card h-100 p-0 radius-12 overflow-hidden">
        <div class="card-body p-40">

            @if (session('success'))
                <div class="alert alert-success my-4">{{ session('success') }}</div>
            @endif

            <form action="{{ route('admin.staffs.update', $staff->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Full Name -->
                    <div class="col-sm-6 mb-3">
                        <label for="fullname" class="form-label">Full Name</label>
                        <input type="text"
                               class="form-control @error('fullname') is-invalid @enderror"
                               id="fullname"
                               name="fullname"
                               value="{{ old('fullname', $staff->fullname) }}"
                               required>
                        @error('fullname')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="col-sm-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               id="email"
                               name="email"
                               value="{{ old('email', $staff->email) }}">
                        @error('email')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="col-sm-6 mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text"
                               class="form-control @error('phone') is-invalid @enderror"
                               id="phone"
                               name="phone"
                               value="{{ old('phone', $staff->phone) }}">
                        @error('phone')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Date of Birth -->
                    <div class="col-sm-6 mb-3">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="date"
                               class="form-control @error('dob') is-invalid @enderror"
                               id="dob"
                               name="dob"
                               value="{{ old('dob', $staff->dob) }}">
                        @error('dob')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Gender -->
                    <div class="col-sm-6 mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror">
                            <option value="">-- Select --</option>
                            <option value="male" {{ old('gender', $staff->gender) == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $staff->gender) == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender', $staff->gender) == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- State -->
                    <div class="col-sm-6 mb-3">
                        <label for="state" class="form-label">State</label>
                        <input type="text"
                               class="form-control @error('state') is-invalid @enderror"
                               id="state"
                               name="state"
                               value="{{ old('state', $staff->state) }}">
                        @error('state')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Country -->
                    <div class="col-sm-6 mb-3">
                        <label for="country" class="form-label">Country</label>
                        <input type="text"
                               class="form-control @error('country') is-invalid @enderror"
                               id="country"
                               name="country"
                               value="{{ old('country', $staff->country) }}">
                        @error('country')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Position -->
                    <div class="col-sm-6 mb-3">
                        <label for="position" class="form-label">Position</label>
                        <input type="text"
                               class="form-control @error('position') is-invalid @enderror"
                               id="position"
                               name="position"
                               value="{{ old('position', $staff->position) }}">
                        @error('position')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Highest Qualification -->
                    <div class="col-sm-6 mb-3">
                        <label for="highest_qualification" class="form-label">Highest Qualification</label>
                        <input type="text"
                               class="form-control @error('highest_qualification') is-invalid @enderror"
                               id="highest_qualification"
                               name="highest_qualification"
                               value="{{ old('highest_qualification', $staff->highest_qualification) }}">
                        @error('highest_qualification')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- User Type -->
                    <div class="col-sm-6 mb-3">
                        <label for="user_type" class="form-label">User Type</label>
                        <select name="user_type" id="user_type" class="form-control @error('user_type') is-invalid @enderror" required>
                            @foreach(['teacher', 'non-teaching', 'cleaner', 'driver', 'security', 'other'] as $type)
                                <option value="{{ $type }}" {{ old('user_type', $staff->user_type) == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                            @endforeach
                        </select>
                        @error('user_type')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-sm-6 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="active" {{ old('status', $staff->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="disabled" {{ old('status', $staff->status) == 'disabled' ? 'selected' : '' }}>Disabled</option>
                        </select>
                        @error('status')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Employment Date -->
                    <div class="col-sm-6 mb-3">
                        <label for="employment_date" class="form-label">Employment Date</label>
                        <input type="date"
                               class="form-control @error('employment_date') is-invalid @enderror"
                               id="employment_date"
                               name="employment_date"
                               value="{{ old('employment_date', $staff->employment_date) }}">
                        @error('employment_date')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Subject Specialty -->
                    <div class="col-sm-6 mb-3">
                        <label for="subject_specialty" class="form-label">Subject Specialty</label>
                        <input type="text"
                               class="form-control @error('subject_specialty') is-invalid @enderror"
                               id="subject_specialty"
                               name="subject_specialty"
                               value="{{ old('subject_specialty', $staff->subject_specialty) }}">
                        @error('subject_specialty')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Department (Level) -->
                    <div class="col-sm-6 mb-3">
                        <label for="department" class="form-label">Department (Level)</label>
                        <select name="department" id="department" class="form-control @error('department') is-invalid @enderror">
                            <option value="">-- Select Level --</option>
                            @foreach($levels as $level)
                                <option value="{{ $level->id }}" {{ old('department', $staff->department) == $level->id ? 'selected' : '' }}>{{ $level->level_name }}</option>
                            @endforeach
                        </select>
                        @error('department')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Photo -->
                    <div class="col-sm-6 mb-3">
                        <label for="photo" class="form-label">Photo</label>
                        <input type="file"
                               class="form-control @error('photo') is-invalid @enderror"
                               id="photo"
                               name="photo" accept="image/*">
                        @if($staff->photo)
                            <img src="{{ asset('storage/' . $staff->photo) }}" alt="Current Photo" class="mt-2" style="height: 80px; border-radius: 8px;">
                        @endif
                        @error('photo')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password -->
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

                    <a href="{{ route('admin.staffs.index') }}" class="btn btn-danger text-md px-24 py-12 radius-8">
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
