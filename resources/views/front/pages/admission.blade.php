<!-- front/pages/admission.blade.php -->

@extends('front.layouts.app')

@section('title', ($schoolinfo->school_name ?? 'Educare School') . ' - Admission')

@section('content')
    <!-- Start Page Title Area -->
    <div class="banner-area admission">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="container">
                    <div class="page-title-content">
                        <h2>Admission to {{ $schoolinfo->school_name ?? 'Educare School' }}</h2>
                        <ul>
                            <li>
                                <a href="{{ url('/') }}"> Home </a>
                                <i class="flaticon-fast-forward"></i>
                                <p class="active">Admission</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Title Area -->

    <!-- Service Area -->
    <div class="admission-service">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-sm-6">
                    <div class="single-service text-center">
                        <div class="service-icon">
                            <i class="flaticon-clock"></i>
                        </div>
                        <div class="service-content">
                            <p>{{ $schoolinfo->admission_hours ?? 'Mon - Fri: 8:00AM - 4:00PM' }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="single-service text-center">
                        <div class="service-icon">
                            <i class="flaticon-pin"></i>
                        </div>
                        <div class="service-content">
                            <p>{{ $schoolinfo->address ?? '123 Ikorodu Road, Lagos, Nigeria' }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <div class="single-service text-center sst-10">
                        <div class="service-icon">
                            <i class="flaticon-telephone"></i>
                        </div>
                        <div class="service-content">
                            <a href="tel:{{ $schoolinfo->phone ?? '+2348031234567' }}">{{ $schoolinfo->phone ?? '+234 803 123 4567' }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Service Area -->

    <!-- Admission Area -->
    <section class="admission-area">
        <div class="container">
            <div class="section-tittle">
                <h2>Admission Rules</h2>
                <p>
                    To apply for admission at {{ $schoolinfo->school_name ?? 'Educare School' }}, candidates must complete the form below, submit required documents, and pass an entrance examination and interview. Applications are processed within two weeks, and successful candidates will be notified via email or phone. Ensure all information is accurate and documents are provided in the specified formats.
                </p>
            </div>
            <div class="admission-form">
                <h2>Admission Form</h2>
                <form id="admissionForm" action="{{ url('admission') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <h4>Student Information</h4>
                        <div class="form-group col-md-6">
                            <label>First Name</label>
                            <input type="text" name="first_name" id="first_name" class="form-control" required placeholder="First Name" />
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Last Name</label>
                            <input type="text" name="last_name" id="last_name" class="form-control" required placeholder="Last Name" />
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Date of Birth</label>
                            <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" required placeholder="Date of Birth" max="2095-12-31" />
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Gender</label>
                            <select name="gender" id="gender" class="form-control" required>
                                <option value="" disabled selected>Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Nationality</label>
                            <input type="text" name="nationality" id="nationality" class="form-control" required placeholder="Nationality" />
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>State of Origin</label>
                            <input type="text" name="state_of_origin" id="state_of_origin" class="form-control" required placeholder="State of Origin" />
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Home Address</label>
                            <input type="text" name="home_address" id="home_address" class="form-control" required placeholder="Home Address" />
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Class Applying For</label>
                            <select name="class_applying_for" id="class_applying_for" class="form-control" required>
                                <option value="" disabled selected>Select Class</option>
                                <option value="Kindergarten">Kindergarten</option>
                                <option value="Primary 1">Primary 1</option>
                                <option value="Primary 2">Primary 2</option>
                                <option value="Primary 3">Primary 3</option>
                                <option value="Primary 4">Primary 4</option>
                                <option value="Primary 5">Primary 5</option>
                                <option value="Primary 6">Primary 6</option>
                                <option value="JSS 1">JSS 1</option>
                                <option value="JSS 2">JSS 2</option>
                                <option value="JSS 3">JSS 3</option>
                                <option value="SSS 1">SSS 1</option>
                                <option value="SSS 2">SSS 2</option>
                                <option value="SSS 3">SSS 3</option>
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Religion (Optional)</label>
                            <input type="text" name="religion" id="religion" class="form-control" placeholder="Religion" />
                            <div class="help-block with-errors"></div>
                        </div>
                        <h4>Parent/Guardian Information</h4>
                        <div class="form-group col-md-6">
                            <label>Parent/Guardian First Name</label>
                            <input type="text" name="parent_first_name" id="parent_first_name" class="form-control" required placeholder="Parent/Guardian First Name" />
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Parent/Guardian Last Name</label>
                            <input type="text" name="parent_last_name" id="parent_last_name" class="form-control" required placeholder="Parent/Guardian Last Name" />
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Parent/Guardian Email</label>
                            <input type="email" name="parent_email" id="parent_email" class="form-control" required placeholder="Parent/Guardian Email" />
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Parent/Guardian Phone Number</label>
                            <input type="tel" name="parent_phone_number" id="parent_phone_number" class="form-control" required placeholder="Parent/Guardian Phone Number" />
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Parent/Guardian Occupation</label>
                            <input type="text" name="parent_occupation" id="parent_occupation" class="form-control" required placeholder="Parent/Guardian Occupation" />
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Parent/Guardian Address</label>
                            <input type="text" name="parent_address" id="parent_address" class="form-control" required placeholder="Parent/Guardian Address" />
                            <div class="help-block with-errors"></div>
                        </div>
                        <h4>Previous School Information</h4>
                        <div class="form-group col-md-12">
                            <label>Previous School Name (Optional)</label>
                            <input type="text" name="previous_school_name" id="previous_school_name" class="form-control" placeholder="Previous School Name" />
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Previous School Address (Optional)</label>
                            <input type="text" name="previous_school_address" id="previous_school_address" class="form-control" placeholder="Previous School Address" />
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Last Class Attended (Optional)</label>
                            <input type="text" name="last_class_attended" id="last_class_attended" class="form-control" placeholder="Last Class Attended" />
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Reason for Leaving (Optional)</label>
                            <input type="text" name="reason_for_leaving" id="reason_for_leaving" class="form-control" placeholder="Reason for Leaving" />
                            <div class="help-block with-errors"></div>
                        </div>
                        <h4>Medical Information</h4>
                        <div class="form-group col-md-12">
                            <label>Medical Conditions or Allergies (Optional)</label>
                            <textarea name="medical_conditions" id="medical_conditions" class="form-control" cols="30" rows="3" placeholder="Medical Conditions or Allergies"></textarea>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Emergency Contact Name</label>
                            <input type="text" name="emergency_contact_name" id="emergency_contact_name" class="form-control" required placeholder="Emergency Contact Name" />
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Emergency Contact Phone Number</label>
                            <input type="tel" name="emergency_contact_phone" id="emergency_contact_phone" class="form-control" required placeholder="Emergency Contact Phone Number" />
                            <div class="help-block with-errors"></div>
                        </div>

                        <h4>Additional Information</h4>
                        <div class="form-group col-md-12">
                            <label>Additional Notes or Special Requirements (Optional)</label>
                            <textarea name="additional_notes" id="additional_notes" class="form-control" cols="30" rows="5" placeholder="Any Additional Notes or Special Requirements"></textarea>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-check col-md-12">
                            <input class="form-check-input" type="checkbox" name="agree_terms" id="agree_terms" required />
                            <label class="form-check-label" for="agree_terms">
                                I agree to all terms and conditions
                            </label>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="box-btn">Submit Application</button>
                            <div id="msgSubmit" class="h3 text-center hidden"></div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- End Admission Area -->
@endsection
