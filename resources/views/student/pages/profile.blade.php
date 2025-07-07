@extends('student.layouts.app')

@section('title', 'Student Profile')

@php
    $imgpath = 'storage/front/images/';
@endphp

@push('styles')
    <link href="{{ asset('studentpage/css/instructor-dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('studentpage/css/instructor-responsive.css') }}" rel="stylesheet">
    <style>
        .profile-card {
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .profile-image {
            margin: 0 auto 20px;
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #e0e0e0;
        }
        .basic_form .row {
            justify-content: center;
        }
        .ui.search.focus {
            margin-bottom: 20px;
        }
        .ui.left.icon.input {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }
        .prompt.srch_explore[readonly] {
            background: #f8f9fa;
            cursor: not-allowed;
        }
        .form-label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            text-align: left;
        }
    </style>
@endpush

@section('content')
<div class="sa4d25">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="st_title"><i class="uil uil-apps"></i> Student Profile</h2>
            </div>
            <div class="col-lg-12">
                <div class="account_setting profile-card">
                    <!-- Profile Image -->
                    <div class="profile-image-container">
                        @if ($student->photo)
                            <img src="{{ asset('storage/' . $student->photo) }}" alt="Profile Photo" class="profile-image">
                        @else
                            <img src="{{ asset($imgpath . 'default-avatar.png') }}" alt="Default Avatar" class="profile-image">
                        @endif
                    </div>
                    <div class="basic_profile">
                        <div class="basic_ptitle mb-10">
                            <h4>Basic Profile</h4>
                            <p>Information about yourself</p>
                        </div>
                        <hr>
                        <div class="basic_form">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <label class="form-label">First Name</label>
                                            <div class="ui search focus ">
                                                <div class="ui left icon input swdh11 swdh19">
                                                    <input class="prompt srch_explore" type="text" name="firstname" value="{{ $student->firstname }}" id="id_firstname" required="" maxlength="64" placeholder="First Name" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-label">Middle Name</label>
                                            <div class="ui search focus ">
                                                <div class="ui left icon input swdh11 swdh19">
                                                    <input class="prompt srch_explore" type="text" name="middlename" value="{{ $student->middlename }}" id="id_middlename" maxlength="64" placeholder="Middle Name" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-label">Last Name</label>
                                            <div class="ui search focus ">
                                                <div class="ui left icon input swdh11 swdh19">
                                                    <input class="prompt srch_explore" type="text" name="lastname" value="{{ $student->lastname }}" id="id_lastname" required="" maxlength="64" placeholder="Last Name" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-label">Date of Birth</label>
                                            <div class="ui search focus ">
                                                <div class="ui left icon input swdh11 swdh19">
                                                    <input class="prompt srch_explore" type="date" name="dob" value="{{ $student->dob }}" id="id_dob" required="" placeholder="Date of Birth" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <label class="form-label">Gender</label>
                                            <div class="ui search focus ">
                                                <div class="ui left icon input swdh11 swdh19">
                                                    <input class="prompt srch_explore" type="text" name="gender" value="{{ ucfirst($student->gender) }}" placeholder="Gender" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <label class="form-label">Blood Group</label>
                                            <div class="ui search focus ">
                                                <div class="ui left icon input swdh11 swdh19">
                                                    <input class="prompt srch_explore" type="text" name="blood_group" value="{{ $student->blood_group }}" id="id_blood_group" maxlength="10" placeholder="Blood Group" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <label class="form-label">State</label>
                                            <div class="ui search focus ">
                                                <div class="ui left icon input swdh11 swdh19">
                                                    <input class="prompt srch_explore" type="text" name="state" value="{{ $student->state }}" id="id_state" required="" maxlength="64" placeholder="State" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <label class="form-label">Country</label>
                                            <div class="ui search focus ">
                                                <div class="ui left icon input swdh11 swdh19">
                                                    <input class="prompt srch_explore" type="text" name="country" value="{{ $student->country }}" id="id_country" required="" maxlength="64" placeholder="Country" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <label class="form-label">Address</label>
                                            <div class="ui search focus ">
                                                <div class="ui left icon input swdh11 swdh19">
                                                    <input class="prompt srch_explore" type="text" name="address" value="{{ $student->address }}" id="id_address" required="" maxlength="100" placeholder="Address" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <label class="form-label">Religion</label>
                                            <div class="ui search focus ">
                                                <div class="ui left icon input swdh11 swdh19">
                                                    <input class="prompt srch_explore" type="text" name="religion" value="{{ ucfirst($student->religion) }}" id="id_religion" maxlength="64" placeholder="Religion" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-label">Registration Number</label>
                                            <div class="ui search focus ">
                                                <div class="ui left icon input swdh11 swdh19">
                                                    <input class="prompt srch_explore" type="text" name="regno" value="{{ $student->studentId }}" placeholder="Reg No" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-label">Admission Number</label>
                                            <div class="ui search focus ">
                                                <div class="ui left icon input swdh11 swdh19">
                                                    <input class="prompt srch_explore" type="text" name="admission_number" value="{{ $student->admission_number }}" id="id_admission_number" required="" maxlength="50" placeholder="Admission Number" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-label">Admission Date</label>
                                            <div class="ui search focus ">
                                                <div class="ui left icon input swdh11 swdh19">
                                                    <input class="prompt srch_explore" type="date" name="admission_date" value="{{ $student->admission_date }}" id="id_admission_date" required="" placeholder="Admission Date" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-label">Parent Name</label>
                                            <div class="ui search focus ">
                                                <div class="ui left icon input swdh11 swdh19">
                                                    <input class="prompt srch_explore" type="text" name="parent_fullname" value="{{ $student->parent->fullname ?? "N/A" }}" id="id_parent_fullname" required="" maxlength="100" placeholder="Parent Full Name" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-label">Class</label>
                                            <div class="ui search focus ">
                                                <div class="ui left icon input swdh11 swdh19">
                                                    <input class="prompt srch_explore" type="text" name="class_name" value="{{ $student->studentClass->class_name }}" id="id_class_name" required="" maxlength="100" placeholder="Class Name" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="divider-1"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('studentpage/js/custom1.js') }}"></script>
    <script>
        $('.remove-button').on('click', function() {
            $(this).closest('.alert').addClass('d-none');
        });
    </script>
@endpush
