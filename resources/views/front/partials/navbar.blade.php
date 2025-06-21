<!-- ======= Top Header with Address and Login Links ======= -->
<header class="py-2 border-bottom d-none d-lg-block" style=" background-color: #1D42D9">

    <div class="container d-flex justify-content-between align-items-center flex-wrap">
        <div class="text-light small">
            <i class="flaticon-location"></i>
            {{ $schoolinfo->address ?? 'School Address' }}
        </div>
        <div class="text-end">
            <a href="{{ url('student/login') }}" class="text-light small me-3">Student </a>|
            <a href="{{ url('parent/login') }}" class="text-light small me-3">&nbsp;&nbsp;Parent </a>|
            <a href="{{ url('staff/login') }}" class="text-light small me-3">&nbsp;&nbsp;Staff </a>|
            <a href="{{ url('admin/login') }}" class="text-light small">&nbsp;&nbsp;Admin </a>
        </div>
    </div>
</header>

<!-- ======= Notification Marquee ======= -->
<div id="notification-bar" class="bg-transparent py-1 text-secondary position-relative">
    <button type="button" class="position-absolute top-0 start-0 mt-1 me-2 text-danger btn-close-marquee" onclick="document.getElementById('notification-bar').style.display='none'" style="background: none; border: none; font-size: 1.2rem;">&times;</button>

    <marquee behavior="scroll" direction="left" scrollamount="5">
        📢 Welcome to {{ $schoolinfo->school_name ?? 'Our School' }}! Admissions are open. Visit our Contact Page or call {{ $schoolinfo->phone ?? '+0000000000' }}.
    </marquee>
</div>


<!-- front/partials/navbar.blade.php -->
<div class="navbar-area">
    <div class="mobile-nav">
        <a href="{{ url('/') }}" class="logo">
            <img src="{{ asset($imgpath . 'logo.png') }}" class="main-logo" alt="logo" />
            <img src="{{ asset($imgpath . 'white-logo.png') }}" class="white-logo" alt="logo" />
        </a>
    </div>

    <div class="main-nav">
        <div class="container">
            <nav class="navbar navbar-expand-md navbar-light">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset($imgpath . 'logo.png') }}" class="main-logo" alt="logo" />
                    <img src="{{ asset($imgpath . 'white-logo.png') }}" class="white-logo" alt="logo" />
                </a>
                <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                    <ul class="navbar-nav text-right">
                        <li class="nav-item">
                            <a href="{{ url('/') }}"
                                class="nav-link {{ Request::is('/') ? 'active' : '' }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('about') }}"
                                class="nav-link {{ Request::is('about') ? 'active' : '' }}">About</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link dropdown-toggle">Classes</a>
                            <ul class="dropdown-menu">
                                <li class="nav-item">
                                    <a href="{{ url('classes') }}" class="nav-link">Classes</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('special-class') }}" class="nav-link">Special Courses</a>
                                </li>

                            </ul>
                        </li>

                         <li class="nav-item">
                            <a href="{{ url('teachers') }}"
                                class="nav-link {{ Request::is('teachers') ? 'active' : '' }}">Teachers</a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link dropdown-toggle">Pages</a>
                            <ul class="dropdown-menu">
                                <li class="nav-item">
                                    <a href="{{ url('admission') }}" class="nav-link">Admission</a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('gallery') }}" class="nav-link">Gallery</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('testimonials') }}" class="nav-link">Testimonials</a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('faq') }}" class="nav-link">FAQ</a>
                                </li>

                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('contact') }}"
                                class="nav-link {{ Request::is('contact') ? 'active' : '' }}">Contact</a>
                        </li>

                         <li class="nav-item">
                            <a href="#" class="nav-link dropdown-toggle">Login</a>
                            <ul class="dropdown-menu">
                                <li class="nav-item">
                                    <a href="{{ url('student/') }}" class="nav-link">Student</a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('parent/') }}" class="nav-link">Parents</a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('staff/') }}" class="nav-link">Staff</a>
                                </li>

                            </ul>
                        </li>

                    </ul>
                </div>
            </nav>
        </div>
    </div>
</div>
