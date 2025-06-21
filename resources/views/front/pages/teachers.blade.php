<!-- front/pages/teachers.blade.php -->

@extends('front.layouts.app')

@section('title', ($schoolinfo->school_name ?? 'Educare School') . ' - Our Teachers')

@section('content')
    <!-- Start Page Title Area -->
    <div class="banner-area teachers">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="container">
                    <div class="page-title-content">
                        <h2>Our Teachers at {{ $schoolinfo->school_name ?? 'Educare School' }}</h2>
                        <ul>
                            <li>
                                <a href="{{ url('/') }}"> Home </a>
                                <i class="flaticon-fast-forward"></i>
                                <p class="active"> Teachers </p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Title Area -->

    <!-- Teachers -->
    <section class="teachers-area">
        <div class="container">
            <div class="section-tittle text-center">
                <h2>Meet Our Educators</h2>
                <p>
                    Our dedicated team of {{ $staffs->count() }} educators supports {{ $totalStudents }} students across
                    {{ $levels->count() }} educational levels, fostering academic excellence and personal growth.
                </p>
            </div>
            <div class="row">
                @foreach ($staffs as $staff)
                    <div class="col-lg-3 col-sm-6">
                        <div class="single-teacher">
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
                                        <a href="{{ $staff->facebook_url ?? 'https://www.facebook.com/login/' }}"
                                            target="_blank"><i class="flaticon-facebook"></i></a>
                                    </li>
                                    <li>
                                        <a href="{{ $staff->twitter_url ?? 'https://twitter.com/i/flow/login' }}"
                                            target="_blank"><i class="flaticon-twitter"></i></a>
                                    </li>
                                    <li>
                                        <a href="{{ url('contact') }}"><i class="flaticon-envelope"></i></a>
                                    </li>
                                    <li>
                                        <a href="{{ url('single-teacher') }}"><i class="flaticon-right-arrow"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    {{ $staffs->links() }}
                </div>
            </div>
        </div>
    </section>
    <!-- End Teachers -->

    <!-- Contact Area -->
    <section class="home-contact-area pb-100">
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
                                        <input type="text" name="name" id="name" class="form-control" required
                                            placeholder="Your Name" />
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <input type="email" name="email" id="email" class="form-control" required
                                            placeholder="Your Email" />
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
@endsection
