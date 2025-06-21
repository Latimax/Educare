<!-- front/pages/faq.blade.php -->

@extends('front.layouts.app')

@section('title', ($schoolinfo->school_name ?? 'Educare School') . ' - FAQ')

@section('content')
    <!-- Start Page Title Area -->
    <div class="banner-area faq">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="container">
                    <div class="page-title-content">
                        <h2>FAQ at {{ $schoolinfo->school_name ?? 'Educare School' }}</h2>
                        <ul>
                            <li>
                                <a href="{{ url('/') }}"> Home </a>
                                <i class="flaticon-fast-forward"></i>
                                <p class="active">FAQ</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Title Area -->

    <!-- FAQ -->
    <div class="faq-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 faq-content">
                    <div class="faq-accordion">
                        <div class="section-tittle text-center">
                            <h2>Frequently Asked Questions</h2>
                        </div>
                        <ul class="accordion">
                            <li class="accordion-item">
                                <a class="accordion-title active" href="javascript:void(0)">
                                    <i class="fa fa-plus"></i> What facilities are available at the school?
                                </a>
                                <p class="accordion-content show">
                                    {{ $schoolinfo->school_name ?? 'Educare School' }} is equipped with modern facilities, including a well-stocked library, fully functional computer and science laboratories, clean toilets, and a secure perimeter fence. We also ensure a steady supply of water and electricity to support learning and student comfort.
                                </p>
                            </li>
                            <li class="accordion-item">
                                <a class="accordion-title" href="javascript:void(0)">
                                    <i class="fa fa-plus"></i> How does the school prepare students for WAEC and JAMB examinations?
                                </a>
                                <p class="accordion-content">
                                    Our curriculum is designed to align with WAEC and JAMB syllabi. We offer intensive revision classes, mock exams, and specialized coaching in core subjects to ensure students are well-prepared for these national examinations.
                                </p>
                            </li>
                            <li class="accordion-item">
                                <a class="accordion-title" href="javascript:void(0)">
                                    <i class="fa fa-plus"></i> What measures are in place to ensure student safety?
                                </a>
                                <p class="accordion-content">
                                    Student safety is a priority. The school is enclosed with a secure fence, monitored by trained security personnel. We also have a strict visitor policy and regular safety drills to ensure a safe learning environment.
                                </p>
                            </li>
                            <li class="accordion-item">
                                <a class="accordion-title" href="javascript:void(0)">
                                    <i class="fa fa-plus"></i> Are extracurricular activities available for students?
                                </a>
                                <p class="accordion-content">
                                    Yes, we offer a variety of extracurricular activities, including sports, cultural clubs, music, drama, and debate. These programs help develop students’ talents and foster teamwork and leadership skills.
                                </p>
                            </li>
                            <li class="accordion-item">
                                <a class="accordion-title" href="javascript:void(0)">
                                    <i class="fa fa-plus"></i> What is the admission process for new students?
                                </a>
                                <p class="accordion-content">
                                    Prospective students must complete an application form, available at the school office or online. They are required to sit for an entrance examination and attend an interview with their parents or guardians. Successful candidates receive admission offers with payment instructions.
                                </p>
                            </li>
                            <li class="accordion-item">
                                <a class="accordion-title" href="javascript:void(0)">
                                    <i class="fa fa-plus"></i> Does the school provide transportation services?
                                </a>
                                <p class="accordion-content">
                                    Yes, we offer transportation services with a fleet of well-maintained buses covering key areas within the city. Routes and fees are provided upon request during the admission process.
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End FAQ -->
@endsection
