
@extends('admin.layouts.app')

@section('title', 'School Information Settings')

@section('content')

<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">School Information</h6>
    </div>

    <div class="card h-100 p-0 radius-12 overflow-hidden">
        <div class="card-body p-40">

            @if (session('success'))
                <div class="alert alert-success my-4">{{ session('success') }}</div>
            @endif

            <form action="{{ route('admin.school-info.update', $schoolinfo->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- === 1. Basic School Information === --}}
                <h6 class="mb-3">Basic Information</h6>
                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <label for="school_name" class="form-label">School Name</label>
                        <input type="text" class="form-control" id="school_name" name="school_name" value="{{ old('school_name', $schoolinfo->school_name ?? '') }}" required>
                        @error('school_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="short_name" class="form-label">Short Name</label>
                        <input type="text" class="form-control" id="short_name" name="short_name" value="{{ old('short_name', $schoolinfo->short_name ?? '') }}">
                        @error('short_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="school_motto" class="form-label">School Motto</label>
                        <input type="text" class="form-control" id="school_motto" name="school_motto" value="{{ old('school_motto', $schoolinfo->school_motto ?? '') }}">
                        @error('school_motto')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="school_type" class="form-label">School Type</label>
                        <select name="school_type" id="school_type" class="form-control" required>
                            <option value="primary" {{ old('school_type', $schoolinfo->school_type ?? '') == 'primary' ? 'selected' : '' }}>Primary</option>
                            <option value="secondary" {{ old('school_type', $schoolinfo->school_type ?? '') == 'secondary' ? 'selected' : '' }}>Secondary</option>
                            <option value="combined" {{ old('school_type', $schoolinfo->school_type ?? '') == 'combined' ? 'selected' : '' }}>Combined</option>
                        </select>
                        @error('school_type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- === 2. Contact & Address === --}}
                <h6 class="mb-3 mt-4">Contact & Address</h6>
                <div class="row">
                    <div class="col-sm-8 mb-3">
                        <label for="address" class="form-label">Full Address</label>
                        <textarea class="form-control" id="address" name="address">{{ old('address', $schoolinfo->address ?? '') }}</textarea>
                        @error('address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4 mb-3">
                        <label for="city" class="form-label">City</label>
                        <input type="text" class="form-control" id="city" name="city" value="{{ old('city', $schoolinfo->city ?? '') }}">
                        @error('city')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4 mb-3">
                        <label for="state" class="form-label">State</label>
                        <input type="text" class="form-control" id="state" name="state" value="{{ old('state', $schoolinfo->state ?? '') }}">
                        @error('state')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4 mb-3">
                        <label for="lga" class="form-label">LGA</label>
                        <input type="text" class="form-control" id="lga" name="lga" value="{{ old('lga', $schoolinfo->lga ?? '') }}">
                        @error('lga')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4 mb-3">
                        <label for="country" class="form-label">Country</label>
                        <input type="text" class="form-control" id="country" name="country" value="{{ old('country', $schoolinfo->country ?? 'Nigeria') }}">
                        @error('country')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $schoolinfo->phone ?? '') }}">
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4 mb-3">
                        <label for="phone_alt" class="form-label">Alternate Phone</label>
                        <input type="text" class="form-control" id="phone_alt" name="phone_alt" value="{{ old('phone_alt', $schoolinfo->phone_alt ?? '') }}">
                        @error('phone_alt')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $schoolinfo->email ?? '') }}">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4 mb-3">
                        <label for="owner_name" class="form-label">Owner Name</label>
                        <input type="text" class="form-control" id="owner_name" name="owner_name" value="{{ old('owner_name', $schoolinfo->owner_name ?? '') }}">
                        @error('owner_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- === 3. Location & Establishment === --}}
                <h6 class="mb-3 mt-4">Location & Establishment</h6>
                <div class="row">
                    <div class="col-sm-4 mb-3">
                        <label for="latitude" class="form-label">Latitude</label>
                        <input type="number" step="0.0000001" class="form-control" id="latitude" name="latitude" value="{{ old('latitude', $schoolinfo->latitude ?? '') }}">
                        @error('latitude')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4 mb-3">
                        <label for="longitude" class="form-label">Longitude</label>
                        <input type="number" step="0.0000001" class="form-control" id="longitude" name="longitude" value="{{ old('longitude', $schoolinfo->longitude ?? '') }}">
                        @error('longitude')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4 mb-3">
                        <label for="year_established" class="form-label">Year Established</label>
                        <input type="number" min="1800" max="{{ date('Y') }}" class="form-control" id="year_established" name="year_established" value="{{ old('year_established', $schoolinfo->year_established ?? '') }}">
                        @error('year_established')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- === 4. Meta Information === --}}
                <h6 class="mb-3 mt-4">Meta Information</h6>
                <div class="row">
                    <div class="col-sm-4 mb-3">
                        <label for="meta_description" class="form-label">Meta Description</label>
                        <textarea class="form-control" id="meta_description" name="meta_description">{{ old('meta_description', $schoolinfo->meta_description ?? '') }}</textarea>
                        @error('meta_description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4 mb-3">
                        <label for="meta_keywords" class="form-label">Meta Keywords</label>
                        <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $schoolinfo->meta_keywords ?? '') }}">
                        @error('meta_keywords')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- === 5. Social Media & Links === --}}
                <h6 class="mb-3 mt-4">Social Media & Links</h6>
                <div class="row">
                    <div class="col-sm-4 mb-3">
                        <label for="facebook" class="form-label">Facebook</label>
                        <input type="url" class="form-control" id="facebook" name="facebook" value="{{ old('facebook', $schoolinfo->facebook ?? '') }}">
                        @error('facebook')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4 mb-3">
                        <label for="youtube" class="form-label">YouTube</label>
                        <input type="url" class="form-control" id="youtube" name="youtube" value="{{ old('youtube', $schoolinfo->youtube ?? '') }}">
                        @error('youtube')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4 mb-3">
                        <label for="whatsapp" class="form-label">WhatsApp</label>
                        <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="{{ old('whatsapp', $schoolinfo->whatsapp ?? '') }}">
                        @error('whatsapp')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="website" class="form-label">Website</label>
                        <input type="url" class="form-control" id="website" name="website" value="{{ old('website', $schoolinfo->website ?? '') }}">
                        @error('website')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="google_map_src" class="form-label">Google Map (Embed URL)</label>
                        <input type="text" class="form-control" id="google_map_src" name="google_map_src" value="{{ old('google_map_src', $schoolinfo->google_map_src ?? '') }}">
                        @error('google_map_src')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- === 6. School Session Information === --}}
                <h6 class="mb-3 mt-4">School Session Information</h6>
                <div class="row">
                    <div class="col-sm-4 mb-3">
                         <label for="current_session" class="form-label">Current Session</label>
                        <select name="current_session" id="current_session" class="form-control">
                            @foreach ($sessions as $sessionData)
                             <option value="{{ $sessionData->session_name }}" {{ old('current_session', $schoolinfo->current_session ?? '') == $sessionData->session_name ? 'selected' : '' }}>{{ $sessionData->session_name }}</option>
                            @endforeach
                        </select>
                        @error('current_session')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4 mb-3">
                        <label for="current_term" class="form-label">Current Term</label>
                        <select name="current_term" id="current_term" class="form-control">
                            <option value="first" {{ old('current_term', $schoolinfo->current_term ?? '') == 'first' ? 'selected' : '' }}>First Term</option>
                            <option value="second" {{ old('current_term', $schoolinfo->current_term ?? '') == 'second' ? 'selected' : '' }}>Second Term</option>
                            <option value="third" {{ old('current_term', $schoolinfo->current_term ?? '') == 'third' ? 'selected' : '' }}>Third Term</option>
                        </select>
                        @error('current_term')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4 mb-3">
                        <label for="session_start_date" class="form-label">Session Start Date</label>
                        <input type="date" class="form-control" id="session_start_date" name="session_start_date" value="{{ old('session_start_date', $schoolinfo->session_start_date ?? '') }}">
                        @error('session_start_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4 mb-3">
                        <label for="session_end_date" class="form-label">Session End Date</label>
                        <input type="date" class="form-control" id="session_end_date" name="session_end_date" value="{{ old('session_end_date', $schoolinfo->session_end_date ?? '') }}">
                        @error('session_end_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4 mb-3">
                        <label for="school_opened" class="form-label">No. of Times School Opened</label>
                        <input type="number" class="form-control" id="school_opened" name="school_opened" value="{{ old('school_opened', $schoolinfo->school_opened ?? '') }}" min="0">
                        @error('school_opened')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4 mb-3">
                        <label for="next_term_begin_date" class="form-label">Next Term Begin Date</label>
                        <input type="date" class="form-control" id="next_term_begin_date" name="next_term_begin_date" value="{{ old('next_term_begin_date', $schoolinfo->next_term_begin_date ?? '') }}">
                        @error('next_term_begin_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                {{-- === 7. Branding: Logo & Favicon === --}}
                <h6 class="mb-3 mt-4">Branding</h6>
                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <label for="logo_path" class="form-label">School Logo</label>
                        <input type="file" class="form-control" id="logo_path" name="logo_path" accept="image/*">
                        @error('logo_path')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <img src="{{ asset('storage/front/images/logo.png') }}" alt="Current Logo" class="mt-2" style="height: 60px;">
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="favicon_path" class="form-label">Favicon</label>
                        <input type="file" class="form-control" id="favicon_path" name="favicon_path" accept="image/x-icon,image/png">
                        @error('favicon_path')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <img src="{{ asset('storage/front/images/favicon.png') }}" alt="Current Favicon" class="mt-2" style="height: 32px;">
                    </div>
                    <div class="col-sm-6 mb-3 bordered">
                        <label for="darklogo_path" class="form-label">School Logo (Dark)</label>
                        <input type="file" class="form-control" id="darklogo_path" name="darklogo_path" accept="image/*">
                        @error('darklogo_path')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <img src="{{ asset('storage/front/images/white-logo.png') }}" alt="Current Logo Dark" class="mt-2" style="height: 60px;">
                    </div>
                </div>
                {{-- === 7. Submit === --}}
                <div class="d-flex align-items-center justify-content-center gap-3 mt-24">
                    <button type="submit" class="btn btn-primary text-md px-24 py-12 radius-8">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
