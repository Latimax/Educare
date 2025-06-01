
@extends('admin.layouts.app')

@section('title', 'Edit Subject')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Edit Subject Information</h6>
    </div>

    <div class="card h-100 p-0 radius-12 overflow-hidden">
        <div class="card-body p-40">

            @if (session('success'))
                <div class="alert alert-success my-4">{{ session('success') }}</div>
            @endif

            <form action="{{ route('admin.subjects.update', $subject->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Subject Name -->
                    <div class="col-sm-6 mb-3">
                        <label for="subject_name" class="form-label">Subject Name <span class="text-danger-600">*</span></label>
                        <input type="text"
                               class="form-control @error('subject_name') is-invalid @enderror"
                               id="subject_name"
                               name="subject_name"
                               value="{{ old('subject_name', $subject->subject_name) }}"
                               required>
                        @error('subject_name')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Subject Code -->
                    <div class="col-sm-6 mb-3">
                        <label for="subject_code" class="form-label">Subject Code <span class="text-danger-600">*</span></label>
                        <input type="text"
                               class="form-control @error('subject_code') is-invalid @enderror"
                               id="subject_code"
                               name="subject_code"
                               value="{{ old('subject_code', $subject->subject_code) }}"
                               required>
                        @error('subject_code')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Staff (Teacher) -->
                    <div class="col-sm-6 mb-3">
                        <label for="staff_id" class="form-label">Staff <span class="text-danger-600">*</span></label>
                        <select name="staff_id" id="staff_id" class="form-control @error('staff_id') is-invalid @enderror" required>
                            <option value="">-- Select Staff --</option>
                            @foreach($staffs as $staff)
                                <option value="{{ $staff->id }}" {{ old('staff_id', $subject->staff_id) == $staff->id ? 'selected' : '' }}>
                                    {{ $staff->fullname }}
                                </option>
                            @endforeach
                        </select>
                        @error('staff_id')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Level -->
                    <div class="col-sm-3 mb-3">
                        <label for="level_id" class="form-label">Level <span class="text-danger-600">*</span></label>
                        <select name="level_id" id="level_id" class="form-control @error('level_id') is-invalid @enderror" required>
                            <option value="">-- Select Level --</option>
                            @foreach($levels as $level)
                                <option value="{{ $level->id }}" {{ old('level_id', $subject->level_id) == $level->id ? 'selected' : '' }}>{{ $level->level_name }}</option>
                            @endforeach
                        </select>
                        @error('level_id')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                     <!-- Status -->
                    <div class="col-sm-3 mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger-600">*</span></label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                            <option value="active" {{ old('status', $subject->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="disabled" {{ old('status', $subject->status) == 'disabled' ? 'selected' : '' }}>Disable</option>
                        </select>
                        @error('status')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                </div>


                <!-- Submit/Cancel Buttons -->
                <div class="d-flex align-items-center justify-content-center gap-3 mt-24">
                    <a href="{{ route('admin.subjects.index') }}" class="btn btn-danger text-md px-24 py-12 radius-8">
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
