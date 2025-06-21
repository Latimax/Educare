<!-- front/pages/about.blade.php -->

@extends('front.layouts.app')

@section('title', ($schoolinfo->school_name ?? 'Educare School') . ' - About Us')

@section('content')
    <!-- Start Page Title Area -->
    <div class="banner-area about">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="container">
                    <div class="page-title-content">
                        <h2>About {{ $schoolinfo->school_name ?? 'Educare School' }}</h2>
                        <ul>
                            <li>
                                <a href="{{ url('/') }}"> Home </a>
                                <i class="flaticon-fast-forward"></i>
                                <p class="active"> About</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Title Area -->

    <!-- About Area -->
    <section class="about-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-7">
                    <div class="single-about">
                        <div class="about-img">
                            <img src="{{ asset('front/assets/images/about-img.png') }}" alt="about" />
                        </div>
                        <div class="about-contnet">
                            <h2>{{ $schoolinfo->school_name ?? 'Educare National Children School & Center' }}</h2>
                            <p>
                                {{ $schoolinfo->about_description ?? 'At ' . ($schoolinfo->school_name ?? 'Educare School') . ', we are dedicated to providing a nurturing and inclusive educational environment for students from Kindergarten through Secondary levels. With a community of ' . $totalStudents . ' students and ' . $staffs->count() . ' dedicated staff, our programs across ' . $levels->count() . ' educational levels foster academic excellence, creativity, and personal growth. Our mission is to empower young minds with the skills and values needed for a successful future.' }}
                            </p>
                        </div>
                        <div class="about-btn">
                            <a href="{{ url('about') }}" class="box-btn">Know More</a>
                            <a href="{{ $schoolinfo->video_url ?? 'https://www.youtube.com/watch?v=_ysd-zHamjk' }}" class="video-pop">
                                <span class="video"> <i class="fa fa-play"></i> </span> Quick View at {{ $schoolinfo->school_name ?? 'Educare' }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-5">
                    <div class="about-content-right">
                        <form action="{{ url('search') }}" method="GET">
                            <div class="input-group">
                                <input type="text" name="query" class="form-control about-search" placeholder="Search..." />
                            </div>
                            <button type="submit" class="search-btn"> <i class="flaticon-search"></i></button>
                        </form>
                        <p class="visit">Visit More</p>
                        <ul class="about-list">
                            <li>
                                <a href="{{ url('classes') }}"> <i class="flaticon-next"></i>Classes</a>
                            </li>
                            <li>
                                <a href="{{ url('admission') }}"> <i class="flaticon-next"></i>Admission</a>
                            </li>
                            <li>
                                <a href="{{ url('special-class') }}"> <i class="flaticon-next"></i>Special Courses</a>
                            </li>
                            <li>
                                <a href="{{ url('events') }}"> <i class="flaticon-next"></i>Events</a>
                            </li>
                            <li>
                                <a href="{{ url('news') }}"> <i class="flaticon-next"></i>News</a>
                            </li>
                            <li>
                                <a href="{{ url('teachers') }}"> <i class="flaticon-next"></i>Teachers</a>
                            </li>
                        </ul>
                        <div class="consultation-area">
                            <h2>Get Free Consultation</h2>
                            <form action="{{ url('consultation') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" name="full_name" class="form-control" placeholder="Full name" required />
                                    </div>
                                    <div class="col-md-12">
                                        <input type="email" name="email" class="form-control" placeholder="Your Email" required />
                                    </div>
                                    <div class="col-md-12">
                                        <input type="text" name="phone" class="form-control" placeholder="Phone" required />
                                    </div>
                                    <div class="col-md-12">
                                        <textarea name="message" placeholder="Message" class="form-control" required></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="box-btn">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End About Area -->

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
                                {{ $schoolinfo->mission_statement ?? 'We empower parents to choose a school that aligns with their child’s unique needs. Our comprehensive programs across Kindergarten, Primary, Junior, and Secondary levels ensure a nurturing and academically rigorous environment for ' . $totalStudents . ' students.' }}
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
    </section>
    <!-- End Choose area -->

    <!-- Teachers Area -->
    <section class="home-teachers-area pt-100">
        <div class="container">
            <div class="section-tittle text-center">
                <h2>Our Dedicated Teachers</h2>
                <p>
                    Our team of {{ $staffs->count() }} educators is committed to guiding students across {{ $levels->count() }} educational levels toward academic and personal success.
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
                                        <input type="text" name="name" id="name" class="form-control" required placeholder="Your Name" />
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <input type="email" name="email" id="email" class="form-control" required placeholder="Your Email" />
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <input type="text" name="phone_number" id="phone_number" class="form-control" required placeholder="Your Phone" />
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <input type="text" name="msg_subject" id="msg_subject" class="form-control" required placeholder="Your Subject" />
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <textarea name="message" class="form-control" id="message" cols="30" rows="5" required placeholder="Your Message"></textarea>
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
@endsection
