<!-- front/pages/classes.blade.php -->

@extends('front.layouts.app')

@section('title', ($schoolinfo->school_name ?? 'Educare School') . ' - Classes')

@section('content')
    <!-- Start Page Title Area -->
    <div class="banner-area classes">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="container">
                    <div class="page-title-content">
                        <h2>Classes at {{ $schoolinfo->school_name ?? 'Educare School' }}</h2>
                        <ul>
                            <li>
                                <a href="{{ url('/') }}"> Home </a>
                                <i class="flaticon-fast-forward"></i>
                                <p class="active">Classes</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Title Area -->

    <!-- Classes -->
    <section class="class-area">
        <div class="container">
            <div class="section-tittle text-center">
                <h2>Our Academic Programs</h2>
                <p>
                    Discover our comprehensive classes across {{ $levels->count() }} educational levels, serving {{ $totalStudents }} students with tailored curricula delivered by {{ $staffs->count() }} dedicated educators.
                </p>
            </div>
            <div class="row">
                @foreach($classes as $class)
                    <div class="col-lg-4 col-md-6">
                        <div class="single-ragular-course">
                            <div class="course-img">
                                <img src="{{ asset('front/assets/images/courses/img' . ($loop->index % 12 + 1) . '.png') }}" alt="regular" />
                                <h2>{{ $class->class_name }}</h2>
                            </div>
                            <div class="course-content">
                                <p>
                                    {{ 'Our ' . $class->class_name . ' program offers a dynamic curriculum designed to foster academic growth and critical thinking skills.' }}
                                </p>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>
    <!-- End Classes -->
@endsection
