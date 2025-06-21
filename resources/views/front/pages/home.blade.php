@extends('front.layouts.app')

@section('title', $schoolinfo->school_name ?? 'Educare School')

@section('content')
    <!-- Slider area -->
    <section class="slider-area">
        <div class="home-slider owl-carousel owl-theme">
            <div class="single-slider single-slider-bg-1">
                <div class="d-table">
                    <div class="d-table-cell">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-lg-12 text-center">
                                    <div class="slider-tittle one">
                                        <h1>
                                            Nurturing <span>{{ 'Your Child\'s Future' }}</span>
                                        </h1>
                                        <p>
                                            At {{ $schoolinfo->school_name ?? 'Educare' }}, we provide a holistic
                                            education for Kindergarten, Primary, Junior, and Secondary students, fostering
                                            academic excellence and personal growth in a supportive environment.
                                        </p>
                                    </div>
                                    <div class="slider-btn bnt1 text-center">
                                        <a href="{{ url('admission') }}" class="box-btn">Admission</a>
                                        <a href="{{ url('classes') }}" class="border-btn">View Courses</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="single-slider single-slider-bg-2">
                <div class="d-table">
                    <div class="d-table-cell">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-lg-12 text-center">
                                    <div class="slider-tittle two">
                                        <h1>
                                            Empowering <span>Young Minds</span>
                                        </h1>
                                        <p>
                                            With {{ $totalStudents }} students and a dedicated team of
                                            {{ $staffs->count() }} staff, we offer tailored programs across
                                            {{ $levels->count() }} educational levels to inspire lifelong learning.
                                        </p>
                                    </div>
                                    <div class="slider-btn bnt2">
                                        <a href="{{ url('admission') }}" class="box-btn">Admission</a>
                                        <a href="{{ url('classes') }}" class="border-btn">View Courses</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Slider area -->

    <!-- Service area -->
    <section class="service-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-sm-6">
                    <div class="single-service text-center">
                        <div class="service-icon">
                            <i class="flaticon-clock"></i>
                        </div>
                        <div class="service-content">
                            <h2>Opening Hours</h2>
                            <p>{{ 'Mon - Fri: 8:00AM - 4:00PM' }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="single-service text-center">
                        <div class="service-icon">
                            <i class="flaticon-pin"></i>
                        </div>
                        <div class="service-content">
                            <h2>Address</h2>
                            <p>{{ $schoolinfo->address }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <div class="single-service text-center sst-10">
                        <div class="service-icon">
                            <i class="flaticon-telephone"></i>
                        </div>
                        <div class="service-content">
                            <h2>Phone</h2>
                            <a
                                href="tel:{{ $schoolinfo->phone ?? '+1321984754' }}">{{ $schoolinfo->phone ?? '+1 (321) 984 754' }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Service area -->

    <div class="shape-ellips">
        <img src="{{ asset('front/assets/images/shape.png') }}" alt="shape" />
    </div>

    <!-- Regular Course area -->
    <section class="home-ragular-course pb-100">
        <div class="container">
            <div class="section-tittle text-center">
                <h2>Our Academic Programs</h2>
                <p>
                    Explore our diverse programs for Kindergarten, Primary, Junior, and Secondary levels, designed to foster
                    academic excellence and personal development.
                </p>
            </div>

            <div class="row">
                @foreach ($levels->take(3) as $level)
                    <div class="col-lg-4 col-md-6">
                        <div class="single-ragular-course">
                            <div class="course-img">
                                <img src="{{ asset('front/assets/images/courses/img' . ($loop->index + 1) . '.png') }}"
                                    alt="regular" />
                                <h2>{{ $level->level_name }}</h2>
                            </div>
                            <div class="course-content">
                                <p>
                                    Our {{ $level->level_name }} program offers a comprehensive curriculum tailored to meet
                                    the developmental needs of students at this stage.
                                </p>
                                <a href="{{ url('classes') }}" class="border-btn">Read More</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- End Regular Course area -->

    <!-- Choose area -->
    <section class="choose-area">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 ps-0">
                    <div class="home-choose-img">
                        <img src="{{ asset('front/assets/images/choose1.png') }}" alt="choose" />
                    </div>
                </div>
                <div class="col-lg-6 home-choose">
                    <div class="home-choose-content">
                        <div class="section-tittle">
                            <h2>Why Choose {{ $schoolinfo->school_name ?? 'Educare' }}?</h2>
                            <p>
                                {{ 'We are committed to providing a nurturing environment where students from Kindergarten to Secondary levels thrive academically and socially.' }}
                            </p>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-sm-12 col-md-5">
                                <ul class="choose-list-left">
                                    <li><i class="flaticon-check-mark"></i>Top-Rated School</li>
                                    <li><i class="flaticon-check-mark"></i>Supportive Community</li>
                                    <li><i class="flaticon-check-mark"></i>Holistic Education</li>
                                    <li><i class="flaticon-check-mark"></i>Learning With Fun</li>
                                    <li><i class="flaticon-check-mark"></i>Student Safety</li>
                                </ul>
                            </div>
                            <div class="col-lg-8 col-sm-12 col-md-7">
                                <div class="choose-list-home">
                                    <ul>
                                        <li><i class="flaticon-check-mark"></i>Eco-Friendly Campus</li>
                                        <li><i class="flaticon-check-mark"></i>Healthy Meals</li>
                                        <li><i class="flaticon-check-mark"></i>Certified Health Care</li>
                                        <li><i class="flaticon-check-mark"></i>Spacious Playground</li>
                                        <li><i class="flaticon-check-mark"></i>Safe Transportation</li>
                                    </ul>
                                </div>
                            </div>
                            <a href="{{ url('about') }}" class="box-btn">Know More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- End Choose area -->

    <!-- Admission Area -->
    <section class="home-admission">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="single-addmission">
                        <div class="row">
                            <div class="col-lg-4 col-md-5">
                                <div class="admission-circle">
                                    <h2>Admission <span>on Going</span></h2>
                                    <div class="admission-shape1">
                                        <img src="{{ asset('front/assets/images/admission/shape1.png') }}"
                                            alt="shape" />
                                    </div>
                                    <div class="admission-shape2">
                                        <img src="{{ asset('front/assets/images/admission/shape2.png') }}"
                                            alt="shape" />
                                    </div>
                                    <div class="admission-shape3">
                                        <img src="{{ asset('front/assets/images/admission/shape3.png') }}"
                                            alt="shape" />
                                    </div>
                                    <div class="admission-shape4">
                                        <img src="{{ asset('front/assets/images/admission/shape4.png') }}"
                                            alt="shape" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-7">
                                <div class="admission-content">
                                    <h2>Admission Open</h2>
                                    <p>
                                        Admission closes
                                        {{ \Carbon\Carbon::parse($schoolinfo->next_term_begin_date)->format('jS F Y') ?? '30th March 2025' }}.
                                        Time Remaining:
                                    </p>
                                    <ul class="admission-list">
                                        <li>
                                            <p id="days"></p>
                                            <span>Days</span>
                                        </li>
                                        <li>
                                            <p id="hours"></p>
                                            <span>Hours</span>
                                        </li>
                                        <li>
                                            <p id="minutes"></p>
                                            <span>Minutes</span>
                                        </li>
                                        <li>
                                            <p id="seconds"></p>
                                            <span>Seconds</span>
                                        </li>
                                    </ul>
                                    <a href="{{ url('admission') }}" class="box-btn">Admission Now</a>
                                </div>
                            </div>

                        </div>
                        <span class="loon">
                            <img src="{{ asset('front/assets/images/admission/shape5.png') }}" alt="shape" />
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Admission Area -->

    <!-- Special Course -->
    <section class="home-special-course">
        <div class="container-fluid">
            <div class="section-tittle text-center">
                <h2>Our Special Classes</h2>
                <p>
                    Discover our engaging extracurricular programs designed to enhance creativity and skills across all
                    educational levels.
                </p>
            </div>

            <div class="home-course-slider owl-carousel owl-theme">
                @foreach (['Painting Class', 'Science Lab', 'Music Class', 'Art Class'] as $index => $specialClass)
                    <div class="single-home-special-course">
                        <div class="course-img">
                            <img src="{{ asset('front/assets/images/courses/img' . ($index + 4) . '.png') }}"
                                alt="course" />
                            <div class="course-content">
                                <h2>{{ $specialClass }}</h2>
                                <p>
                                    Our {{ $specialClass }} offers students a chance to explore their creativity and
                                    develop new skills in a fun, supportive environment.
                                </p>
                                <a href="{{ url('single-class') }}" class="box-btn">Read More</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- End Special Course -->

    <!-- Course Slider -->
    <section class="course-slider-area">
        <div class="container">
            <div class="course-slider owl-carousel owl-theme">
                <div class="row align-items-center">
                    <div class="col-lg-5 col-md-5">
                        <div class="course-slider-img">
                            <img src="{{ asset('front/assets/images/courses/slider-img.png') }}" alt="course" />
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7">
                        <div class="course-slider-content">
                            <h2>Cultural Program {{ $schoolinfo->event_date ?? '01 April 2025' }}</h2>
                            <p>
                                Join our vibrant cultural program celebrating the talents of our {{ $totalStudents }}
                                students across Kindergarten to Secondary levels.
                            </p>
                            <div class="course-slider-btn">
                                <a href="{{ url('contact') }}" class="box-btn">Register Now</a>
                                <a href="{{ url('events') }}" class="border-btn">See More Events</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-lg-5 col-md-5">
                        <div class="course-slider-img">
                            <img src="{{ asset('front/assets/images/courses/slider-img2.png') }}" alt="course" />
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7">
                        <div class="course-slider-content">
                            <h2>Annual Program {{ '01 April 2025' }}</h2>
                            <p>
                                Our annual program showcases the achievements of our students and staff, fostering community
                                spirit across all {{ $levels->count() }} levels.
                            </p>
                            <div class="course sliders-btn">
                                <a href="{{ url('contact') }}" class="box-btn">Register Now</a>
                                <a href="{{ url('events') }}" class="border-btn">See More Events</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Course Slider -->

    <span class="left-shape">
        <img src="{{ asset('front/assets/images/left-shape.png') }}" alt="shape" />
    </span>


    <!-- Teachers Area -->
    <section class="home-teachers-area">
        <div class="container">
            <div class="section-tittle text-center">
                <h2>Our Dedicated Teachers</h2>
                <p>
                    Meet our team of {{ $staffs->count() }} dedicated educators shaping the future of our students.
                </p>
            </div>

            <div class="row">
                @foreach ($staffs->take(4) as $staff)
                    <div class="col-lg-3 col-sm-6">
                        <div class="single-home-teacher">
                            <div class="teacher-img">
                                <a href="{{ url('single-teacher') }}">
                                    <img src="{{ asset('storage/' . $staff->photo) }}" alt="teacher" />
                                </a>
                            </div>
                            <div class="teachers-content">
                                <h2>{{ $staff->name }}</h2>
                                <p>{{ $staff->role ?? 'Teacher' }}</p>
                            </div>
                            <div class="teacher-social">
                                <ul>
                                    <li>
                                        <a href="https://www.facebook.com/login/" target="_blank"><i
                                                class="flaticon-facebook"></i></a>
                                    </li>
                                    <li>
                                        <a href="https://twitter.com/i/flow/login" target="_blank"><i
                                                class="flaticon-twitter"></i></a>
                                    </li>
                                    <li>
                                        <a href="{{ url('contact') }}"><i class="flaticon-envelope"></i></a>
                                    </li>
                                    <li>
                                        <a href="{{ url('about') }}"><i class="flaticon-right-arrow"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- End Teachers Area -->

    <!-- Contact Area -->
    <section class="home-contact-area pb-100 pt-100">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 ps-0">
                    <div class="contact-img">
                        <img src="{{ asset('front/assets/images/contact.png') }}" alt="contact" />
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="home-contact-content">
                        <h2>Contact Us</h2>
                        <form id="contactForm" action="{{ url('contact') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <input type="text" name="name" id="name" class="form-control"
                                            required placeholder="Your Name" />
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <input type="email" name="email" id="email" class="form-control"
                                            required placeholder="Your Email" />
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <input type="text" name="phone_number" id="phone_number" class="form-control"
                                            required placeholder="Your Phone" />
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <input type="text" name="msg_subject" id="msg_subject" class="form-control"
                                            required placeholder="Your Subject" />
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <textarea name="message" class="form-control" id="message" cols="30" rows="5" required
                                            placeholder="Your Message"></textarea>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <button type="submit" class="default-btn page-btn box-btn">
                                        Send Message
                                    </button>
                                    <div id="msgSubmit" class="h3 text-center hidden"></div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Contact Area -->
    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const targetDate = new Date("{{ $schoolinfo->next_term_begin_date ?? '2025-09-04' }}T00:00:00")
                    .getTime();

                const countdown = setInterval(function() {
                    const now = new Date().getTime();
                    const distance = targetDate - now;

                    if (distance < 0) {
                        clearInterval(countdown);
                        document.getElementById("days").innerHTML = "0";
                        document.getElementById("hours").innerHTML = "0";
                        document.getElementById("minutes").innerHTML = "0";
                        document.getElementById("seconds").innerHTML = "0";
                        return;
                    }

                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    document.getElementById("days").innerHTML = days;
                    document.getElementById("hours").innerHTML = hours;
                    document.getElementById("minutes").innerHTML = minutes;
                    document.getElementById("seconds").innerHTML = seconds;
                }, 1000);
            });
        </script>
    @endpush
@endsection
