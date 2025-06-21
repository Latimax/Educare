<!-- front/pages/special-class.blade.php -->

@extends('front.layouts.app')

@section('title', ($schoolinfo->school_name ?? 'Educare School') . ' - Special Classes')

@section('content')
    <!-- Start Page Title Area -->
    <div class="banner-area special-class">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="container">
                    <div class="page-title-content">
                        <h2>Special Classes at {{ $schoolinfo->school_name ?? 'Educare School' }}</h2>
                        <ul>
                            <li>
                                <a href="{{ url('/') }}"> Home </a>
                                <i class="flaticon-fast-forward"></i>
                                <p class="active">Special Classes</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Title Area -->

    <!-- Special Class -->
    <section class="special-single-class">
        <div class="container">
            <div class="section-tittle text-center">
                <h2>Our Extracurricular Programs</h2>
                <p>
                    Explore our engaging special classes designed to enhance creativity and skills for students across Kindergarten, Primary, Junior, and Secondary levels.
                </p>
            </div>
            <div class="row">
                <div class="col-lg-4 col-sm-6">
                    <div class="single-sp-class">
                        <div class="course-img">
                            <img src="{{ asset('front/assets/images/courses/img4.png') }}" alt="course" />
                            <div class="course-content">
                                <h2>Painting Class</h2>
                                <p>
                                    Our Painting Class encourages students to explore their creativity through various art techniques in a supportive environment.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="single-sp-class">
                        <div class="course-img">
                            <img src="{{ asset('front/assets/images/courses/img5.png') }}" alt="course" />
                            <div class="course-content">
                                <h2>Science Class</h2>
                                <p>
                                    Our Science Class offers hands-on experiments to spark curiosity and deepen understanding of scientific concepts.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="single-sp-class">
                        <div class="course-img">
                            <img src="{{ asset('front/assets/images/courses/img6.png') }}" alt="course" />
                            <div class="course-content">
                                <h2>Music Class</h2>
                                <p>
                                    Our Music Class provides instruction in playing instruments and singing, fostering musical talent and appreciation.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="single-sp-class">
                        <div class="course-img">
                            <img src="{{ asset('front/assets/images/courses/img7.png') }}" alt="course" />
                            <div class="course-content">
                                <h2>Art Class</h2>
                                <p>
                                    Our Art Class allows students to express themselves through various artistic mediums, enhancing their creative skills.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="single-sp-class">
                        <div class="course-img">
                            <img src="{{ asset('front/assets/images/courses/img8.png') }}" alt="course" />
                            <div class="course-content">
                                <h2>Dance Class</h2>
                                <p>
                                    Our Dance Class offers instruction in various dance styles, promoting physical fitness and artistic expression.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="single-sp-class">
                        <div class="course-img">
                            <img src="{{ asset('front/assets/images/courses/img9.png') }}" alt="course" />
                            <div class="course-content">
                                <h2>Lab Class</h2>
                                <p>
                                    Our Lab Class provides practical experience in scientific inquiry, equipping students with essential laboratory skills.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Special Class -->

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
