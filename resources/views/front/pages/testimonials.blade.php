<!-- front/pages/testimonials.blade.php -->

@extends('front.layouts.app')

@section('title', ($schoolinfo->school_name ?? 'Educare School') . ' - Testimonials')

@section('content')
    <!-- Start Page Title Area -->
    <div class="banner-area testimonials">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="container">
                    <div class="page-title-content">
                        <h2>Testimonials at {{ $schoolinfo->school_name ?? 'Educare School' }}</h2>
                        <ul>
                            <li>
                                <a href="{{ url('/') }}"> Home </a>
                                <i class="flaticon-fast-forward"></i>
                                <p class="active">Testimonials</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Title Area -->

    <!-- Testimonials -->
    <div class="testimonials-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-tittle text-center">
                        <h2>What Our Community Says</h2>
                        <p>
                            Hear from parents, students, and alumni about how {{ $schoolinfo->school_name ?? 'Educare School' }} fosters academic excellence and character development across Kindergarten, Primary, Junior, and Secondary levels.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="single-testimonials">
                        <div class="testimonials-head">
                            <div class="row align-items-center">
                                <div class="col-lg-3 col-md-3 col-5">
                                    <div class="testimonials-img">
                                        <img src="{{ asset('front/assets/images/testimonials/img1.png') }}" alt="testimonial" />
                                    </div>
                                </div>
                                <div class="col-lg-9 col-md-9 col-7">
                                    <div class="content">
                                        <h2>Chinwe Okonkwo</h2>
                                        <span>Parent</span>
                                        <ul class="rate">
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="testimonials-foot">
                            <p>My daughter has grown in confidence and discipline. The teachers are caring and dedicated, creating a nurturing environment for learning.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="single-testimonials">
                        <div class="testimonials-head">
                            <div class="row align-items-center">
                                <div class="col-lg-3 col-md-3 col-5">
                                    <div class="testimonials-img">
                                        <img src="{{ asset('front/assets/images/testimonials/img2.png') }}" alt="testimonial" />
                                    </div>
                                </div>
                                <div class="col-lg-9 col-md-9 col-7">
                                    <div class="content">
                                        <h2>Abdullahi Musa</h2>
                                        <span>Alumnus</span>
                                        <ul class="rate">
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="testimonials-foot">
                            <p>The science labs and cultural programs prepared me for university. This school gave me skills and values that I use in my career today.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="single-testimonials">
                        <div class="testimonials-head">
                            <div class="row align-items-center">
                                <div class="col-lg-3 col-md-3 col-5">
                                    <div class="testimonials-img">
                                        <img src="{{ asset('front/assets/images/testimonials/img3.png') }}" alt="testimonial" />
                                    </div>
                                </div>
                                <div class="col-lg-9 col-md-9 col-7">
                                    <div class="content">
                                        <h2>Funmilayo Adebayo</h2>
                                        <span>Parent</span>
                                        <ul class="rate">
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="testimonials-foot">
                            <p>My son enjoys the extracurricular activities like sports and drama. The school’s focus on holistic education is commendable.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="single-testimonials">
                        <div class="testimonials-head">
                            <div class="row align-items-center">
                                <div class="col-lg-3 col-md-3 col-5">
                                    <div class="testimonials-img">
                                        <img src="{{ asset('front/assets/images/testimonials/img4.png') }}" alt="testimonial" />
                                    </div>
                                </div>
                                <div class="col-lg-9 col-md-9 col-7">
                                    <div class="content">
                                        <h2>Emeka Nwosu</h2>
                                        <span>Student</span>
                                        <ul class="rate">
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="testimonials-foot">
                            <p>I’ve excelled in mathematics because my teachers are patient and make lessons engaging. I love being part of this school.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="single-testimonials">
                        <div class="testimonials-head">
                            <div class="row align-items-center">
                                <div class="col-lg-3 col-md-3 col-5">
                                    <div class="testimonials-img">
                                        <img src="{{ asset('front/assets/images/testimonials/img5.png') }}" alt="testimonials">
                                    </div>
                                </div>
                                <div class="col-lg-9 col-md-9 col-7">
                                    <div class="content">
                                        <h2>Aisha Bello</h2>
                                        <span>Parent</span>
                                        <ul class="rate">
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="testimonials-foot">
                            <p>The blend of academic rigor and moral instruction has helped my children grow into responsible individuals.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="single-testimonials">
                        <div class="testimonials-head">
                            <div class="row align-items-center">
                                <div class="col-lg-3 col-md-3 col-5">
                                    <div class="testimonials-img">
                                        <img src="{{ asset('front/assets/images/testimonials/img6.png') }}" alt="testimonial" />
                                    </div>
                                </div>
                                <div class="col-lg-9 col-md-9 col-7">
                                    <div class="content">
                                        <h2>Tunde Olatunji</h2>
                                        <span>Alumnus</span>
                                        <ul class="rate">
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="testimonials-foot">
                            <p>The supportive community and strong academic foundation helped me succeed in my professional life.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Testimonials -->
@endsection
