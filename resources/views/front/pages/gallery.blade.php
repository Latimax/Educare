<!-- front/pages/gallery.blade.php -->

@extends('front.layouts.app')

@section('title', ($schoolinfo->school_name ?? 'Educare School') . ' - Gallery')

@section('content')
    <!-- Start Page Title Area -->
    <div class="banner-area gallery">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="container">
                    <div class="page-title-content">
                        <h2>Gallery at {{ $schoolinfo->school_name ?? 'Educare School' }}</h2>
                        <ul>
                            <li>
                                <a href="{{ url('/') }}"> Home </a>
                                <i class="flaticon-fast-forward"></i>
                                <p class="active">Gallery</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Title Area -->

    <!-- Gallery -->
    <section class="gallery-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-tittle text-center">
                        <h2>Our School in Pictures</h2>
                        <p>
                            Explore vibrant moments from {{ $schoolinfo->school_name ?? 'Educare School' }}, showcasing our students, staff, and facilities across Kindergarten, Primary, Junior, and Secondary levels.
                        </p>
                    </div>
                    <ul class="all-gall">
                        <li class="active" data-filter="*"><span>All</span></li>
                        <li data-filter=".students"><span>Students</span></li>
                        <li data-filter=".cultural"><span>Cultural Events</span></li>
                        <li data-filter=".facilities"><span>Facilities</span></li>
                        <li data-filter=".sports"><span>Sports</span></li>
                    </ul>
                </div>
            </div>
            <div class="row gall-list">
                @foreach($galleryItems as $item)
                    <div class="col-lg-4 col-md-6 item {{ $item->categories }}">
                        <div class="single-gall">
                            <div class="gall-img">
                                <a href="{{ asset('storage/' . $item->image) }}" class="image-pop">
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="gallery" />
                                </a>
                            </div>
                            <div class="gall-content">
                                <h3>{{ $item->title }}</h3>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    @if (!empty($galleryItems))
                        {{ $galleryItems->links() }}
                    @endif

                </div>
            </div>
        </div>
    </section>
    <!-- End Gallery -->
@endsection
